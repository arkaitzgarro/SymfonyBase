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
namespace QBH\AdminCoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Class AJAXController
 *
 * @Route(
 *      path = "/ajax",
 * )
 */
class AJAXController extends Controller
{

    /**
     * Get entity manager from an entity
     *
     * @param IdentifiableInterface $entity Entity
     *
     * @return ObjectManager specific manager
     */
    protected function getManagerForClass(IdentifiableInterface $entity)
    {
        return $this
            ->get('elcodi.manager_provider')
            ->getManagerByEntityNamespace(get_class($entity));
    }
}
