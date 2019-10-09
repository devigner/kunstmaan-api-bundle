<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Provider;

use Devigner\KunstmaanApiBundle\Traits\EntityManagerTrait;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractProvider implements EntityInjectionProviderInterface
{
    use EntityManagerTrait;

    /**
     * @var array
     */
    protected $results;

    /**
     * @var Pagerfanta
     */
    protected $pagerfanta;

    abstract public function getNamespace(): string;

    /**
     * @return string
     */
    public function getCurrentPage(): string
    {
        return sprintf('%s=%s', $this->getNamespace(), $this->pagerfanta->getCurrentPage());
    }

    /**
     * @return string|null
     */
    public function getNextPage(): ?string
    {
        if (!$this->pagerfanta->hasNextPage()) {
            return null;
        }

        return sprintf('%s=%s', $this->getNamespace(), $this->pagerfanta->getNextPage());
    }

    /**
     * @return string
     */
    public function getLastPage(): string
    {
        return sprintf('%s=%s', $this->getNamespace(), $this->pagerfanta->getMaxPerPage());
    }

    /**
     * @return array
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @param array $result
     * @param int $maxResult
     * @param Request $request
     */
    protected function createPagerFanta(array $result, int $maxResult, Request $request): void
    {
        $adapter = new ArrayAdapter($result);
        $this->pagerfanta = new Pagerfanta($adapter);
        $this->pagerfanta->setMaxPerPage($maxResult);
        $pageNumber = (int)$request->get($this->getNamespace());
        if (!$pageNumber || $pageNumber < 1) {
            $pageNumber = 1;
        }
        $this->pagerfanta->setCurrentPage($pageNumber);
    }
}
