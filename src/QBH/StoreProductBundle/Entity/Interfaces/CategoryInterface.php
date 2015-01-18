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

namespace QBH\StoreProductBundle\Entity\Interfaces;

use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface as BaseCategoryInterface;

/**
 * Class CategoryInterface
 * @package QBH\StoreProductBundle\Entity\Interfaces
 */
interface CategoryInterface extends BaseCategoryInterface
{
    /**
     * Set description
     *
     * @param string description Description
     *
     * @return $this Self object
     */
    public function setDescription($description);

    /**
     * Return description
     *
     * @return string description
     */
    public function getDescription();
}