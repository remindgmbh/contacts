<?php

declare(strict_types=1);

namespace Remind\Contacts\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Group extends AbstractEntity
{
    protected string $name = '';

    protected string $description = '';

    /**
     * @var ObjectStorage<Contact> $contacts
     */
    protected ObjectStorage $contacts;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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
