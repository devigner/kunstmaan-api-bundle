<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Model\PageParts;

use Devigner\KunstmaanApiBundle\Entity\FormModelInterface;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

abstract class AbstractFormPagePart extends AbstractPagePart
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $label;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $internalName;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $errorMessageRequired;

    /**
     * @var bool
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("bool")
     * @OA\Property(type="bool")
     */
    private $required;

    /**
     * @param FormModelInterface $pagePart
     */
    public function __construct(FormModelInterface $pagePart)
    {
        $this->label = $pagePart->getLabel();
        $this->internalName = $pagePart->getInternalName();
        $this->required = $pagePart->getRequired();
        $this->errorMessageRequired = $pagePart->getErrorMessageRequired();
        parent::__construct($pagePart);
    }
}
