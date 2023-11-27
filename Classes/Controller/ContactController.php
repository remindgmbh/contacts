<?php

declare(strict_types=1);

namespace Remind\Contacts\Controller;

use Psr\Http\Message\ResponseInterface;
use Remind\Contacts\Domain\Model\Contact;
use Remind\Contacts\Domain\Repository\ContactRepository;
use Remind\Extbase\Service\ControllerService;
use Remind\Extbase\Service\JsonService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ContactController extends ActionController
{
    public function __construct(
        private readonly ContactRepository $contactRepository,
        private readonly ControllerService $controllerService,
        private readonly JsonService $jsonService,
    ) {
    }

    public function filterableListAction(?int $page = 1, ?array $filter = []): ResponseInterface
    {
        $listResult = $this->controllerService->getFilterableList($this->contactRepository, $page, $filter, 'filter');

        $jsonResult = $this->jsonService->serializeFilterableList(
            $listResult,
            $page,
            'detail',
            'contact'
        );

        return $this->jsonResponse(json_encode($jsonResult));
    }

    public function selectionListAction(?int $page = 1): ResponseInterface
    {
        $selectionResult = $this->controllerService->getSelectionList($this->contactRepository, $page);

        $jsonResult = $this->jsonService->serializeList(
            $selectionResult,
            $page,
            'detail',
            'contact'
        );

        return $this->jsonResponse(json_encode($jsonResult));
    }

    public function detailAction(?Contact $contact = null): ResponseInterface
    {
        $contactResult = $this->controllerService->getDetailResult(
            $this->contactRepository,
            $contact
        );
        return $this->jsonResponse(json_encode($contactResult));
    }

    public function vCardAction(?Contact $contact = null): ResponseInterface
    {
        $response = $this->responseFactory
            ->createResponse()
            ->withHeader('Content-Type', 'text/vcard')
            ->withHeader('Content-Disposition', 'attachment;filename="' . $contact->getEmail() . '.vcf"');

        $response->getBody()->write(mb_convert_encoding($contact->getVCard()->serialize(), 'ISO-8859-1'));
        return $response;
    }
}
