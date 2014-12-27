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
 */

namespace QBH\AdminCoreBundle\Twig;

use Twig_Extension;

/**
 * Class AdminCoreExtension
 * @package QBH\AdminCoreBundle\Twig
 * @author Arkaitz Garro <hola@arkaitzgarro.com>
 */
class AdminCoreExtension extends Twig_Extension {

    public function getFunctions()
    {
        return array(
            'class' => new \Twig_SimpleFunction('class', array($this, 'getClass'))
        );
    }

    public function getName()
    {
        return 'admin_core_twig_extension';
    }

    public function getClass($object)
    {
        return (new \ReflectionClass($object))->getName();
    }
}