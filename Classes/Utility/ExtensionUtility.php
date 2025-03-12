<?php

declare(strict_types=1);

namespace Remind\Contacts\Utility;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class ExtensionUtility
{
    /**
     * @param string $table the contact column is added to
     * @return string Name of the added field
     */
    public static function addTcaColumnContact(string $table): string
    {
        $fieldName = 'contact';
        ExtensionManagementUtility::addTCAcolumns($table, [
            $fieldName => [
                'config' => [
                    'default' => 0,
                    'foreign_table' => 'tx_contacts_domain_model_contact',
                    'items' => [
                        ['', 0],
                    ],
                    'maxitems' => 1,
                    'minitems' => 0,
                    'renderType' => 'selectSingle',
                    'type' => 'select',
                ],
                'exclude' => false,
                'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang.xlf:contact',
            ],
        ]);
        return $fieldName;
    }

    /**
     * @param string $table the contacts column is added to
     * @param string $mm name of the mm table
     * @param bool $foreign required to make field editable from foreign side
     * @return string Name of the added field
     */
    public static function addTcaColumnContacts(string $table, string $mm, ?bool $foreign = false): string
    {
        $fieldName = 'contacts';
        $column = [
            $fieldName => [
                'config' => [
                    'foreign_table' => 'tx_contacts_domain_model_contact',
                    'MM' => $mm,
                    'multiple' => 0,
                    'renderType' => 'selectMultipleSideBySide',
                    'size' => 5,
                    'type' => 'select',
                ],
                'exclude' => false,
                'label' => 'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang.xlf:contacts',
            ],
        ];

        if ($foreign) {
            $column[$fieldName]['config']['MM_opposite_field'] = $fieldName;
        }

        ExtensionManagementUtility::addTCAcolumns($table, $column);

        return $fieldName;
    }
}
