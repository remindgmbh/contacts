<?php

declare(strict_types=1);

namespace Remind\Contacts\Traits;

use Remind\Contacts\Domain\Model\Contact;

interface ContactAwareInterface
{
    public function getContact(): Contact;
}
