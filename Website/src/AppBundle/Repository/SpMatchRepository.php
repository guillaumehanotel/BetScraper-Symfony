<?php

namespace AppBundle\Repository;

use Symfony\Component\Validator\Constraints\DateTime;

class SpMatchRepository extends \Doctrine\ORM\EntityRepository {

    public function findAllFromToday() {

        date_default_timezone_set('Europe/Paris');
        $now = date("Y-m-d H:i:s");

        return $this->createQueryBuilder('m')
            ->where('m.matchDate > :now')
            ->setParameter('now', $now)
            ->orderBy('m.matchDate','ASC')
            ->getQuery()
            ->getResult();

    }


}