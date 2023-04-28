<?php

declare(strict_types=1);

use Remind\Contacts\Controller\ContactController;
use Remind\Contacts\Hooks\FormHook;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die('Access denied.');

(function () {
    $versionInformation = GeneralUtility::makeInstance(Typo3Version::class);
    // Only include page.tsconfig if TYPO3 version is below 12 so that it is not imported twice.
    if ($versionInformation->getMajorVersion() < 12) {
        ExtensionManagementUtility::addPageTSConfig('
          @import "EXT:rmnd_contacts/Configuration/page.tsconfig"
       ');
    }

    ExtensionUtility::configurePlugin(
        'Contacts',
        'FilterableList',
        [ContactController::class => 'filterableList'],
        [],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    ExtensionUtility::configurePlugin(
        'Contacts',
        'SelectionList',
        [ContactController::class => 'selectionList'],
        [],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    ExtensionUtility::configurePlugin(
        'Contacts',
        'Detail',
        [ContactController::class => 'detail'],
        [],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    $GLOBALS
        ['TYPO3_CONF_VARS']
        ['SC_OPTIONS']
        ['ext/form']
        ['afterInitializeCurrentPage']
        [FormHook::class] = FormHook::class;
})();
