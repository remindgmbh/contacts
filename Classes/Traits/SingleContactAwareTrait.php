<?php

declare(strict_types=1);

namespace Remind\Contacts\Traits;

use Remind\Contacts\Domain\Model\Contact;

trait SingleContactAwareTrait
{
    protected ?Contact $contact;

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
