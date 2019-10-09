<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Model;

interface ModelInjectionInterface
{
    /**
     * @param string $namespace
     * @param array $children
     */
    public function setChildren(string $namespace, array $children): void;

    /**
     * @param string $namespace
     * @param string $self
     * @param string $last
     * @param string|null $next
     */
    public function setLinks(string $namespace, string $self, string $last, ?string $next = null): void;
}
