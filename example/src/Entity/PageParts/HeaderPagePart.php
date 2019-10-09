<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Form\PageParts\HeaderPagePartAdminType;
use App\Model;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractPagePart;
use Devigner\KunstmaanApiBundle\Entity\PagePartsModelInterface;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="app_header_page_parts")
 * @ORM\Entity
 */
class HeaderPagePart extends AbstractPagePart implements PagePartsModelInterface
{
    /**
     * @var array Supported header sizes
     */
    public static $supportedHeaders = [1, 2, 3, 4, 5, 6];
    /**
     * @ORM\Column(name="niv", type="integer", nullable=true)
     * @Assert\NotBlank(message="headerpagepart.niv.not_blank")
     */
    private $niv;
    /**
     * @ORM\Column(name="title", type="string", nullable=true)
     * @Assert\NotBlank(message="headerpagepart.title.not_blank")
     */
    private $title;

    /**
     * Get niv
     *
     * @return int
     */
    public function getNiv(): int
    {
        return $this->niv;
    }

    /**
     * Set niv
     *
     * @param int $niv
     *
     * @return HeaderPagePart
     */
    public function setNiv(int $niv): self
    {
        $this->niv = $niv;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return HeaderPagePart
     */
    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'PageParts/HeaderPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return HeaderPagePartAdminType::class;
    }

    public function getModel(): PagePartsEntityInterface
    {
        return new Model\PageParts\HeaderPagePart($this);
    }
}
