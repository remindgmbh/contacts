<?php

declare(strict_types=1);

defined('TYPO3') || die;

use Remind\Headless\Utility\TcaUtility;

TcaUtility::addPageConfigFlexForm('FILE:EXT:rmnd_contacts/Configuration/FlexForms/Config.xml');
