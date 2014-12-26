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

namespace QBH\AdminCoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Type for a login form
 */
class LoginType extends AbstractType
{
    /**
     * @var UrlGeneratorInterface
     *
     * Router
     */
    protected $router;

    /**
     * Constructor
     *
     * @param UrlGeneratorInterface $router Router
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
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
            ->setAction(
                $this
                    ->router
                    ->generate('admin_login_check')
            )
            ->setMethod('POST')
            ->add('username', 'text', array(
                'required' => true,
                'label'    => 'username'
            ))
            ->add('password', 'password', array(
                'required' => true,
                'label'    => 'password'
            ));
    }

    /**
     * Set form default values
     * @param OptionsResolverInterface $resolver [description]
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'translation_domain' => 'admin',
            )
        );
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'admin_user_form_type_login';
    }
}
