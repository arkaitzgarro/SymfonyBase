<?php
namespace QBH\AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use QBH\AdminCoreBundle\Admin\Abstracts\BaseAdmin;

class LanguageAdmin extends BaseAdmin
{
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'name'
    );

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('iso', null, array('label' => 'ISO'))
            ->add('name', null, array('label' => 'Nombre'))
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
            ->with('translations')
                ->add('name', null, array('label' => 'Nombre'))
                ->createTranslatableEntities()
            ->end()

            ->with('general', array('label' => 'General'))
                ->add('iso', null, array('label' => 'ISO'))
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
