<?php

declare(strict_types=1);

namespace Remind\Contacts\Domain\Repository;

use Remind\Extbase\Domain\Repository\FilterableRepository;

/**
 * @template-extends FilterableRepository<\Remind\Contacts\Domain\Model\Contact>
 */
class ContactRepository extends FilterableRepository
{
}
