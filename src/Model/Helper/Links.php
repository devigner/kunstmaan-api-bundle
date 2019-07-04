<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Model\Helper;

use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
final class Links
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $self;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $next;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $last;

    /**.
     * @param string $self
     * @param string $last
     * @param string|null $next
     */
    public function __construct(string $self, string $last, ?string $next = null)
    {
        $this->self = $self;
        if (null !== $next) {
            $this->next = $next;
        }
        $this->last = $last;
    }
}
