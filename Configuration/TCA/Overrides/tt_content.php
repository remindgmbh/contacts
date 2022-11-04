<?php

declare(strict_types=1);

use Remind\Extbase\Utility\Dto\PluginType;
use Remind\Extbase\Utility\PluginUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die;

(function () {
    // Detail Plugin Configuration
    ExtensionUtility::registerPlugin(
        'Contacts',
        'Detail',
        'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:detail',
        'contactsdetail',
        'contacts'
    );
    PluginUtility::addTcaType(
        'contacts_detail',
        PluginType::DETAIL,
        'tx_contacts_domain_model_contact'
    );

    // Filterable List Plugin Configuration
    ExtensionUtility::registerPlugin(
        'Contacts',
        'FilterableList',
        'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:filterableList',
        'contactsfilterablelist',
        'contacts'
    );
    PluginUtility::addTcaType(
        'contacts_filterablelist',
        PluginType::FILTERABLE_LIST,
        'tx_contacts_domain_model_contact'
    );

    // Selection List Plugin Configuration
    ExtensionUtility::registerPlugin(
        'Contacts',
        'SelectionList',
        'LLL:EXT:rmnd_contacts/Resources/Private/Language/locallang_tca.xlf:selectionList',
        'contactsselectionlist',
        'contacts'
    );
    PluginUtility::addTcaType(
        'contacts_selectionlist',
        PluginType::SELECTION_LIST,
        'tx_contacts_domain_model_contact'
    );
})();
