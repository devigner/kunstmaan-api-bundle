<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Traits;

use FOS\UserBundle\Model\UserManagerInterface;

trait UserManagerTrait
{
    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @required
     * @param UserManagerInterface $userManager
     */
    public function setUserManager(UserManagerInterface $userManager): void
    {
        $this->userManager = $userManager;
    }
}
