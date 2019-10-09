<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Form\PageParts\ToTopPagePartAdminType;
use App\Model;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractPagePart;
use Devigner\KunstmaanApiBundle\Entity\PagePartsModelInterface;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_to_top_page_parts")
 * @ORM\Entity
 */
class ToTopPagePart extends AbstractPagePart implements PagePartsModelInterface
{
    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'PageParts/ToTopPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return ToTopPagePartAdminType::class;
    }

    /**
     * @return PagePartsEntityInterface
     */
    public function getModel(): PagePartsEntityInterface
    {
        return new Model\PageParts\ToTopPagePart($this);
    }
}
