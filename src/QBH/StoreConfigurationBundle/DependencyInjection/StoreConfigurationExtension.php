<?php

namespace QBH\StoreConfigurationBundle\DependencyInjection;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

class StoreConfigurationExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface {

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
//            'factories',
//            'repositories',
        ];
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     *
     * @api
     */
    public function getAlias()
    {
        return static::EXTENSION_NAME;
    }

    /**
     * Get entities overrides.
     *
     * Result must be an array with:
     * index: Original Interface
     * value: Parameter where class is defined.
     *
     * @return array Overrides definition
     */
    public function getEntitiesOverrides()
    {
        return [
        ];
    }
}
