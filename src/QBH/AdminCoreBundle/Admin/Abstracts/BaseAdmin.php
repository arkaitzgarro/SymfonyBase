<?php

namespace QBH\AdminCoreBundle\Admin\Abstracts;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Symfony\Component\DependencyInjection\Container;

abstract class BaseAdmin extends Admin
{
    private $container;

    private $factory;

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'id'
    );

    protected $formOptions = array(
        'cascade_validation' => true
    );

    /**
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     * @param AbstractFactory $factory
     */
    public function __construct($code, $class, $baseControllerName, $factory)
    {
        parent::__construct($code, $class, $baseControllerName);

        $this->factory = $factory;
    }

    /**
     * @param Container $container
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param MenuItemInterface $menu
     * @param $action
     * @param AdminInterface $childAdmin
     */
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        $pool = $this->container->get('sonata.admin.pool');
        $adminGroups = $pool->getAdminGroups();

        foreach ($adminGroups as $name => $adminGroup) {
            if (isset($adminGroup['items'])) {
                foreach ($adminGroup['items'] as $key => $id) {
                    $admin = $pool->getInstance($id);

                    if ($admin->showIn(Admin::CONTEXT_DASHBOARD)) {
                        $groups[$name]['items'][$key] = $admin;
                    } else {
                        unset($groups[$name]['items'][$key]);
                    }
                }
            }

            if (empty($groups[$name]['items'])) {
                unset($groups[$name]);
            }
        }

        $menu->addChild($this->trans('dashboard'), array('uri' => $this->getRouteGenerator()->generate('sonata_admin_dashboard')));
        foreach ($groups as $name => $group) {
            $parent = $menu->addChild(
                'header_' . $this->trans($name),
                array('label' => $this->trans($name), 'attributes' => array('class' => 'submenu'))
            );
            foreach ($group['items'] as $key => $admin) {
                $item = $parent->addChild(
                    $this->trans($admin->getLabel()),
                    array('uri' => $admin->generateUrl('list'))
                );
                if (get_class($this) == get_class($admin)) {
                    $parent[$this->trans($admin->getLabel())]->setCurrent(true);
                    //$item['header_'.$this->trans($name)]->setAttributes(array('class' => 'submenu open'));
                }
            }
        }
    }

    /**
     * Create a new entity
     *
     * @return Object New entity
     */
    public function getNewInstance()
    {
        $object = (new $this->getFactory())->create();

        return $object;
    }

    /**
     * @return AbstractFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @return array
     */
    public function getFormTheme()
    {
        return array('AdminCoreBundle:Form:admin_fields.html.twig');
    }

    public function setBaseRouteName($baseRouteName)
    {
        $this->baseRouteName = $baseRouteName;
    }

    public function setBaseRoutePattern($baseRoutePattern)
    {
        $this->baseRoutePattern = $baseRoutePattern;
    }
}