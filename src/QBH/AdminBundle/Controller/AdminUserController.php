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

namespace QBH\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use QBH\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;
use QBH\AdminCoreBundle\Controller\Interfaces\EnableableControllerInterface;

/**
 * Class AdminUserController
 *
 * @Route(
 *      path = "/user/admin",
 * )
 */
class AdminUserController extends AbstractAdminController implements EnableableControllerInterface
{
    /**
     * Return the class name for this controller
     *
     * @return string
     */
    public function getClassName()
    {
        return 'adminuser';
    }
}
