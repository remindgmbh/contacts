<?php

declare(strict_types=1);

return [
    'columns' => [
        'email' => [
            'config' => [
                'eval' => 'trim',
                'max' => 256,
                'required' => true,
                'size' => 30,
                'type' => 'input',
            ],
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:email',
        ],
        'first_name' => [
            'config' => [
                'eval' => 'trim',
                'max' => 256,
                'required' => false,
                'size' => 30,
                'type' => 'input',
            ],
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:firstName',
        ],
        'groups' => [
            'config' => [
                'foreign_table' => 'tx_contacts_domain_model_group',
                'foreign_table_where' => 'AND {#tx_contacts_domain_model_group}.{#sys_language_uid} IN (-1,0)',
                'MM' => 'tx_contacts_domain_model_contact_group_mm',
                'multiple' => 0,
                'renderType' => 'selectMultipleSideBySide',
                'size' => 5,
                'type' => 'select',
            ],
            'exclude' => 0,
            'l10n_display' => 'defaultAsReadonly',
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:contactGroups',
        ],
        'image' => [
            'config' => [
                'allowed' => 'common-image-types',
                'maxitems' => 1,
                'type' => 'file',
            ],
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:image',
        ],
        'last_name' => [
            'config' => [
                'eval' => 'trim',
                'max' => 256,
                'required' => true,
                'size' => 30,
                'type' => 'input',
            ],
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:lastName',
        ],
        'middle_name' => [
            'config' => [
                'eval' => 'trim',
                'max' => 256,
                'required' => false,
                'size' => 30,
                'type' => 'input',
            ],
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:middleName',
        ],
        'mobile' => [
            'config' => [
                'eval' => 'trim',
                'max' => 256,
                'required' => false,
                'size' => 30,
                'type' => 'input',
            ],
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:mobile',
        ],
        'phone' => [
            'config' => [
                'eval' => 'trim',
                'max' => 256,
                'required' => false,
                'size' => 30,
                'type' => 'input',
            ],
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:phone',
        ],
        'position' => [
            'config' => [
                'eval' => 'trim',
                'max' => 256,
                'required' => false,
                'size' => 30,
                'type' => 'input',
            ],
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:position',
        ],
        'salutation' => [
            'config' => [
                'items' => [
                    [
                        'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:salutation.none',
                        'value' => 0,
                    ],
                    [
                        'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:salutation.mr',
                        'value' => 1,
                    ],
                    [
                        'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:salutation.mrs',
                        'value' => 2,
                    ],
                ],
                'renderType' => 'selectSingle',
                'type' => 'select',
            ],
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:salutation',
        ],
        'slug' => [
            'config' => [
                'default' => '',
                'eval' => 'uniqueInSite',
                'fallbackCharacter' => '-',
                'generatorOptions' => [
                    'fields' => ['first_name', 'last_name'],
                    'fieldSeparator' => '-',
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
        'title' => [
            'config' => [
                'eval' => 'trim',
                'max' => 256,
                'required' => false,
                'size' => 10,
                'type' => 'input',
            ],
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:title',
        ],
    ],
    'ctrl' => [
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:rmnd_contacts/Resources/Public/Icons/tx_contacts_domain_model_contact.svg',
        'label' => 'last_name',
        'label_alt' => 'first_name',
        'label_alt_force' => true,
        'languageField' => 'sys_language_uid',
        'origUid' => 't3_origuid',
        'sortby' => 'sorting',
        'title' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:contact',
        'translationSource' => 'l10n_source',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'transOrigPointerField' => 'l10n_parent',
        'tstamp' => 'tstamp',
        'versioningWS' => true,
    ],
    'palettes' => [
        'communication' => [
            'showitem' => '
                email,
                --linebreak--,
                phone,
                --linebreak--,
                mobile,
            ',
        ],
        'company' => [
            'showitem' => '
                position,
            ',
        ],
        'name' => [
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:name',
            'showitem' => '
                salutation,
                --linebreak--,
                title,
                --linebreak--,
                first_name,
                --linebreak--,
                middle_name,
                --linebreak--,
                last_name,
            ',
        ],
    ],
    'types' => [
        0 => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;name,
                    slug,
                    groups,
                --div--;LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:communication,
                    --palette--;;communication,
                --div--;LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:company,
                    --palette--;;company,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.images,
                    image,
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
