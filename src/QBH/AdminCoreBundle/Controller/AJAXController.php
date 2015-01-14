<?php
/**
 * Created by PhpStorm.
 * User: arkaitz
 * Date: 27/12/14
 * Time: 11:28
 */

namespace QBH\AdminCoreBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Class IndexController
 *
 * @Route(
 *      path = "/ajax",
 * )
 */
class AJAXController extends Controller
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
        } catch (\Exception $e) {
            return [
                'result'  => 'ko',
                'code'    => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        $content = $this->render("@AdminCore/Tables/enabled.html.twig", [
            "entity" => $entity
        ])->getContent();

        return [
            'result'  => 'ok',
            'code'    => '200',
            'content' => $content,
        ];
    }

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
