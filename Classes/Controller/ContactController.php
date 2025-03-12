<?php

declare(strict_types=1);

namespace Remind\Contacts\Controller;

use Psr\Http\Message\ResponseInterface;
use Remind\Contacts\Domain\Model\Contact;
use Remind\Contacts\Domain\Repository\ContactRepository;
use Remind\Extbase\Controller\AbstractExtbaseController;

class ContactController extends AbstractExtbaseController
{
    public function __construct(
        ContactRepository $contactRepository,
    ) {
        parent::__construct($contactRepository);
    }

    /**
     * @param mixed[] $filter
     */
    public function filterableListAction(int $page = 1, array $filter = []): ResponseInterface
    {
        $listResult = $this->getFilterableList($page, $filter, 'filter');

        $jsonResult = $this->serializeFilterableList(
            $listResult,
            $page,
            'detail',
            'contact'
        );

        return $this->jsonResponse(json_encode($jsonResult) ?: null);
    }

    public function selectionListAction(int $page = 1): ResponseInterface
    {
        $selectionResult = $this->getSelectionList($page);

        $jsonResult = $this->serializeList(
            $selectionResult,
            $page,
            'detail',
            'contact'
        );

        return $this->jsonResponse(json_encode($jsonResult) ?: null);
    }

    public function detailAction(Contact $contact = null): ResponseInterface
    {
        $contactResult = $this->getDetailResult($contact);

        $jsonResult = $contactResult ? $this->serializeDetailResult($contactResult) : [];

        return $this->jsonResponse(json_encode($jsonResult) ?: null);
    }

    public function vCardAction(Contact $contact = null): ResponseInterface
    {
        $response = $this->responseFactory
            ->createResponse()
            ->withHeader('Content-Type', 'text/vcard')
            ->withHeader('Content-Disposition', 'attachment;filename="' . $contact?->getEmail() . '.vcf"');

        $response->getBody()->write(mb_convert_encoding($contact?->getVCard()->serialize() ?? '', 'ISO-8859-1'));
        return $response;
    }
}
