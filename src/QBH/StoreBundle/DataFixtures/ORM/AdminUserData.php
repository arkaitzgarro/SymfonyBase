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
use Elcodi\Component\User\ElcodiUserProperties;

/**
 * Class AdminUserData
 * @package QBH\StoreBundle\DataFixtures\ORM
 */
class AdminUserData extends AbstractFixture {

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var AdminUserInterface $adminUser
         */
        $adminUser = $this
            ->container
            ->get('elcodi.factory.admin_user')
            ->create()
            ->setUsername('admin')
            ->setPassword('1234')
            ->setEmail('admin@admin.com')
            ->setFirstName('John')
            ->setLastName('Wayne')
            ->setGender(ElcodiUserProperties::GENDER_MALE)
            ->setEnabled(true);

        $manager->persist($adminUser);
        $manager->flush();
    }
}