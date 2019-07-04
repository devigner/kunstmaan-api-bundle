<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Entity;

interface EntityInjectionInterface
{
    /**
     * @return string[]|array
     */
    public function getProvider(): array;

    /**
     * @return int
     */
    public function getMaxResults(): int;
}
