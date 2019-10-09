<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Provider;

use App\Entity\Pages\NewsPage;
use App\Repository\NewsPageRepository;
use Devigner\KunstmaanApiBundle\Entity\PageModelInterface;
use Devigner\KunstmaanApiBundle\Model\PageEntityInterface;
use Devigner\KunstmaanApiBundle\Provider\AbstractProvider;
use Kunstmaan\NodeBundle\Entity\NodeTranslation;
use Kunstmaan\NodeBundle\Repository\NodeTranslationRepository;
use Symfony\Component\HttpFoundation\Request;

class NewsEntityInjectionProvider extends AbstractProvider
{
    public function getNamespace(): string
    {
        return 'news';
    }

    /**
     * @param Request $request
     * @param int $maxResult
     */
    public function executeService(Request $request, int $maxResult): void
    {
        $searchCategory = $request->get('category') ? explode(',', $request->get('category')) : null;
        $searchTag = $request->get('tag') ? explode(',', $request->get('tag')) : null;

        /** @var NewsPageRepository $pageRepository */
        $pageRepository = $this->entityManager->getRepository(NewsPage::class);
        $result = $pageRepository->getArticles($request->getLocale(), null, null, $searchCategory, $searchTag);

        $this->createPagerFanta($result, $maxResult, $request);

        $this->results = [];
        foreach ($this->pagerfanta->getCurrentPageResults() as $entity) {
            /** @var PageModelInterface $entity */
            /** @var PageEntityInterface $model */
            $model = $entity->getModel();
            $model->addNode($this->getNode($entity)->getNode(), $request->getLocale());

            $this->results[] = $model;
        }
    }

    /**
     * @return NodeTranslationRepository
     */
    protected function getNodeTranslationRepository(): NodeTranslationRepository
    {
        return $this->entityManager->getRepository(NodeTranslation::class);
    }

    /**
     * @param PageModelInterface $entity
     * @return NodeTranslation
     */
    protected function getNode(PageModelInterface $entity): NodeTranslation
    {
        return $this->getNodeTranslationRepository()->getNodeTranslationFor($entity);
    }
}
