<?php

declare(strict_types=1);

namespace Remind\Contacts\Tests\Unit\Finishers;

use Remind\Contacts\Finishers\EmailContactFinisher;
use TYPO3\CMS\Form\Domain\Finishers\FinisherContext;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;

class TestableEmailContactFinisher extends EmailContactFinisher
{
    public function executeInternalProxy(): void
    {
        $this->executeInternal();
    }

    public function setFinisherContextForTest(FinisherContext $finisherContext): void
    {
        $this->finisherContext = $finisherContext;
    }

    /**
     * @param string|array<mixed> $subject
     * @param string|array<mixed> $optionValue
     * @param array<string, mixed> $translationOptions
     * @return string|array<mixed>
     */
    protected function translateFinisherOption(
        mixed $subject,
        FormRuntime $formRuntime,
        string $optionName,
        mixed $optionValue,
        array $translationOptions
    ): mixed {
        unset($formRuntime, $optionName, $optionValue, $translationOptions);

        return $subject;
    }
}
