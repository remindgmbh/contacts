<?php

declare(strict_types=1);

namespace Remind\Contacts\Tests\Unit\Domain\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Remind\Contacts\Domain\Model\Contact;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(Contact::class)]
class ContactTest extends UnitTestCase
{
    protected Contact $contact;

    public function setUp(): void
    {
        parent::setUp();

        $this->contact = new Contact();
    }

    public function tearDown(): void
    {
        GeneralUtility::purgeInstances();
        parent::tearDown();
    }

    #[Test]
    public function getDisplayNameUsesConfiguredPropertiesAndSkipsUnknownOnes(): void
    {
        $configurationManager = $this->createMock(ConfigurationManagerInterface::class);
        $configurationManager
            ->method('getConfiguration')
            ->with(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'contacts')
            ->willReturn([
                'displayNameFields' => 'firstName, unknownField, middleName, lastName',
            ]);
        GeneralUtility::setSingletonInstance(ConfigurationManagerInterface::class, $configurationManager);

        $this->contact
            ->setFirstName('John')
            ->setMiddleName('M')
            ->setLastName('Doe');

        self::assertSame('John M Doe', $this->contact->getDisplayName());
    }

    #[Test]
    public function getVCardReturnsExpectedFieldsWithoutPhotoByDefault(): void
    {
        $this->contact
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setMiddleName('M')
            ->setTitle('Dr')
            ->setEmail('john.doe@example.com')
            ->setMobile('+491700000001')
            ->setPhone('+49301234567')
            ->setPosition('Developer');

        $vCard = $this->contact->getVCard();
        $serializedVCard = $vCard->serialize();

        self::assertStringContainsString('VERSION:4.0', $serializedVCard);
        self::assertStringContainsString('N;CHARSET=ISO-8859-1:Doe;John;M;Dr', $serializedVCard);
        self::assertStringContainsString('EMAIL;TYPE=WORK:john.doe@example.com', $serializedVCard);
        self::assertStringContainsString('TEL;TYPE=CELL:+491700000001', $serializedVCard);
        self::assertStringContainsString('TEL;TYPE=WORK:+49301234567', $serializedVCard);
        self::assertStringContainsString('TITLE;CHARSET=ISO-8859-1:Developer', $serializedVCard);
        self::assertStringNotContainsString('PHOTO;', $serializedVCard);
    }
}
