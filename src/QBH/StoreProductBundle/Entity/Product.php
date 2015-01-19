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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Elcodi\Component\Product\Entity\Product as BaseProduct;
use QBH\StoreBundle\Entity\Interfaces\TagInterface;

/**
 * Class Product
 * @package QBH\StoreProductBundle\Entity
 */
class Product extends BaseProduct
{
    /**
     * @var Collection
     *
     * Many-to-Many association between products and tags.
     */
    protected $tags;

    public function __construct()
    {
        parent::__construct();

        $this->tags = new ArrayCollection();
    }

    /**
     * Set tags
     *
     * @param Collection $tags Tags
     *
     * @return Product self Object
     */
    public function setTags(Collection $tags)
    {
        $this->tags->clear();

        if (!$tags->isEmpty()) {
            foreach ($tags as $tag) {
                $this->addTag($tag);
            }
        }

        return $this;
    }

    /**
     * Get tags
     *
     * @return Collection tags
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add tag
     *
     * @param TagInterface $tag Tag
     *
     * @return Product self Object
     */
    public function addTag(TagInterface $tag)
    {
        if (!$this->tags->contains($tag)) {
            $tag->addProduct($this);
            $this->tags->add($tag);
        }

        return $this;
    }

    /**
     * Remove tag
     *
     * @param TagInterface $tag Tag
     *
     * @return Product self Object
     */
    public function removeTag(TagInterface $tag)
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}