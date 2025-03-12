<?php

declare(strict_types=1);

return [
    'columns' => [
        'contacts' => [
            'config' => [
                'type' => 'passthrough',
            ],
            'exclude' => 0,
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:contacts',
        ],
        'description' => [
            'config' => [
                'enableRichtext' => true,
                'eval' => 'trim',
                'max' => 256,
                'type' => 'text',
            ],
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:description',
        ],
        'name' => [
            'config' => [
                'eval' => 'trim',
                'max' => 256,
                'required' => true,
                'size' => 20,
                'type' => 'input',
            ],
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:name',
        ],
        'slug' => [
            'config' => [
                'default' => '',
                'eval' => 'uniqueInSite',
                'fallbackCharacter' => '-',
                'generatorOptions' => [
                    'fields' => ['name'],
                    'prefixParentPageSlug' => false,
                    'replacements' => [
                        '/' => '-',
                    ],
                ],
                'type' => 'slug',
            ],
            'exclude' => 0,
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:slug',
        ],
    ],
    'ctrl' => [
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:rmnd_contacts/Resources/Public/Icons/tx_contacts_domain_model_contactgroup.svg',
        'label' => 'name',
        'languageField' => 'sys_language_uid',
        'origUid' => 't3_origuid',
        'sortby' => 'sorting',
        'title' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:contactGroup',
        'translationSource' => 'l10n_source',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'transOrigPointerField' => 'l10n_parent',
        'tstamp' => 'tstamp',
        'versioningWS' => true,
    ],
    'types' => [
        0 => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    name,
                    slug,
                    description,
                    contacts,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    sys_language_uid,
                    l10n_parent,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    hidden,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
            ',
        ],
    ],
];
