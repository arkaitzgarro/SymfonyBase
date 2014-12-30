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

namespace QBH\AdminBundle\Controller\Component;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use QBH\AdminCoreBundle\Controller\Component\AbstractComponentController;

/**
 * Class CustomerComponentController
 *
 * @Route(
 *      path = "/customer/admin",
 * )
 */
class CustomerComponentController extends AbstractComponentController
{
    const LIST_TPL = "AdminBundle:Customer:Component/listComponent.html.twig";
    const EDIT_TPL = "AdminBundle:Customer:Component/formComponent.html.twig";

    /**
     * Return the class name for this controller
     *
     * @return string
     */
    public function getClassName()
    {
        return "customer";
    }

    /**
     * Get list template name
     *
     * @return string
     */
    public function getListTemplateName()
    {
        return self::LIST_TPL;
    }
}
