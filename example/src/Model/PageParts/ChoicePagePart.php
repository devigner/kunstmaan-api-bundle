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
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
final class ChoicePagePart extends AbstractFormPagePart implements PagePartsEntityInterface
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $expanded;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $choices;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $emptyValue;

    /**
     * @var bool
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("bool")
     * @OA\Property(type="bool")
     */
    private $multiple;

    /**
     * @param PageParts\ChoicePagePart $pagePart
     */
    public function __construct(PageParts\ChoicePagePart $pagePart)
    {
        $this->expanded = $pagePart->getExpanded();
        $this->choices = $pagePart->getChoices();
        $this->emptyValue = $pagePart->getEmptyValue();
        $this->multiple = $pagePart->getMultiple();

        parent::__construct($pagePart);
    }
}
