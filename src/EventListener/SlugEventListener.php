<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\EventListener;

use FOS\UserBundle\Model\UserInterface;
use Kunstmaan\MenuBundle\Entity\MenuItem;
use Kunstmaan\MenuBundle\Repository\MenuItemRepository;
use Kunstmaan\NodeBundle\Entity\HasNodeInterface;
use Kunstmaan\NodeBundle\Entity\NodeTranslation;
use Kunstmaan\NodeBundle\Entity\NodeVersion;
use Kunstmaan\NodeBundle\Event\Events;
use Kunstmaan\NodeBundle\Event\SlugEvent;
use Kunstmaan\NodeBundle\Event\SlugSecurityEvent;
use Kunstmaan\NodeBundle\Helper\RenderContext;
use Kunstmaan\PagePartBundle\Entity\PagePartRef;
use Kunstmaan\PagePartBundle\Helper\HasPagePartsInterface;
use Kunstmaan\PagePartBundle\PagePartAdmin\PagePartAdminConfiguratorInterface;
use Kunstmaan\PagePartBundle\Repository\PagePartRefRepository;
use Kunstmaan\SeoBundle\Entity\Seo;
use Kunstmaan\SeoBundle\Repository\SeoRepository;
use Psr\Container\ContainerInterface;
use Devigner\KunstmaanApiBundle\Entity\EntityInjectionInterface;
use Devigner\KunstmaanApiBundle\Entity\PageModelInterface;
use Devigner\KunstmaanApiBundle\Entity\PagePartsModelInterface;
use Devigner\KunstmaanApiBundle\Event\AdminRequestEvent;
use Devigner\KunstmaanApiBundle\Model\ModelInjectionInterface;
use Devigner\KunstmaanApiBundle\Model\ModelSchemaInterface;
use Devigner\KunstmaanApiBundle\Model\PageParts\AbstractPagePart;
use Devigner\KunstmaanApiBundle\Model\UserContextInterface;
use Devigner\KunstmaanApiBundle\Provider\EntityInjectionProviderInterface;
use Devigner\KunstmaanApiBundle\Traits\EntityManagerTrait;
use Devigner\KunstmaanApiBundle\Traits\EventDispatcherTrait;
use Devigner\KunstmaanApiBundle\Traits\SerializerTrait;
use Devigner\KunstmaanApiBundle\Traits\TokenStorageTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SlugEventListener implements EventSubscriberInterface
{
    use EntityManagerTrait;
    use EventDispatcherTrait;
    use SerializerTrait;
    use TokenStorageTrait;

    /**
     * @var array
     */
    private $menus;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param array $menus
     */
    public function __construct(array $menus)
    {
        $this->menus = $menus;
    }

    /**
     * @required
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Events::SLUG_SECURITY => 'onSlugSecurity',
            Events::POST_SLUG_ACTION => 'onSlugAction',
        ];
    }

    public function onSlugSecurity(SlugSecurityEvent $event): void
    {
        $this->request = $event->getRequest();
    }

    /**
     * @param SlugEvent $event
     */
    public function onSlugAction(SlugEvent $event): void
    {
        $renderContext = $event->getRenderContext();
        if (!isset($renderContext['nodetranslation'])) {
            return;
        }

        $response = $this->createResponse($renderContext);
        if (null === $response) {
            return;
        }

        if ('_slug_preview' === $this->request->attributes->get('_route')) {
            $adminEvent = new AdminRequestEvent($this->request, $response);
            $this->eventDispatcher->dispatch(AdminRequestEvent::ADMIN_REQUEST, $adminEvent);
            if (null !== $adminEvent->getResponse()) {
                $event->setResponse($adminEvent->getResponse());
                return;
            }
        }

        $event->setResponse($response);
    }

    /**
     * @return HasNodeInterface|null
     */
    private function getPreviewVersion(): ?HasNodeInterface
    {
        $version = $this->request->get('version');
        if (null === $version) {
            return null;
        }

        if (!is_numeric($version)) {
            return null;
        }

        $nodeVersion = $this->entityManager->getRepository('KunstmaanNodeBundle:NodeVersion')->find($version);
        if (!$nodeVersion instanceof NodeVersion) {
            return null;
        }

        return $nodeVersion->getRef($this->entityManager);
    }

    /**
     * @param RenderContext $renderContext
     * @return Response|null
     */
    private function createResponse(RenderContext $renderContext): ?Response
    {
        /** @var NodeTranslation $nodeTranslation */
        $nodeTranslation = $renderContext['nodetranslation'];
        $entity = $this->getPreviewVersion();
        if (!$entity instanceof HasNodeInterface) {
            $entity = $nodeTranslation->getPublicNodeVersion()->getRef($this->entityManager);
        }

        $user = $this->getUser();
        if ($entity instanceof UserContextInterface && $user instanceof UserInterface) {
            $entity->setUser($user);
        }

        if (!$entity instanceof PageModelInterface) {
            return null;
        }

        $model = $entity->getSchemaModel($entity, $nodeTranslation->getNode(), $nodeTranslation->getLang());

        $seoEntity = $this->getSeoRepository()->findFor($entity);
        if ($seoEntity instanceof Seo) {
            $model->setSeo($seoEntity);
        }

        if ($entity instanceof EntityInjectionInterface && $model instanceof ModelInjectionInterface) {
            $this->injectEntity($entity, $model);
        }

        foreach ($this->menus as $menu) {
            $model->addMenu($menu, $this->getMenuItemRepository()->getMenuItemsForLanguage($menu, $nodeTranslation->getLang()), $this->request->getLocale());
        }

        if ($entity instanceof HasPagePartsInterface) {
            $this->addPageParts($entity, $model);
        }

        return $this->serializedResponse($model, Response::HTTP_OK);
    }

    /**
     * @param HasPagePartsInterface $entity
     * @param ModelSchemaInterface $model
     */
    private function addPageParts(HasPagePartsInterface $entity, ModelSchemaInterface $model): void
    {
        $parts = [];
        $configs = $entity->getPagePartAdminConfigurations();
        foreach ($configs as $config) {

            if ($config instanceof PagePartAdminConfiguratorInterface) {
                $config = $config->getName();
            }

            $pageParts = $this->getPagePartRefRepository()->getPageParts($entity, $config);

            foreach ($pageParts as $pagePart) {

                $part = get_class($pagePart);

                if ($pagePart instanceof PagePartsModelInterface) {
                    $part = $pagePart->getModel();
                }

                if ($pagePart instanceof AbstractPagePart) {
                    $part = $pagePart;
                }

                if ($pagePart instanceof EntityInjectionInterface && $part instanceof ModelInjectionInterface) {
                    $this->injectEntity($pagePart, $part);
                }

                $parts[] = $part;
            }
            $model->addParts($parts, $config);
        }
    }

    /**
     * @param EntityInjectionInterface $entity
     * @param ModelInjectionInterface $model
     */
    private function injectEntity(EntityInjectionInterface $entity, ModelInjectionInterface $model): void
    {
        foreach ($entity->getProvider() as $provider) {
            /** @var EntityInjectionProviderInterface $service */
            $service = $this->container->get($provider);
            if (!$service instanceof EntityInjectionProviderInterface) {
                continue;
            }

            $service->executeService($this->request, $entity->getMaxResults());

            $model->setLinks($service->getNamespace(), $service->getCurrentPage(), $service->getLastPage(), $service->getNextPage());
            $model->setChildren($service->getNamespace(), $service->getResults());
        }
    }

    /**
     * @return SeoRepository
     */
    private function getSeoRepository(): SeoRepository
    {
        return $this->entityManager->getRepository(Seo::class);
    }

    /**
     * @return MenuItemRepository
     */
    private function getMenuItemRepository(): MenuItemRepository
    {
        return $this->entityManager->getRepository(MenuItem::class);
    }

    /**
     * @return PagePartRefRepository
     */
    private function getPagePartRefRepository(): PagePartRefRepository
    {
        return $this->entityManager->getRepository(PagePartRef::class);
    }
}
