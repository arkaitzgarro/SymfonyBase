<?php
namespace QBH\AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use QBH\AdminCoreBundle\Admin\Abstracts\BaseAdmin;

class ProductAdmin extends BaseAdmin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('sku', null, array('label' => 'SKU'))
            ->add('name', 'boolean', array('label' => 'Nombre'))
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
                ->add('shortDescription', null, array('label' => 'Descripción corta'))
                ->add('description', null, array('label' => 'Descripción'))
            ->end()

            ->createSEOGroup()

            ->createTranslatableEntities()

            ->with('precio', array('label' => 'Precio'))
                ->add('price', 'money_object', array('label' => 'Precio'))
            ->end()

            ->with('general', array('label' => 'General'))
                ->add('sku', null, array('label' => 'SKU', 'required' => false))
                ->add('enabled', null, array('label' => 'Activo', 'required' => false))
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => 'Nombre'))
            ->add('description', null, array('label' => 'Descripción'))
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
}
