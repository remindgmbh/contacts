<?php

declare(strict_types=1);

namespace Remind\Contacts\Hooks;

use Remind\Contacts\Finishers\EmailContactFinisher;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;
use TYPO3\CMS\Form\Domain\Model\FormElements\Page;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;

class FormHook
{
    /**
     * Add query parameters to form state to be used in EmailContactFinisher
     * has to be done before submitting because in after submit hook or
     * finisher only tx_form_formframework are available
     */
    public function afterInitializeCurrentPage(
        FormRuntime $formRuntime,
        ?Page $page,
        ?Page $lastDisplayedPage,
        array $args
    ): ?Page {
        if ($page) {
            $containsEmailContactFinisher = !empty(
                array_filter($formRuntime->getFormDefinition()->getFinishers(), function (AbstractFinisher $finisher) {
                    return $finisher instanceof EmailContactFinisher;
                })
            );

            if ($containsEmailContactFinisher) {
                /** @var \TYPO3\CMS\Core\Routing\PageArguments $pageArguments */
                $pageArguments = $formRuntime->getRequest()->getAttribute('routing');
                $arguments = $pageArguments->getArguments();
                unset($arguments['cHash']);
                $formRuntime->getFormState()->setFormValue('arguments', $arguments);
            }
        }
        return $page;
    }
}
