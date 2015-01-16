<?php

namespace QBH\StoreCoreBundle\DependencyInjection;

use Elcodi\Bundle\ConfigurationBundle\DependencyInjection\ElcodiConfigurationExtension;

class StoreCoreExtension extends ElcodiConfigurationExtension {

    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'store_core';

    public function getConfigFilesLocation()
    {
        return __DIR__ . '/../Resources/config';
    }

    public function getConfigFiles(array $config)
    {
        return [
            'generators',
        ];
    }
}
