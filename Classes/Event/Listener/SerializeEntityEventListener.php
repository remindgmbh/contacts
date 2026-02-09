<?php

declare(strict_types=1);

namespace Remind\Contacts\Event\Listener;

use Remind\Contacts\Domain\Model\Contact;
use Remind\Contacts\Domain\Model\Group;
use Remind\Extbase\Event\SerializeEntityEvent;
use Remind\Headless\Service\FilesService;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

#[AsEventListener]
final readonly class SerializeEntityEventListener
{
    private FilesService $filesService;

    public function __construct()
    {
        $this->filesService = GeneralUtility::makeInstance(FilesService::class);
    }

    public function __invoke(SerializeEntityEvent $event): void
    {
        $abstractEntity = $event->getAbstractEntity();
        $settings = $event->getSettings();

        if (($settings['properties'] ?? '') === '') {
            $settings['properties'] = implode(',', array_keys($abstractEntity->_getProperties()));
        }

        $properties = explode(',', $this->camelize($settings['properties']));

        if ($abstractEntity instanceof Contact) {
            /** @var \TYPO3\CMS\Core\TypoScript\FrontendTypoScript $frontendTyposcript */
            $frontendTyposcript = $event->getRequest()->getAttribute('frontend.typoscript');
            $constants = $frontendTyposcript->getFlatSettings();

            $pageType = (int) $constants['plugin.tx_contacts.vcard.typeNum'];

            $vCardLink = $event->getUriBuilder()
                ->reset()
                ->setTargetPageType($pageType)
                ->setArguments(['tx_contacts_vcard[contact]' => $abstractEntity->getUid()])
                ->build();

            $json = $event->getJson();

            foreach ($properties as $property) {
                if ($property === '') {
                    continue;
                }

                $value = $abstractEntity->_getProperty($property);

                if ($value instanceof FileReference) {
                    $value = $this->filesService->processImage($value->getOriginalResource(), []);
                } elseif ($value instanceof ObjectStorage) {
                    $storageItems = [];

                    foreach ($value as $item) {
                        if ($item instanceof Group) {
                            $storageItems[] = [
                                'description' => $item->getDescription(),
                                'name' => $item->getName(),
                                'pid' => $item->getPid(),
                                'uid' => $item->getUid(),
                            ];
                        }
                    }

                    $value = $storageItems;
                }

                $json[$property] = $value;
            }

            $json['displayName'] = $abstractEntity->getDisplayName();
            $json['vCardLink'] = $vCardLink;

            $event->setJson($json);
        }
    }

    protected function camelize(string $input, string $separator = '_'): string
    {
        return lcfirst(str_replace($separator, '', ucwords($input, $separator)));
    }
}
