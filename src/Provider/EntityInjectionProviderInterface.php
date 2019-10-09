<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Provider;

use Symfony\Component\HttpFoundation\Request;

interface EntityInjectionProviderInterface
{
    /**
     * @return string
     */
    public function getNamespace():string;

    /**
     * @param Request $request
     * @param int $maxResult
     */
    public function executeService(Request $request, int $maxResult): void;

    /**
     * @return string
     */
    public function getCurrentPage(): string;

    /**
     * @return string|null
     */
    public function getNextPage(): ?string;

    /**
     * @return string
     */
    public function getLastPage(): string;

    /**
     * @return array
     */
    public function getResults(): array;
}
