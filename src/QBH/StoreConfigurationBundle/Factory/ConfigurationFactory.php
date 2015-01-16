<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Arkaitz Garro <hola@arkaitzgarro.com>
 */

namespace QBH\StoreConfigurationBundle\Factory;

use Elcodi\Component\Configuration\Factory\ConfigurationFactory as BaseFactory;

class ConfigurationFactory extends BaseFactory {

    public function create()
    {
        $configuration = parent::create();

        $configuration
            ->enable()
            ->setPosition(1)
        ;

        return $configuration;
    }
}