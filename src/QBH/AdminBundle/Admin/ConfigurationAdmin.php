<?php
namespace QBH\AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use QBH\AdminCoreBundle\Admin\Abstracts\BaseAdmin;

class ConfigurationAdmin extends BaseAdmin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
//            ->add('position', null, array('label' => 'Posición'))
            ->add('namespace', null, array('label' => 'Categoría'))
            ->addIdentifier('key', null, array('label' => 'Clave'))
            ->add('name', null, array('label' => 'Descripción'))
            ->add('enabled', 'boolean', array('label' => 'Activo', 'editable' => true))
        ;

        $listMapper->add('_action', 'actions', array(
            'actions' => array(
                'edit' => array(),
                'delete' => array(),
            )
        ));
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('general', array('label' => 'General'))
                ->add('name', null, array('label' => 'Descripción'))
                ->add('key', null, array('label' => 'Clave', 'disabled' => $this->id($this->getSubject())))
                ->add('position', null, array('label' => 'Orden'))
                ->add('enabled', null, array('label' => 'Activo', 'required' => false))
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
//            ->add('namespace', null, array('label' => 'Categoría'))
//            ->add('key', null, array('label' => 'Clave'))
//            ->add('name', null, array('label' => 'Nombre'))
        ;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query
            ->orderBy($query->getRootAlias() . '.namespace', 'ASC')
            ->addOrderBy($query->getRootAlias() . '.position', 'ASC');

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        if (!$this->isDevelopment()) {
            // Remove delete route in production env
            $collection->remove('delete');
        }
    }
}
