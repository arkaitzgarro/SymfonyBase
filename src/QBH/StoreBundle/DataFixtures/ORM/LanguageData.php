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

namespace QBH\StoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class LanguageData
 * @package QBH\StoreBundle\DataFixtures\ORM
 */
class LanguageData extends AbstractFixture {

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $languageFactory  = $this->get('elcodi.factory.language');
        $entityTranslator = $this->get('elcodi.entity_translator');

        /**
         * @var LanguageInterface $language
         */
        $es = $languageFactory
            ->create()
            ->setIso('es')
            ->setEnabled(true);

        $entityTranslator->save($es, array(
            'es' => array(
                'name' => 'Español'
            ),
            'en' => array(
                'name' => 'Spanish'
            )
        ));

        /**
         * @var LanguageInterface $language
         */
        $en = $languageFactory
            ->create()
            ->setIso('en')
            ->setEnabled(true);

        $entityTranslator->save($en, array(
            'es' => array(
                'name' => 'Inglés'
            ),
            'en' => array(
                'name' => 'English'
            )
        ));
    }
}