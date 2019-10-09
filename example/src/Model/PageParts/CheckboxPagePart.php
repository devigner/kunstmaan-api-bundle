<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Model\PageParts;

use App\Entity\PageParts;
use Devigner\KunstmaanApiBundle\Model\PageParts\AbstractFormPagePart;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
final class CheckboxPagePart extends AbstractFormPagePart implements PagePartsEntityInterface
{
    /**
     * @param PageParts\CheckboxPagePart $pagePart
     */
    public function __construct(PageParts\CheckboxPagePart $pagePart)
    {
        parent::__construct($pagePart);
    }
}
