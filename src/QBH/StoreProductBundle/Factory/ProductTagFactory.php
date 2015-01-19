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

namespace QBH\StoreProductBundle\Factory;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class ProductTagFactory
 * @package QBH\StoreProductBundle\Factory
 */
class ProductTagFactory extends AbstractFactory
{
    /**
     * Creates an instance of ProductTag
     *
     * @return ProductTag New ProductTag entity
     */
    public function create()
    {
        /**
         * @var ProductTag $tag
         */
        $classNamespace = $this->getEntityNamespace();
        $tag = new $classNamespace();
        $tag
            ->setProducts(new ArrayCollection())
            ->setEnabled(true)
            ->setCreatedAt(new DateTime());

        return $tag;
    }
}