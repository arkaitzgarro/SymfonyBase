<?php

/**
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
 */

namespace QBH\AdminBundle\Controller\Component;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use QBH\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\User\Entity\Interfaces\AdminUserInterface;

/**
 * Class AdminUserComponentController
 *
 * @Route(
 *      path = "/user/admin",
 * )
 */
class AdminUserComponentController extends AbstractAdminController
{
    private $className = "adminuser";

    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param Paginator           $paginator           Paginator instance
     * @param PaginatorAttributes $paginatorAttributes
     * @param integer             $page                Page
     * @param integer             $limit               Limit of items per page
     * @param string              $orderByField        Field to order by
     * @param string              $orderByDirection    Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/list/component/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "id",
     *          "orderByDirection" = "DESC",
     *      },
     * )
     * @Template("AdminBundle:AdminUser:Component/listComponent.html.twig")
     * @Method({"GET"})
     *
     * @PaginatorAnnotation(
     *      attributes = "paginatorAttributes",
     *      class = "elcodi.core.user.entity.admin_user.class",
     *      page = "~page~",
     *      limit = "~limit~",
     *      orderBy = {
     *          {"x", "~orderByField~", "~orderByDirection~"}
     *      }
     * )
     */
    public function listComponentAction(
        Paginator $paginator,
        PaginatorAttributes $paginatorAttributes,
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    )
    {
        return [
            'class'            => $this->getClassName(),
            'paginator'        => $paginator,
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
            'totalPages'       => $paginatorAttributes->getTotalPages(),
            'totalElements'    => $paginatorAttributes->getTotalElements(),
        ];
    }

    /**
     * New element action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param AdminUserInterface $entity
     * @param FormView $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/new/component",
     * )
     * @Template("AdminBundle:AdminUser:Component/newComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.user.factory.admin_user",
     *      }
     * )
     * @FormAnnotation(
     *      class = "admin_user_form_type_admin_user",
     *      name  = "formView",
     *      entity = "entity"
     * )
     */
    public function newComponentAction(AdminUserInterface $entity, FormView $formView)
    {
        return [
            'class'  => $this->getClassName(),
            'entity' => $entity,
            'form' => $formView,
        ];
    }

    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param AdminUserInterface $entity   Entity
     * @param FormView           $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/edit/component",
     * )
     * @Template("AdminBundle:AdminUser:Component/editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.user.entity.admin_user.class",
     *      mapping = {
     *          "id": "~id~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "admin_user_form_type_admin_user",
     *      name  = "formView",
     *      entity = "entity"
     * )
     */
    public function editComponentAction(
        AdminUserInterface $entity,
        FormView $formView
    )
    {
        return [
            'class'  => $this->getClassName(),
            'entity' => $entity,
            'form'   => $formView,
        ];
    }

    /**
     * Return the class name for this controller
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }
}