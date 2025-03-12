<?php

declare(strict_types=1);

namespace Remind\Contacts\Event\Listener;

use Remind\Contacts\Domain\Model\Contact;
use Remind\Extbase\Event\SerializeEntityEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener]
final readonly class SerializeEntityEventListener
{
    public function __invoke(SerializeEntityEvent $event): void
    {
        $abstractEntity = $event->getAbstractEntity();
        if ($abstractEntity instanceof Contact) {
            /** @var \TYPO3\CMS\Core\TypoScript\FrontendTypoScript $frontendTyposcript */
            $frontendTyposcript = $event->getRequest()->getAttribute('frontend.typoscript');
            $constants = $frontendTyposcript->getFlatSettings();

            $pageType = (int) $constants['plugin.tx_contacts.vcard.typeNum'];

            $vCardLink = $event->getUriBuilder()
                ->reset()
                ->setTargetPageType($pageType)
                ->setArguments(['tx_contacts_vcard[contact]' => $abstractEntity->getUid()])
                ->build();

            $json = $event->getJson();
            $json['vCardLink'] = $vCardLink;

            $event->setJson($json);
        }
    }
}
