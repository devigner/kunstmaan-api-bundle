<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Traits;

use Symfony\Component\Routing\RouterInterface;

trait RouterTrait
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @required
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router): void
    {
        $this->router = $router;
    }
}
