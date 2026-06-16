<?php

declare(strict_types=1);

namespace Remind\Contacts\Tests\Unit\Finishers;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Psr\EventDispatcher\EventDispatcherInterface;
use Remind\Contacts\Domain\Repository\ContactRepository;
use Remind\Contacts\Finishers\EmailContactFinisher;
use Remind\Extbase\Event\ModifyDetailItemEvent;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Domain\Finishers\Exception\FinisherException;
use TYPO3\CMS\Form\Domain\Finishers\FinisherContext;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;
use TYPO3\CMS\Form\Domain\Runtime\FormState;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(EmailContactFinisher::class)]
class EmailContactFinisherTest extends UnitTestCase
{
    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
        parent::tearDown();
    }

    #[Test]
    public function executeInternalThrowsExceptionIfContactSourceIsMissing(): void
    {
        $finisher = new TestableEmailContactFinisher();

        $this->expectException(FinisherException::class);
        $this->expectExceptionCode(1675936768);

        $finisher->executeInternalProxy();
    }

    #[Test]
    public function executeInternalThrowsExceptionIfContactIsNotFoundForContactSourceContact(): void
    {
        $contactRepository = $this->createMock(ContactRepository::class);
        $contactRepository
            ->expects(self::once())
            ->method('findByUid')
            ->with(123)
            ->willReturn(null);
        GeneralUtility::setSingletonInstance(ContactRepository::class, $contactRepository);

        $formState = $this->createMock(FormState::class);
        $formState
            ->expects(self::once())
            ->method('getFormValue')
            ->with('arguments')
            ->willReturn([
                'tx_contacts_detail' => [
                    'contact' => 123,
                ],
            ]);
        $formState
            ->expects(self::once())
            ->method('setFormValue')
            ->with('arguments', null);

        $formRuntime = $this->createMock(FormRuntime::class);
        $formRuntime
            ->method('getFormState')
            ->willReturn($formState);

        $finisherContext = $this->createMock(FinisherContext::class);
        $finisherContext
            ->method('getFormRuntime')
            ->willReturn($formRuntime);

        $finisher = new TestableEmailContactFinisher();
        $finisher->setFinisherIdentifier('EmailContactFinisher');
        $finisher->setOptions([
            'contactSource' => 'contact',
        ]);
        $finisher->setFinisherContextForTest($finisherContext);

        $this->expectException(FinisherException::class);
        $this->expectExceptionCode(1669115177);

        $finisher->executeInternalProxy();
    }

    #[Test]
    public function executeInternalDispatchesEventForCustomContactSourceAndThrowsIfResultIsEmpty(): void
    {
        $formState = $this->createMock(FormState::class);
        $formState
            ->expects(self::once())
            ->method('getFormValue')
            ->with('arguments')
            ->willReturn(['foo' => 'bar']);
        $formState
            ->expects(self::once())
            ->method('setFormValue')
            ->with('arguments', null);

        $formRuntime = $this->createMock(FormRuntime::class);
        $formRuntime
            ->method('getFormState')
            ->willReturn($formState);

        $finisherContext = $this->createMock(FinisherContext::class);
        $finisherContext
            ->method('getFormRuntime')
            ->willReturn($formRuntime);

        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher
            ->expects(self::once())
            ->method('dispatch')
            ->with(self::callback(static function (object $event): bool {
                return $event instanceof ModifyDetailItemEvent
                    && $event->getExtensionName() === 'Contacts'
                    && $event->getSource() === 'customSource'
                    && $event->getArguments() === ['foo' => 'bar'];
            }))
            ->willReturnCallback(static fn (ModifyDetailItemEvent $event): ModifyDetailItemEvent => $event);

        $finisher = new TestableEmailContactFinisher();
        $finisher->setFinisherIdentifier('EmailContactFinisher');
        $finisher->setOptions([
            'contactSource' => 'customSource',
        ]);
        $finisher->setFinisherContextForTest($finisherContext);
        $finisher->injectEventDispatcher($eventDispatcher);

        $this->expectException(FinisherException::class);
        $this->expectExceptionCode(1669115177);

        $finisher->executeInternalProxy();
    }
}
