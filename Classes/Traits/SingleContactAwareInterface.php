<?php

declare(strict_types=1);

namespace Remind\Contacts\Traits;

use Remind\Contacts\Domain\Model\Contact;

interface SingleContactAwareInterface extends ContactAwareInterface
{
    public function setContact(?Contact $contact): self;
}
