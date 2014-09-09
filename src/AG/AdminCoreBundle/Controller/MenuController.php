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

namespace AG\AdminCoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MenuController
 */
class MenuController extends Controller
{
    /**
     * Subrequest rendering left side menu
     *
     * @Route(
     *      path = "components/menu/side",
     *      name = "admin_menu_side"
     * )
     * @Template("@AdminCore/Navs/side.html.twig")
     *
     * @return array
     */
    public function sideNavAction()
    {
        $menuItems = $this->container->get('elcodi.core.menu.service.menu_manager')->loadMenuByCode('admin');

        return [
            'menu_items' => $menuItems
        ];
    }
}
