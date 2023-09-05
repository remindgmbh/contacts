<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:contact',
        'label' => 'last_name',
        'label_alt' => 'first_name',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'languageField' => 'sys_language_uid',
        'translationSource' => 'l10n_source',
        'origUid' => 't3_origuid',
        'delete' => 'deleted',
        'sortby' => 'sorting',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:rmnd_contacts/Resources/Public/Icons/tx_contacts_domain_model_contact.svg',
    ],
    'columns' => [
        'title' => [
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:title',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim',
                'required' => false,
                'max' => 256,
            ],
        ],
        'salutation' => [
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:salutation',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:salutation.none',
                        0,
                    ],
                    [
                        'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:salutation.mr',
                        1,
                    ],
                    [
                        'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:salutation.mrs',
                        2,
                    ],
                ],
            ],
        ],
        'first_name' => [
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:firstName',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => false,
                'max' => 256,
            ],
        ],
        'middle_name' => [
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:middleName',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => false,
                'max' => 256,
            ],
        ],
        'last_name' => [
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:lastName',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
                'max' => 256,
            ],
        ],
        'email' => [
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
                'max' => 256,
            ],
        ],
        'phone' => [
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:phone',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => false,
                'max' => 256,
            ],
        ],
        'mobile' => [
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:mobile',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => false,
                'max' => 256,
            ],
        ],
        'slug' => [
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:slug',
            'exclude' => 0,
            'config' => [
                'type' => 'slug',
                'generatorOptions' => [
                    'fields' => ['first_name', 'last_name'],
                    'fieldSeparator' => '-',
                    'prefixParentPageSlug' => false,
                    'replacements' => [
                        '/' => '-',
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => '',
            ],
        ],
        'groups' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:contactGroups',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_contacts_domain_model_group',
                'MM' => 'tx_contacts_domain_model_contact_group_mm',
                'size' => 5,
                'multiple' => 0,
            ],
        ],
        'image' => [
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:image',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
                'maxitems' => 1,
            ],
        ],
        'position' => [
            'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:position',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => false,
                'max' => 256,
            ],
        ],
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        '',
                        0,
                    ],
                ],
                'foreign_table' => 'tx_contacts_domain_model_contact',
                'foreign_table_where' =>
                    'AND {#tx_contacts_domain_model_contact}.{#pid}=###CURRENT_PID###'
                    . ' AND {#tx_contacts_domain_model_contact}.{#sys_language_uid} IN (-1,0)',
                'default' => 0,
            ],
        ],
        'l10n_source' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => '',
            ],
        ],
        't3ver_label' => [
            'displayCond' => 'FIELD:t3ver_label:REQ:true',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'none',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
    ],
    'palettes' => [
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
