<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminRequestEvent extends Event
{
    public const ADMIN_REQUEST = 'admin-request';

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Response
     */
    private $originalResponse;

    /**
     * @param Request $request
     * @param Response $originalResponse
     */
    public function __construct(Request $request, Response $originalResponse)
    {
        $this->request = $request;
        $this->originalResponse = $originalResponse;
    }

    /**
     * @return Response
     */
    public function getOriginalResponse(): Response
    {
        return $this->originalResponse;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse(): ?Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }
}
