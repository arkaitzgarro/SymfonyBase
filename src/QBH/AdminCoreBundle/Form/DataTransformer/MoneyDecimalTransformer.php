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

namespace QBH\AdminCoreBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class MoneyDecimalTransformer
 * @package QBH\AdminCoreBundle\Form\DataTransformer
 */
class MoneyDecimalTransformer implements DataTransformerInterface
{

    /**
     * Transforms an amount to an amount with decimals
     *
     * @param  int|null $amount
     * @return decimal
     */
    public function transform($amount)
    {
        if (null === $amount) {
            return null;
        }

        return $amount / 100;
    }

    /**
     * Transforms an amount (with decimals) to an amount without decimals.
     *
     * @param  decimal $amount
     *
     * @return int|null
     */
    public function reverseTransform($amount)
    {
        if (!$amount) {
            return null;
        }

        return (int) ($amount * 100);
    }

}