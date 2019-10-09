<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Form\PageParts\ButtonPagePartAdminType;
use App\Model;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractPagePart;
use Devigner\KunstmaanApiBundle\Entity\PagePartsModelInterface;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="app_button_page_parts")
 * @ORM\Entity
 */
class ButtonPagePart extends AbstractPagePart implements PagePartsModelInterface
{
    public const TYPE_PRIMARY = 'primary';
    public const TYPE_SECONDARY = 'secondary';
    public const TYPE_TERTIARY = 'tertiary';
    public const TYPE_QUATERNARY = 'quaternary';
    public const TYPE_LINK = 'link';
    public const SIZE_EXTRA_LARGE = 'xl';
    public const SIZE_LARGE = 'lg';
    public const SIZE_DEFAULT = 'default';
    public const SIZE_SMALL = 'sm';
    public const SIZE_EXTRA_SMALL = 'xs';
    public const POSITION_LEFT = 'left';
    public const POSITION_CENTER = 'center';
    public const POSITION_RIGHT = 'right';
    public const POSITION_BLOCK = 'block';
    /**
     * @var array Supported types
     */
    public static $types = [
        self::TYPE_PRIMARY,
        self::TYPE_SECONDARY,
        self::TYPE_TERTIARY,
        self::TYPE_QUATERNARY,
        self::TYPE_LINK
    ];
    /**
     * @var array Supported sizes
     */
    public static $sizes = [
        self::SIZE_EXTRA_LARGE,
        self::SIZE_LARGE,
        self::SIZE_DEFAULT,
        self::SIZE_SMALL,
        self::SIZE_EXTRA_SMALL
    ];
    /**
     * @var array Supported positions
     */
    public static $positions = [
        self::POSITION_LEFT,
        self::POSITION_CENTER,
        self::POSITION_RIGHT,
        self::POSITION_BLOCK
    ];
    /**
     * @var string
     *
     * @ORM\Column(name="link_text", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $linkText;
    /**
     * @var string
     *
     * @ORM\Column(name="link_url", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    private $linkUrl;
    /**
     * @var boolean
     *
     * @ORM\Column(name="link_new_window", type="boolean", nullable=true)
     */
    private $linkNewWindow;
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=15, nullable=true)
     * @Assert\NotBlank()
     */
    private $type;
    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=15, nullable=true)
     * @Assert\NotBlank()
     */
    private $size;
    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=15, nullable=true)
     * @Assert\NotBlank()
     */
    private $position;

    public function __construct()
    {
        $this->type = self::TYPE_PRIMARY;
        $this->size = self::SIZE_DEFAULT;
        $this->position = self::POSITION_LEFT;
    }

    /**
     * @return boolean
     */
    public function isLinkNewWindow(): bool
    {
        if (null === $this->linkNewWindow) {
            $this->linkNewWindow = false;
        }

        return $this->linkNewWindow;
    }

    /**
     * @param boolean $linkNewWindow
     */
    public function setLinkNewWindow(bool $linkNewWindow): void
    {
        $this->linkNewWindow = $linkNewWindow;
    }

    /**
     * @return string
     */
    public function getLinkText(): ?string
    {
        return $this->linkText;
    }

    /**
     * @param string $linkText
     */
    public function setLinkText(string $linkText): void
    {
        $this->linkText = $linkText;
    }

    /**
     * @return string
     */
    public function getLinkUrl(): ?string
    {
        return $this->linkUrl;
    }

    /**
     * @param string $linkUrl
     */
    public function setLinkUrl($linkUrl): void
    {
        $this->linkUrl = $linkUrl;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param string $type
     * @throws InvalidArgumentException
     */
    public function setType(string $type): void
    {
        if (!in_array($type, self::$types, true)) {
            throw new InvalidArgumentException("Type $type not supported");
        }

        $this->type = $type;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize(): ?string
    {
        return $this->size;
    }

    /**
     * Set size
     *
     * @param string $size
     * @throws InvalidArgumentException
     */
    public function setSize(string $size): void
    {
        if (!in_array($size, self::$sizes, true)) {
            throw new InvalidArgumentException("Size $size not supported");
        }
        $this->size = $size;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition(): ?string
    {
        return $this->position;
    }

    /**
     * Set position
     *
     * @param string $position
     * @throws InvalidArgumentException
     */
    public function setPosition(string $position): void
    {
        if (!in_array($position, self::$positions, true)) {
            throw new InvalidArgumentException("Position $position not supported");
        }
        $this->position = $position;
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'PageParts/ButtonPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return ButtonPagePartAdminType::class;
    }

    public function getModel(): PagePartsEntityInterface
    {
        return new Model\PageParts\ButtonPagePart($this);
    }
}
