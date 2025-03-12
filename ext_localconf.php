<?php

declare(strict_types=1);

use Remind\Contacts\Controller\ContactController;
use Remind\Contacts\Hooks\FormHook;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die('Access denied.');

(function (): void {
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

    ExtensionUtility::configurePlugin(
        'Contacts',
        'VCard',
        [ContactController::class => 'vCard'],
        [],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['afterInitializeCurrentPage'][FormHook::class] = FormHook::class;
})();
