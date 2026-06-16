<?php

declare(strict_types=1);

namespace Remind\Contacts\Tests\Unit\Event\Listener;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ServerRequestInterface;
use Remind\Contacts\Domain\Model\Contact;
use Remind\Contacts\Domain\Model\Group;
use Remind\Contacts\Event\Listener\SerializeEntityEventListener;
use Remind\Extbase\Event\Enum\SerializeEntityEventType;
use Remind\Extbase\Event\SerializeEntityEvent;
use Remind\Headless\Service\FilesService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(SerializeEntityEventListener::class)]
class SerializeEntityTest extends UnitTestCase
{
    #[Test]
    public function testSerializeContact(): void
    {
        $configurationManager = $this->createMock(ConfigurationManagerInterface::class);
        $configurationManager
            ->method('getConfiguration')
            ->with(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'contacts')
            ->willReturn(['displayNameFields' => 'firstName,lastName']);
        GeneralUtility::setSingletonInstance(ConfigurationManagerInterface::class, $configurationManager);

        $filesService = $this->createMock(FilesService::class);
        GeneralUtility::addInstance(FilesService::class, $filesService);

        $group = new Group();
        $group->setName('Leadership');
        $group->setDescription('Management');
        $group->_setProperty('pid', 22);
        $group->_setProperty('uid', 11);

        $groups = new ObjectStorage();
        $groups->attach($group);

        $contact = new Contact();
        $contact->setFirstName('Jane');
        $contact->setLastName('Smith');
        $contact->setGroups($groups);
        $contact->_setProperty('pid', 7);
        $contact->_setProperty('uid', 42);

        $frontendTyposcript = new class {
            /**
             * @return array<string, string>
             */
            public function getFlatSettings(): array
            {
                return ['plugin.tx_contacts.vcard.typeNum' => '123'];
            }
        };

        $request = $this->createMock(ServerRequestInterface::class);
        $request
            ->expects($this->once())
            ->method('getAttribute')
            ->with('frontend.typoscript')
            ->willReturn($frontendTyposcript);

        $uriBuilder = $this->createMock(UriBuilder::class);
        $uriBuilder->expects($this->once())
            ->method('reset')
            ->willReturnSelf();
        $uriBuilder->expects($this->once())
            ->method('setTargetPageType')
            ->with(123)
            ->willReturnSelf();
        $uriBuilder->expects($this->once())
            ->method('setArguments')
            ->with(['tx_contacts_vcard[contact]' => 42])
            ->willReturnSelf();
        $uriBuilder->expects($this->once())
            ->method('build')
            ->willReturn('/contact.vcf');

        $event = new SerializeEntityEvent(
            'Contacts',
            SerializeEntityEventType::Detail,
            $request,
            $contact,
            $uriBuilder,
            ['properties' => 'firstName,groups']
        );

        (new SerializeEntityEventListener())($event);

        $json = $event->getJson();
        $this->assertSame('Jane', $json['firstName']);
        $this->assertSame([
            [
                'description' => 'Management',
                'name' => 'Leadership',
                'pid' => 22,
                'uid' => 11,
            ],
        ], $json['groups']);
        $this->assertSame('Jane Smith', $json['displayName']);
        $this->assertSame('/contact.vcf', $json['vCardLink']);

        GeneralUtility::purgeInstances();
    }
}
