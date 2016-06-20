<?php

namespace UEC\SymfonyFormForZendFramework\Factory\UECStandaloneSymfonyForm;

use Interop\Container\ContainerInterface;
use UEC\ZendFrameworkTranslatorForSymfony\Translator;
use Zend\I18n\Translator\TranslatorInterface;

class TranslatorFactory
{
    public function __invoke(ContainerInterface $services)
    {
        return new Translator($services->get(TranslatorInterface::class), 'it_IT');
    }
}