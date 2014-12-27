<?php
/**
 * Created by PhpStorm.
 * User: arkaitz
 * Date: 27/12/14
 * Time: 11:28
 */

namespace QBH\AdminCoreBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use QBH\AdminCoreBundle\Controller\Abstracts\AbstractAdminController as BaseController;


/**
 * Class IndexController
 *
 * @Route(
 *      path = "/ajax",
 * )
 */
class AJAXController extends BaseController
{
    /**
     * Toggle enabled status of an entity
     *
     * @return array
     *
     * @Route(
     *      path = "/toggle-enabled/{namespace}/{id}",
     *      name = "admin_toggle_enabled"
     * )
     *
     * @JsonResponse
     */
    public function toggleEnabledAction(Request $request, $namespace, $id)
    {
        try {
            $entity = $this
                ->get('elcodi.repository_provider')
                ->getRepositoryByEntityNamespace($namespace)
                ->findOneById($id);

            $entity->setEnabled(!$entity->isEnabled());

            $entityManager = $this->getManagerForClass($entity);
            $entityManager->persist($entity);
            $entityManager->flush($entity);

            $content = $this->render("@AdminCore/Tables/enabled.html.twig", [
                "entity" => $entity
            ])->getContent();

        } catch (\Exception $e) {
            return [
                'result'  => 'ko',
                'code'    => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return [
            'result'  => 'ok',
            'code'    => '200',
            'content' => $content,
        ];
    }
}
