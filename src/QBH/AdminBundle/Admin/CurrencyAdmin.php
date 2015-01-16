<?php
namespace QBH\AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use QBH\AdminCoreBundle\Admin\Abstracts\BaseAdmin;

class CurrencyAdmin extends BaseAdmin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'Nombre'))
            ->add('iso', null, array('label' => 'ISO'))
            ->add('symbol', null, array('label' => 'Símbolo'))
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
            ->add('name', null, array('label' => 'Nombre'))
            ->add('iso', null, array('label' => 'ISO'))
            ->add('symbol', null, array('label' => 'Símbolo'))
            ->add('enabled', null, array('label' => 'Activo', 'required' => false))
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => 'Nombre'))
        ;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query
            ->orderBy($query->getRootAlias() . '.name', 'ASC')
        ;

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        if (!$this->isDevelopment()) {
            // Remove create route in production env
            $collection->remove('create');
            // Remove delete route in production env
            $collection->remove('delete');
        }
    }
}
