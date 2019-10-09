<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Traits;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use function count;

trait SerializerTrait
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @param mixed $data
     * @param int $status
     * @param array $groups
     * @return JsonResponse
     */
    protected function serializedResponse($data, int $status, array $groups = []): JsonResponse
    {
        $context = SerializationContext::create();
        if (0 !== count($groups)) {
            $context->setGroups($groups);
        }
        return new JsonResponse(
            $this->serializer->serialize($data, 'json', $context),
            $status,
            [],
            true
        );
    }

    /**
     * @required
     * @param SerializerInterface $serializer
     */
    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }
}
