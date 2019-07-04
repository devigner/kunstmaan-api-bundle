<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Repository;

use Kunstmaan\SeoBundle\Repository\SeoRepository;

trait SeoRepositoryTrait
{
    /**
     * @var SeoRepository
     */
    protected $seoRepository;

    /**
     *
     * @param SeoRepository $seoRepository
     */
    public function setSeoRepository(SeoRepository $seoRepository): void
    {
        $this->seoRepository = $seoRepository;
    }
}
