<?php

/*
 * This file is part of the Elcodi package.
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

namespace QBH\StoreCoreBundle\Repository\Abstracts;

use Doctrine\ORM\EntityRepository;

/**
 * BaseRepository
 */
abstract class BaseRepository extends EntityRepository
{
    /**
     * Find one entity by slug
     * @param  String $slug Unique slug
     * @return Entity
     */
    public function findOneBySlug($slug)
    {
        $entity = $this
            ->createQueryBuilder('c')
            ->where('c.enabled = :enabled')
            ->andWhere('c.slug = :slug')
            ->setParameters(array(
                'enabled'   =>  true,
                'slug'      =>  $slug,
            ))
            ->getQuery()
            ->getOneOrNullResult();

        return $entity;
    }

    /**
     * Find one entity by SEO slug
     * @param  String $slug Unique SEO slug
     * @return Entity
     */
    public function findOneBySEOSlug($slug)
    {
        $entity = $this
            ->createQueryBuilder('c')
            ->andWhere('c.slug = :slug')
            ->setParameters(array(
                'slug'      =>  $slug,
            ))
            ->getQuery()
            ->getOneOrNullResult();

        return $entity;
    }
}
