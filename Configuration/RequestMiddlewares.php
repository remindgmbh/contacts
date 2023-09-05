<?php

use Remind\Contacts\Middleware\VCardMiddleware;

return [
    'frontend' => [
        'rmnd_contacts/vcard' => [
            'target' => VCardMiddleware::class,
            'after' => [
                'typo3/cms-frontend/site',
            ],
            'before' => [
                'typo3/cms-frontend/backend-user-authentication',
            ],
        ],
    ],
];
