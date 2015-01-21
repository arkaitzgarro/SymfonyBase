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

namespace QBH\StoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use QBH\StoreBundle\Controller\BaseController;

/**
 * Class FrontendController
 * @package QBH\StoreBundle\Controller
 */
class FrontendController extends BaseController
{
    public function indexAction(Request $request)
    {
        return $this->render(
            'StoreBundle:Frontend:index.html.twig',
            [

            ]
        );
    }

    public function footerAction()
    {
        return $this->render(
            'StoreBundle:Partial:footer.html.twig',
            [

            ]
        );
    }

    public function headerAction()
    {
        return $this->render(
            'StoreBundle:Partial:header.html.twig',
            [
                'elements' => $this->container->getParameter('elcodi.core.configuration.elements')
            ]
        );
    }
}