<?php

namespace UEC\SymfonyFormForZendFramework\View\Helper;

use Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper;
use Zend\Form\View\Helper\AbstractHelper;

class SymfonyForm extends AbstractHelper
{
    /**
     * @var FormHelper
     */
    private $formHelper;

    public function __construct(FormHelper $formHelper)
    {
        $this->formHelper = $formHelper;
    }

    public function __invoke()
    {
        return $this->formHelper;
    }
}