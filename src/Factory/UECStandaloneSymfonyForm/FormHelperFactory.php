<?php

namespace UEC\SymfonyFormForZendFramework\Factory\UECStandaloneSymfonyForm;

use Interop\Container\ContainerInterface;
use UEC\Standalone\Symfony\Form\Template\PhpEngineFactory;
use UEC\SymfonyFormForZendFramework\Module;
use UEC\ZendFrameworkTranslatorForSymfony\TranslatorHelper;

class FormHelperFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $config = $services->get('config');

        $engineFactory = new PhpEngineFactory($config[Module::class]['template_paths']);

        $engine = $engineFactory();
        $formHelperFactory = new \UEC\Standalone\Symfony\Form\FormHelperFactory($engine);
        $formHelper = $formHelperFactory();

        $engine->set($formHelper);
        $engine->set($services->get(TranslatorHelper::class));

        return $formHelper;
    }
}