<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'contactsfilterablelist' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:rmnd_contacts/Resources/Public/Icons/contacts_filterable_list.svg',
    ],
    'contactsselectionlist' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:rmnd_contacts/Resources/Public/Icons/contacts_selection_list.svg',
    ],
    'contactsdetail' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:rmnd_contacts/Resources/Public/Icons/contacts_detail.svg',
    ],
];
