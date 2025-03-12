<?php

declare(strict_types=1);

use Remind\Extbase\Utility\Dto\PluginType;
use Remind\Extbase\Utility\PluginUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die;

(function (): void {
    // Detail Plugin Configuration
    $detailSignature = ExtensionUtility::registerPlugin(
        'Contacts',
        'Detail',
        'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:detail',
        'contactsdetail',
        'Contacts'
    );
    PluginUtility::addTcaType(
        $detailSignature,
        PluginType::DETAIL,
        'tx_contacts_domain_model_contact'
    );

    // Filterable List Plugin Configuration
    $filterableListSignature = ExtensionUtility::registerPlugin(
        'Contacts',
        'FilterableList',
        'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:filterableList',
        'contactsfilterablelist',
        'Contacts'
    );
    PluginUtility::addTcaType(
        $filterableListSignature,
        PluginType::FILTERABLE_LIST,
        'tx_contacts_domain_model_contact'
    );

    // Selection List Plugin Configuration
    $selectionListSignature = ExtensionUtility::registerPlugin(
        'Contacts',
        'SelectionList',
        'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:selectionList',
        'contactsselectionlist',
        'Contacts'
    );
    PluginUtility::addTcaType(
        $selectionListSignature,
        PluginType::SELECTION_LIST,
        'tx_contacts_domain_model_contact'
    );
})();
