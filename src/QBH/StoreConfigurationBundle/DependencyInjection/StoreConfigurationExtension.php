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

    protected function getParametrizationValues(array $config)
    {
        return [
            "elcodi.core.configuration.entity.configuration.class" => 'QBH\StoreConfigurationBundle\Entity\Configuration',
            "elcodi.core.configuration.entity.configuration.mapping_file" => '@StoreConfigurationBundle/Resources/config/doctrine/Configuration.orm.yml',
        ];
    }

    public function getConfigFiles(array $config)
    {
        return [
            'factories',
            'repositories',
        ];
    }
}
