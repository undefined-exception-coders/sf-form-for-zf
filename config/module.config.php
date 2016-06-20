<?php

namespace UEC\SymfonyFormForZendFramework;

use Symfony\Component\Form\Extension;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use UEC\Standalone\Symfony\Form as UECStandaloneSymfonyForm;
use UEC\SymfonyFormForZendFramework\Factory;
use UEC\SymfonyFormForZendFramework\PluginManager;
use UEC\SymfonyFormForZendFramework\Validator;
use UEC\ZendFrameworkTranslatorForSymfony\Translator;
use UEC\ZendFrameworkTranslatorForSymfony\TranslatorHelper;
use Zend\ServiceManager\ServiceLocatorInterface;

return [
    Module::class => [
        'template_paths' => [
            __DIR__.'/../../../vendor/symfony/framework-bundle/Resources/views/Form',
        ],
        'translator' => [
            'service' => Translator::class,
            'domain' => 'validators',
        ],
        'object_manager' => null,
        'constraints' => [
            'invokables' => [
                Validator\Constraint\SubclassOfValidator::class => Validator\Constraint\SubclassOfValidator::class,
            ],
            'factories' => [
                Validator\Constraint\UniqueFieldValidator::class => Factory\Validator\Constraint\UniqueFieldValidatorFactory::class,
                Validator\Constraint\UniqueObjectValidator::class => Factory\Validator\Constraint\UniqueObjectValidatorFactory::class,
            ],
        ],
        'types' => [
            'container' => [],
            'enabled' => []
        ],
        'extensions' => [
            'container' => [
                'factories' => [
                    'ValidatorExtension' => function (PluginManager\ExtensionPluginManager $extensions) {
                        $services = $extensions->getServiceLocator();
                        $validation = $services->get(UECStandaloneSymfonyForm\ValidationBuilderFactory::class);
                        return new Extension\Validator\ValidatorExtension($validation->getValidator());
                    },
                    'CsrfExtension' => function (PluginManager\ExtensionPluginManager $extensions) {
                        return new Extension\Csrf\CsrfExtension(new CsrfTokenManager());
                    },
                    'DoctrineExtension' => function (PluginManager\ExtensionPluginManager $extensions) {
                        $services = $extensions->getServiceLocator();
                        $config = $services->get('config');

                        return new UECStandaloneSymfonyForm\Doctrine\Doctrine\DoctrineExtension(
                            $services->get($config[Module::class]['object_manager'])
                        );
                    },
                ],
            ],
            'enabled' => [
                'ValidatorExtension',
                'CsrfExtension',
                'DoctrineExtension',
            ],
        ]
    ],
    'view_helpers' => [
        'factories' => [
            'sform' => function (ServiceLocatorInterface $services) {
                return new View\Helper\SymfonyForm(
                    $services->getServiceLocator()->get(UECStandaloneSymfonyForm\FormHelperFactory::class)
                );
            },
        ]
    ],
    'service_manager' => [
        'invokables' => [
        ],
        'factories' => [
            // Inizializzazione dei PluginManager
            PluginManager\ExtensionPluginManager::class => Factory\PluginManager\ExtensionPluginManagerFactory::class,
            PluginManager\ConstraintPluginManager::class => Factory\PluginManager\ConstraintPluginManagerFactory::class,
            PluginManager\TypePluginManager::class => Factory\PluginManager\TypePluginManagerFactory::class,

            UECStandaloneSymfonyForm\FormBuilderFactory::class => UECStandaloneSymfonyForm\FormBuilderFactory::class,
            UECStandaloneSymfonyForm\ValidationBuilderFactory::class => Factory\UECStandaloneSymfonyForm\ValidationBuilderFactory::class,
            UECStandaloneSymfonyForm\FormHelperFactory::class => Factory\UECStandaloneSymfonyForm\FormHelperFactory::class,
            
            Translator::class => Factory\UECStandaloneSymfonyForm\TranslatorFactory::class,
            TranslatorHelper::class => Factory\UECStandaloneSymfonyForm\TranslatorHelperFactory::class,
            
            'form' => function (ServiceLocatorInterface $services) {
                return $services->get('form_factory_builder')->getFormFactory();
            },
            'form_factory_builder' => function (ServiceLocatorInterface $services) {
                $config = $services->get('config');

                $builder = $services->get(UECStandaloneSymfonyForm\FormBuilderFactory::class);

                $extensionPluginManager = $services->get(PluginManager\ExtensionPluginManager::class);
                foreach ($config[Module::class]['extensions']['enabled'] as $e) {
                    $builder->addExtension($extensionPluginManager->get($e));
                }

                $typePluginManager = $services->get(PluginManager\TypePluginManager::class);
                foreach ($config[Module::class]['types']['enabled'] as $e) {
                    $builder->addType($typePluginManager->get($e));
                }

                return $builder;
            },
        ],
        'aliases' => [
            'form_helper' => UECStandaloneSymfonyForm\FormHelperFactory::class
        ]
    ],
];