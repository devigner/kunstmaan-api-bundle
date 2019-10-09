<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
