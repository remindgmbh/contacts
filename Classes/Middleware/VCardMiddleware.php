<?php

declare(strict_types=1);

namespace Remind\Contacts\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Remind\Contacts\Domain\Repository\ContactRepository;
use Sabre\VObject\Component\VCard;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class VCardMiddleware implements MiddlewareInterface
{
    private ResponseFactoryInterface $responseFactory;

    private ContactRepository $contactRepository;

    public function __construct()
    {
        $this->contactRepository = GeneralUtility::makeInstance(ContactRepository::class);
    }

    public function injectResponseFactory(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var \TYPO3\CMS\Core\Routing\SiteRouteResult $routing */
        $routing = $request->getAttribute('routing');
        $path = $routing->getUri()->getPath();
        $queryParams = $request->getQueryParams();
        $uid = $queryParams['uid'] ?? null;
        if ($path === '/vcard' && $uid) {
            /** @var \Remind\Contacts\Domain\Model\Contact $contact */
            $contact = $this->contactRepository->findByUid($uid);

            if ($contact) {
                $response = $this->responseFactory
                    ->createResponse()
                    ->withHeader('Content-Type', 'text/vcard');
    
                $response->getBody()->write($contact->getVCard()->serialize());
                return $response;
            }

        }
        return $handler->handle($request);
    }
}
