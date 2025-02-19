# REMIND - Contacts Extension

## Add custom fields

Use XCLASSing to extend base contact model and add additional fields.


```php
<?php

declare(strict_types=1);

use Remind\Contacts\Domain\Model\Contact as DefaultContact;
use Remind\Extension\Domain\Model\Contact;

defined('TYPO3') || die('Access denied.');

(function (): void {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][DefaultContact::class] = ['className' => Contact::class];
})();

```

## Add VCard fields

To add fields to the VCard simply use XCLASSing like described before and override the `getVCard` method.

```php
<?php

declare(strict_types=1);

namespace Remind\Extension\Domain\Model;

use Remind\Contacts\Domain\Model\Contact as BaseContact;
use Sabre\VObject\Component\VCard;

class Contact extends BaseContact
{
    public function getVCard(): VCard
    {
        $result = parent::getVCard();
        $result->add(
            'TITLE',
            ['Remind Developer'],
        );
        return $result;
    }
}
```