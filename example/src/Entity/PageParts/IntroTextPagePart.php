<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Form\PageParts\IntroTextPagePartAdminType;
use App\Model;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractPagePart;
use Devigner\KunstmaanApiBundle\Entity\PagePartsModelInterface;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="app_intro_text_page_parts")
 * @ORM\Entity
 */
class IntroTextPagePart extends AbstractPagePart implements PagePartsModelInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'PageParts/IntroTextPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return IntroTextPagePartAdminType::class;
    }

    /**
     * @return PagePartsEntityInterface
     */
    public function getModel(): PagePartsEntityInterface
    {
        return new Model\PageParts\IntroTextPagePart($this);
    }
}
