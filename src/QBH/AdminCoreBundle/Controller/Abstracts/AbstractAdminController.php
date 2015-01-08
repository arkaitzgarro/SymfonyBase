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

namespace QBH\AdminCoreBundle\Controller\Abstracts;

use Closure;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Class AbstractAdminController
 */
abstract class AbstractAdminController extends Controller
{
    /**
     * List elements of certain entity type.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @param Request $request          Request
     * @param integer $page             Page
     * @param integer $limit            Limit of items per page
     * @param string  $orderByField     Field to order by
     * @param string  $orderByDirection Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "list/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "25",
     *          "orderByField" = "username",
     *          "orderByDirection" = "ASC",
     *      },
     * )
     * @Template("AdminCoreBundle:Common:list.html.twig")
     * @Method({"GET"})
     */
    public function listAction(
        Request $request,
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    ) {
        return [
            'class'            => $this->getClassName(),
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
        ];
    }

    /**
     * New element action
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @return array Result
     *
     * @Route(
     *      path = "/new",
     * )
     * @Template("AdminCoreBundle:Common:new.html.twig")
     * @Method({"GET"})
     */
    public function newAction()
    {
        return [
            'class' => $this->getClassName(),
        ];
    }

    /**
     * Save new element action
     *
     * Should be POST
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to save
     * @param FormInterface  $form    Form view
     * @param boolean        $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/save",
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.user.factory.admin_user",
     *      },
     *      persist = true
     * )
     * @FormAnnotation(
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function saveAction(
        Request $request,
        IdentifiableInterface $entity,
        FormInterface $form,
        $isValid
    ) {
        $this
            ->getManagerForClass($entity)
            ->flush($entity);

        return $this->redirectRoute("admin_admin_user_view", [
            'id'    =>  $entity->getId(),
        ]);
    }

    /**
     * Edit element action
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @param Request $request Request
     * @param integer $id      Entity id
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/edit",
     * )
     * @Template("AdminCoreBundle:Common:edit.html.twig")
     * @Method({"GET"})
     */
    public function editAction(
        Request $request,
        $id
    ) {
        return [
            'class' => $this->getClassName(),
            'id'    => $id,
        ];
    }

    /**
     * Updated edited element action
     *
     * Should be POST
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to update
     * @param FormInterface  $form    Form view
     * @param boolean        $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}/update",
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.user.entity.admin_user.class",
     *      mapping = {
     *          "id": "~id~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "admin_user_form_type_admin_user",
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function updateAction(
        Request $request,
        IdentifiableInterface $entity,
        FormInterface $form,
        $isValid
    ) {
        $this
            ->getManagerForClass($entity)
            ->flush($entity);

        if ($request->get('btn_update_and_list')) {
            $path = "qbh_admin_" . $this->getClassName() . "_list";
            return $this->redirectRoute($path);
        }

        $path = "qbh_admin_" . $this->getClassName() . "_edit";
        return $this->redirectRoute($path, [
            'id'    =>  $entity->getId(),
        ]);
    }

    /**
     * Updated edited element action
     *
     * @param Request        $request     Request
     * @param AbstractEntity $entity      Entity to delete
     * @param string         $redirectUrl Redirect url
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}/delete",
     * )
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.user.entity.admin_user.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     * @JsonResponse
     */
    public function deleteAction(
        Request $request,
        IdentifiableInterface $entity,
        $redirectUrl = null
    ) {
        try {
            $this->deleteEntity($entity);

            return [
                'result' => 'ok',
            ];
        } catch (Exception $e) {
            return [
                'result'  => 'ko',
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Enable entity
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to enable
     *
     * @return array Result
     */
    public function enableAction(
        Request $request,
        EnabledInterface $entity
    ) {
        return $this->getResponse($request, function () use ($entity) {

            /**
             * @var EnabledInterface $entity
             */
            $entity->setEnabled(true);
            $entityManager = $this->getManagerForClass($entity);
            $entityManager->flush($entity);
        });
    }

    /**
     * Disable entity
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to disable
     *
     * @return array Result
     */
    public function disableAction(
        Request $request,
        EnabledInterface $entity
    ) {
        return $this->getResponse($request, function () use ($entity) {

            /**
             * @var EnabledInterface $entity
             */
            $entity->setEnabled(false);
            $entityManager = $this->getManagerForClass($entity);
            $entityManager->flush($entity);
        });
    }

    /**
     * Updated edited element action
     */
    public function deleteEntity(
        IdentifiableInterface $entity
    ) {
    }

    /**
     * Controller helpers
     */

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

    /**
     * Get entity repository from an entity
     *
     * @param AbstractEntity $entity Entity
     *
     * @return ObjectManager specific manager
     */
    protected function getRepositoryForClass(AbstractEntity $entity)
    {
        return $this
            ->get('elcodi.repository_provider')
            ->getRepositoryByEntityNamespace(get_class($entity));
    }

    /**
     * Return a RedirectResponse given a route name and an array of parameters
     *
     * @param string $route  Route
     * @param array  $params Params
     *
     * @return RedirectResponse Response
     */
    protected function redirectRoute($route, array $params = array())
    {
        return $this->redirect($this->generateUrl($route, $params));
    }

    /**
     * Output helpers
     */

    /**
     * Return response
     *
     * This method takes into account the type of the request ( GET or POST )
     *
     * @param Request $request     Request
     * @param Closure $closure     Closure
     * @param string  $redirectUrl Redirect url
     *
     * @return mixed Response
     *
     * @throws Exception Something has gone wrong
     */
    protected function getResponse(
        Request $request,
        Closure $closure,
        $redirectUrl = null
    ) {
        try {
            $closure();

            return $this->getOkResponse($request, $redirectUrl);
        } catch (Exception $exception) {
            return $this->getFailResponse($request, $exception);
        }
    }

    /**
     * Return ok response
     *
     * This method takes into account the type of the request ( GET or POST )
     *
     * @param Request $request     Request
     * @param string  $redirectUrl Redirect url
     *
     * @return mixed Response
     */
    protected function getOkResponse(Request $request, $redirectUrl = null)
    {
        $redirectRoute = $redirectUrl
            ? $this->generateUrl($redirectUrl)
            : $request->headers->get('referer');

        return ('GET' === $request->getMethod())
            ? $this->redirect($redirectRoute)
            : new Response(json_encode([
                'result'  => 'ok',
                'code'    => '0',
                'message' => '',
            ]));
    }

    /**
     * Return fail response
     *
     * This method takes into account the type of the request ( GET or POST )
     *
     * @param Request   $request   Request
     * @param Exception $exception Exception
     *
     * @return mixed Response
     *
     * @throws Exception Something has gone wrong
     */
    protected function getFailResponse(Request $request, Exception $exception)
    {
        if ('GET' === $request->getMethod()) {
            throw $exception;
        }

        return new Response(json_encode([
            'result'  => 'ko',
            'code'    => $exception->getCode(),
            'message' => $exception->getMessage(),
        ]));
    }

    /**
     * Return the class name for this controller
     *
     * @return string
     */
    abstract public function getClassName();
}
