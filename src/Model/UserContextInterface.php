<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Model;

use FOS\UserBundle\Model\UserInterface;

interface UserContextInterface
{
    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user): void;
}
