<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Model\PageParts;

use Devigner\KunstmaanApiBundle\Entity\PagePartsModelInterface;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

abstract class AbstractPagePart
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $type;

    /**
     * @param PagePartsModelInterface $pagePart
     */
    public function __construct(PagePartsModelInterface $pagePart)
    {
        try {
            $this->type = (new \ReflectionClass(get_called_class()))->getShortName();
        } catch (\ReflectionException $e) {
        }
    }
}
