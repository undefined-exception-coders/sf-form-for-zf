<?php

namespace UEC\SymfonyFormForZendFramework\Factory\UECStandaloneSymfonyForm;

use Interop\Container\ContainerInterface;
use UEC\ZendFrameworkTranslatorForSymfony\Translator;
use UEC\ZendFrameworkTranslatorForSymfony\TranslatorHelper;

class TranslatorHelperFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $bridgeTranslator = $services->get(Translator::class);
        return new TranslatorHelper($bridgeTranslator);
    }
}