<?php

declare(strict_types=1);

namespace Remind\Contacts\Traits;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

interface MultiContactAwareInterface extends ContactAwareInterface
{
    /**
     * @return ObjectStorage<\Remind\Contacts\Domain\Model\Contact>
     */
    public function getContacts(): ObjectStorage;

    /**
     * @param ObjectStorage<\Remind\Contacts\Domain\Model\Contact> $contacts
     */
    public function setContacts(ObjectStorage $contacts): self;
}
