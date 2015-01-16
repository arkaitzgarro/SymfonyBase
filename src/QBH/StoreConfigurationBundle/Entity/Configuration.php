<?php

/**
 * This file is part of the Symfony Base project, and it's based on Elcodi project
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

namespace QBH\StoreConfigurationBundle\Entity;

use Elcodi\Component\Configuration\Entity\Configuration as BaseConfiguration;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;

use QBH\StoreCoreBundle\Component\Traits\PositionTrait;

class Configuration extends BaseConfiguration
{

    use
        IdentifiableTrait,
        EnabledTrait,
        PositionTrait;

    public function __toString()
    {
        return $this->getNamespace() . '.' . $this->getKey();
    }
}