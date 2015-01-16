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

namespace QBH\StoreCoreBundle\Entity\Traits;

/**
 * Trait adding position fields and methods
 */
trait PositionTrait
{
    /**
     * @var integer
     *
     * Position
     */
    protected $position = 1;

    /**
     * Set position
     *
     * @param integer $position position value
     *
     * @return $this Self object
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Move element one position up (from 5 to 4)
     */
    public function decreasePosition()
    {
        if ($this->position > 1) {
            $this->position--;
        }
    }

    /**
     * Move element one position down (from 4 to 5)
     */
    public function increasePosition()
    {
        $this->position++;
    }
}
