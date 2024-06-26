<?php

declare(strict_types=1);

namespace Remind\Contacts\Finishers;

use Psr\EventDispatcher\EventDispatcherInterface;
use Remind\Contacts\Domain\Repository\ContactRepository;
use Remind\Extbase\Event\ModifyDetailEntityEvent;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Domain\Finishers\EmailFinisher;
use TYPO3\CMS\Form\Domain\Finishers\Exception\FinisherException;

class EmailContactFinisher extends EmailFinisher
{
    /**
     * values from parent class with additional value 'recipients'
     * @var array
     */
    protected $defaultOptions = [
        'recipientName' => '',
        'senderName' => '',
        'addHtmlPart' => true,
        'attachUploads' => true,
        'recipients' => [],
    ];

    private ?EventDispatcherInterface $eventDispatcher = null;

    public function injectEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Executes this finisher
     * @see AbstractFinisher::execute()
     *
     * @throws FinisherException
     */
    protected function executeInternal()
    {
        $contactSource = $this->parseOption('contactSource');

        if (!$contactSource) {
            throw new FinisherException('No Contact Source defined in finisher settings overrides', 1675936768);
        }

        $arguments = $this->finisherContext->getFormRuntime()->getFormState()->getFormValue('arguments');
        $this->finisherContext->getFormRuntime()->getFormState()->setFormValue('arguments', null);

        $contactRepository = GeneralUtility::makeInstance(ContactRepository::class);

        $contact = null;

        switch ($contactSource) {
            case 'contact':
                $uid = (int) ($arguments['tx_contacts_detail']['contact'] ?? null);
                if ($uid) {
                    $contact = $contactRepository->findByUid($uid);
                }
                break;
            case 'record':
                $uid = (int) $this->parseOption('contactUid');
                if ($uid) {
                    $contact = $contactRepository->findByUid($uid);
                }
                break;
            default:
                /** @var ModifyDetailEntityEvent $event */
                $event = $this->eventDispatcher->dispatch(
                    new ModifyDetailEntityEvent('Contacts', $contactSource, $arguments)
                );
                $contact = $event->getResult();
                break;
        }

        if (!$contact) {
            throw new FinisherException('Contact not found', 1669115177);
        }

        $contactRole = $this->parseOption('contactRole');

        /** @var \Remind\Contacts\Domain\Model\Contact $contact */
        $email = $contact->getEmail();
        $name = $contact->getDisplayName();

        if ($contactRole === 'sender') {
            $this->setOption('senderAddress', $email);
            $this->setOption('senderName', $name);
        }

        if ($contactRole === 'recipient') {
            $recipients = [$email => $name];
            ArrayUtility::mergeRecursiveWithOverrule($recipients, $this->parseOption('recipients'));
            $this->setOption('recipients', $recipients);
        }

        parent::executeInternal();
    }
}
