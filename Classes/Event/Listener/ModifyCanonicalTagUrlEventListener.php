<?php

declare(strict_types=1);

namespace Remind\Contacts\Event\Listener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Routing\PageArguments;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Seo\Event\ModifyUrlForCanonicalTagEvent;

#[AsEventListener]
final readonly class ModifyCanonicalTagUrlEventListener
{
    public function __invoke(ModifyUrlForCanonicalTagEvent $event): void
    {
        $request = $event->getRequest();
        $contactUid = $request->getQueryParams()['tx_contacts_detail']['contact'] ?? null;

        if ($contactUid) {
            $routing = $request->getAttribute('routing');
            $detailPid = $routing instanceof PageArguments
                ? $routing->getPageId()
                : 0;

            $contentObjectRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);
            $detailUrl = $contentObjectRenderer->typoLink_URL([
                'additionalParams' => '&tx_contacts_detail[contact]=' . (int) $contactUid,
                'forceAbsoluteUrl' => true,
                'parameter' => $detailPid,
            ]);

            $event->setUrl($detailUrl);
        }
    }
}
