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

namespace QBH\AdminCoreBundle\Form;

use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;
use Sonata\AdminBundle\Form\FormMapper as BaseFormMapper;

/**
 * Class FormMapper
 * @package QBH\AdminCoreBundle\Form
 */
class FormMapper extends BaseFormMapper {

    use EntityTranslatableFormTrait;


    public function createTranslatableEntities()
    {
        $this->formBuilder->addEventSubscriber($this->getEntityTranslatorFormEventListener());

        return $this;
    }

    public function createSEOGroup()
    {
        $this
            ->with('seo')
                ->add('slug', null, array('label' => 'Slug', 'help' => 'slug_help'))
                ->add('metaTitle', null, array('label' => 'Meta título'))
                ->add('metaDescription', 'textarea', array('label' => 'Meta descripción', 'required' => false))
                ->add('metaKeywords', null, array('label' => 'Palabras clave'))
            ->end();

        return $this;
    }

}