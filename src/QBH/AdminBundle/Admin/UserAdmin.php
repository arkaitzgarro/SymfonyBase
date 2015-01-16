<?php
namespace QBH\AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use QBH\AdminCoreBundle\Admin\Abstracts\BaseAdmin;

class UserAdmin extends BaseAdmin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('firstname', null, array('label' => 'Nombre'))
            ->add('lastname', null, array('label' => 'Apellidos'))
            ->addIdentifier('email', null, array('label' => 'Email'))
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
            ->add('firstname', null, array('label' => 'Nombre'))
            ->add('lastname', null, array('label' => 'Apellidos'))
            ->add('username', null, array('label' => 'Usuario'))
            ->add('email', null, array('label' => 'Email'))
            ->add(
                'password',
                'repeated',
                array(
                    'type' => 'password',
                    'label' => 'Contraseña',
                    'first_options'  => [
                        'label' => false
                    ],
                    'second_options' => [
                        'label' => 'Repetir contraseña',
                    ],
                    'required' => (!$this->getSubject() || is_null($this->getSubject()->getId()))
                )
            )
            ->add('enabled', null, array('label' => 'Activo', 'required' => false))
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('firstname', null, array('label' => 'Nombre'))
            ->add('lastname', null, array('label' => 'Apellidos'))
            ->add('email', null, array('label' => 'Email'))
            ->add('username', null, array('label' => 'Usuario'))
        ;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query
            ->orderBy($query->getRootAlias() . '.username', 'ASC');

        return $query;
    }
}
