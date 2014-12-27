<?php

/**
 * This file is part of the Symfony Base project, and it's based on Elcodi project
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Arkaitz Garro <hola@arkaitzgarro.com>
 */

namespace QBH\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\Component\User\ElcodiUserProperties;
use Elcodi\Component\User\Factory\AdminUserFactory;

/**
 * Class AdminUserType
 */
class AdminUserType extends AbstractType
{
    /**
     * @var AdminUserFactory
     *
     * Customer factory
     */
    protected $adminUserFactory;

    /**
     * Constructor
     *
     * @param AdminUserFactory $adminUserFactory Customer factory
     */
    public function __construct(
        AdminUserFactory $adminUserFactory
    ) {
        $this->adminUserFactory = $adminUserFactory;
    }

    /**
     * Default form options
     *
     * @param OptionsResolverInterface $resolver
     *
     * @return array With the options
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'empty_data' => $this->adminUserFactory->create(),
            'translation_domain' => 'admin'
        ));
    }

    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add(
                $builder->create('general', 'form', array('virtual' => true))
                    ->add('username', 'text', array(
                        'required' => true,
                        'label'    => 'Usuario'
                    ))
                    ->add('email', 'email', array(
                        'required' => true,
                        'label'    => 'Email'
                    ))
                    ->add('firstname', 'text', array(
                        'required' => true,
                        'label'    => 'Nombre'
                    ))
                    ->add('lastname', 'text', array(
                        'required' => false,
                        'label'    => 'Apellidos'
                    ))
                    ->add('password', 'repeated', array(
                        'type' => 'password',
                        'required' => false,
                        'invalid_message' => 'password_must_match.',
                        'first_options'  => array('label' => 'Contraseña'),
                        'second_options' => array('label' => 'Repetir contraseña'),
                    ))
//                    ->add('gender', 'choice', array(
//                        'choices'   => array(
//                            ElcodiUserProperties::GENDER_MALE => 'Hombre',
//                            ElcodiUserProperties::GENDER_FEMALE => 'Mujer',
//                        ),
//                        'required' => true,
//                        'label'    => 'Sexo'
//                    ))
//                    ->add('birthday', 'date', array(
//                        'required' => false,
//                        'widget'   => 'single_text',
//                        'format'   => 'yyyy-MM-dd',
//                        'label'    => 'Fecha de nacimiento',
//                    ))
                    ->add('enabled', 'checkbox', array(
                        'required' => false,
                        'label'    => 'Activo'
                    ))
            )
            ;
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'admin_user_form_type_admin_user';
    }
}
