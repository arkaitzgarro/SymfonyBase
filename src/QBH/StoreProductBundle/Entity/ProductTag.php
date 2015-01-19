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

namespace QBH\StoreProductBundle\Entity;

use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use QBH\StoreBundle\Entity\Abstracts\AbstractTag;

/**
 * Class ProductTag
 * @package QBH\StoreProductBundle\Entity
 */
class ProductTag extends AbstractTag
{
    /**
     * @var Collection
     *
     * Many-to-Many association between tags
     * and products. The resulting collection could be huge.
     */
    protected $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * Set products
     *
     * @param Collection $products Products
     *
     * @return Category self Object
     */
    public function setProducts(Collection $products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Add product
     *
     * @param ProductInterface $product Product
     *
     * @return Product self Object
     */
    public function addProduct(ProductInterface $product)
    {
        $this->products->add($product);

        return $this;
    }
}