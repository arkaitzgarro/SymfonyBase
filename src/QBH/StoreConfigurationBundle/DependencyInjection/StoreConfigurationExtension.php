<?php

namespace QBH\StoreConfigurationBundle\DependencyInjection;

use Elcodi\Bundle\ConfigurationBundle\DependencyInjection\ElcodiConfigurationExtension;

class StoreConfigurationExtension extends ElcodiConfigurationExtension {

    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'store_configuration';

    public function getConfigFilesLocation()
    {
        return __DIR__ . '/../Resources/config';
    }

    public function getConfigFiles(array $config)
    {
        return [
            'factories',
            'repositories',
        ];
    }
}
