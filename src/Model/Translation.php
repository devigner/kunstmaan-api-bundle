<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Model;

use Kunstmaan\TranslatorBundle\Entity\Translation as KumaTranslation;
use JMS\Serializer\Annotation as JMS;
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
