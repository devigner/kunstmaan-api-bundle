<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Model;

use FOS\UserBundle\Model\UserInterface;

interface UserContextInterface
{
    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user): void;
}
