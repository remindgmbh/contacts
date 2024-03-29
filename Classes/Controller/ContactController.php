<?php

declare(strict_types=1);

namespace Remind\Contacts\Controller;

use Psr\Http\Message\ResponseInterface;
use Remind\Contacts\Domain\Model\Contact;
use Remind\Contacts\Domain\Repository\ContactRepository;
use Remind\Contacts\Traits\ContactAwareInterface;
use Remind\Extbase\Service\DataService;
use Remind\Headless\Service\JsonService;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ContactController extends ActionController
{
    public function __construct(
        private readonly ContactRepository $contactRepository,
        private readonly DataService $dataService,
        private readonly JsonService $jsonService,
    ) {
    }

    public function filterableListAction(?int $page = 1, ?array $filter = []): ResponseInterface
    {
        $listResult = $this->dataService->getFilterableList($this->contactRepository, $page, $filter, 'filter');

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
        $selectionResult = $this->dataService->getSelectionList($this->contactRepository, $page);

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
        /** @var Contact|null $contact */
        $contact = $this->dataService->getDetailEntity(
            $this->contactRepository,
            $contact,
            function (AbstractEntity $entity) {
                return ($entity instanceof ContactAwareInterface) ? $entity->getContact() : null;
            }
        );
        return $this->jsonResponse(json_encode(['contact' => $contact]));
    }
}
