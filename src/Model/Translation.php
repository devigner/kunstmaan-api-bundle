<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Model;

use JMS\Serializer\Annotation as JMS;
use Kunstmaan\TranslatorBundle\Entity\Translation as KumaTranslation;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class Translation
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $keyword;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $text;

    public function __construct(KumaTranslation $translation)
    {
        $this->keyword = $translation->getKeyword();
        $this->text = $translation->getText();
    }
}
