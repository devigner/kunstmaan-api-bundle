<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Traits;

use FOS\UserBundle\Util\TokenGeneratorInterface;

trait TokenGeneratorTrait
{
    /**
     * @var TokenGeneratorInterface
     */
    protected $tokenGenerator;

    /**
     * @required
     * @param TokenGeneratorInterface $tokenGenerator
     */
    public function setTokenGenerator(TokenGeneratorInterface $tokenGenerator): void
    {
        $this->tokenGenerator = $tokenGenerator;
    }
}
