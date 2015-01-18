<?php
namespace QBH\AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use QBH\AdminCoreBundle\Admin\Abstracts\BaseAdmin;

class CategoryAdmin extends BaseAdmin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('position', null, array('label' => 'Posición'))
            ->addIdentifier('name', null, array('label' => 'Nombre'))
            ->add('description', null, array('label' => 'Descripción'))
            ->add('root', 'boolean', array('label' => 'Principal', 'editable' => true))
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
                ->add('description', null, array('label' => 'Descripción'))
            ->end()

            ->createSEOGroup()

            ->createTranslatableEntities()

            ->with('general', array('label' => 'General'))
                 ->add(
                     'parent',
                     'entity',
                     array(
                         'class' => 'QBH\StoreProductBundle\Entity\Category',
                         'label' => 'Categoría superior',
                         'multiple' => false,
                         'required' => false,
                         'placeholder' => 'select_one',
                     )
                 )
                ->add('position', null, array('label' => 'Posición'))
                ->add('root', null, array('label' => 'Principal', 'required' => false))
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
