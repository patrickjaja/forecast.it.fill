<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Kernel;

use Doctrine\ORM\EntityRepository;

class AbstractRepository extends EntityRepository
{
    public function findOneOrCreate(array $criteria)
    {
        $entity = $this->findOneBy($criteria);

        if (null === $entity)
        {
            $entity = new $this->getClassName();
            $entity->setTheDataSomehow($criteria);
            $this->_em->persist($entity);
            $this->_em->flush();
        }

        return $entity;
    }
}
