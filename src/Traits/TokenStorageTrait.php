<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Traits;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

trait TokenStorageTrait
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var AuthorizationCheckerInterface
     */
    protected $authorizationChecker;

    /**
     * @required
     * @param TokenStorageInterface $tokenStorage
     */
    public function setTokenStorage(TokenStorageInterface $tokenStorage): void
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @required
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function setAuthorizationChecker(AuthorizationCheckerInterface $authorizationChecker): void
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param string $role
     * @return bool
     */
    protected function isGranted(string $role): bool
    {
        return $this->authorizationChecker->isGranted($role);
    }

    protected function getUser()
    {
        if (!$this->tokenStorage instanceof TokenStorageInterface) {
            return null;
        }

        if (!$this->tokenStorage->getToken() instanceof TokenInterface) {
            return null;
        }

        if (!$this->tokenStorage->getToken()->getUser() instanceof UserInterface) {
            return null;
        }

        return $this->tokenStorage->getToken()->getUser();
    }
}
