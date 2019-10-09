<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
