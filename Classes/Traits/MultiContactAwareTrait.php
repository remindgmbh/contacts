<?php

declare(strict_types=1);

namespace Remind\Contacts\Traits;

use Remind\Contacts\Domain\Model\Contact;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

trait MultiContactAwareTrait
{
    /**
     * @var ObjectStorage<Contact> $contacts
     */
    protected ObjectStorage $contacts;

    public function getContact(): Contact
    {
        $this->contacts->rewind();
        return $this->contacts->current();
    }

    public function addContact(Contact $contact): void
    {
        $this->contacts->attach($contact);
    }

    public function removeContact(Contact $contact): void
    {
        $this->contacts->detach($contact);
    }

    /**
     * @return ObjectStorage<Contact>
     */
    public function getContacts(): ObjectStorage
    {
        return $this->contacts;
    }

    /**
     * @param ObjectStorage<Contact> $contacts
     */
    public function setContacts(ObjectStorage $contacts): self
    {
        $this->contacts = $contacts;

        return $this;
    }
}
