<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipe
 *
 * @ORM\Table(name="equipe")
 * @ORM\Entity
 */
class Equipe {
    /**
     * @var string
     *
     * @ORM\Column(name="equipe_nom", type="string", length=100, nullable=true)
     */
    private $equipeNom;

    /**
     * @var integer
     *
     * @ORM\Column(name="equipe_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $equipeId;

    /**
     * @return string
     */
    public function getEquipeNom(): string {
        return $this->equipeNom;
    }

    /**
     * @return int
     */
    public function getEquipeId(): int {
        return $this->equipeId;
    }

    /**
     * @param string $equipeNom
     */
    public function setEquipeNom(string $equipeNom) {
        $this->equipeNom = $equipeNom;
    }

    /**
     * @param int $equipeId
     */
    public function setEquipeId(int $equipeId) {
        $this->equipeId = $equipeId;
    }



}

