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

namespace QBH\StoreBundle\Entity\Interfaces;


/**
 * Interface TagInterface
 * @package QBH\StoreBundle\Entity\Interfaces
 */
interface TagInterface
{
    /**
     * @return String
     */
    public function getName();

    /**
     * @param $name
     * @return  Self object
     */
    public function setName($name);
}