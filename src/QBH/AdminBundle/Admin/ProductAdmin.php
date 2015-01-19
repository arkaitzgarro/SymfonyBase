<?php
namespace QBH\AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use QBH\AdminCoreBundle\Admin\Abstracts\BaseAdmin;

class ProductAdmin extends BaseAdmin
{
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'name'
    );

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('sku', null, array('label' => 'SKU'))
            ->add('name', null, array('label' => 'Nombre'))
            ->add(
                'manufacturer',
                null,
                array(
                    'label' => 'Marca',
                    'sortable'=>true,
                    'sort_field_mapping' => array('fieldName' => 'name'),
                    'sort_parent_association_mappings' => array(array('fieldName' => 'manufacturer'))
                    )
            )
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
                ->add('reducedPrice', 'money_object', array('label' => 'Precio oferta', 'required' => false))
            ->end()

            ->with('general', array('label' => 'General'))
                ->add('sku', null, array('label' => 'SKU', 'required' => false))
                ->add(
                    'manufacturer',
                    'entity',
                    array(
                        'class' => 'QBH\StoreProductBundle\Entity\Manufacturer',
                        'label' => 'Marca',
                        'multiple' => false,
                        'required' => false,
                    )
                )
                ->add(
                    'principalCategory',
                    'entity',
                    array(
                        'class' => 'QBH\StoreProductBundle\Entity\Category',
                        'label' => 'Categoría principal',
                        'multiple' => false,
                        'required' => false,
                    )
                )
                ->add(
                    'categories',
                    'entity',
                    array(
                        'class' => 'QBH\StoreProductBundle\Entity\Category',
                        'label' => 'Categorías',
                        'multiple' => true,
                        'required' => false,
                    )
                )
                ->add(
                    'tags',
                    'entity',
                    array(
                        'class' => 'QBH\StoreProductBundle\Entity\ProductTag',
                        'label' => 'Tags',
                        'multiple' => true,
                        'required' => false,
                    )
                )
                ->add('stock', null, array('label' => 'Stock', 'required' => false))
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
}
