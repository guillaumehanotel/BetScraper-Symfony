<?php


namespace AppBundle\Repository;


class CoteRepository extends \Doctrine\ORM\EntityRepository {


    public function findAllRecentCote() {
        date_default_timezone_set('Europe/Paris');
        $now = date("Y-m-d H:i:s");

        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT c, m
                     FROM AppBundle:Cote c
                     JOIN c.match m
                     WHERE c.coteDate = (
                        SELECT MAX(c1.coteDate)
                        FROM AppBundle:Cote c1
                        JOIN c1.match m1
                        WHERE m1.matchId = m.matchId )
                     AND m.matchDate > :now
                     ORDER BY m.matchDate ASC'
            )->setParameter('now', $now);

        return $query->getResult();

    }

}

