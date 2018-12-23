<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sport
 *
 * @ORM\Table(name="sport")
 * @ORM\Entity
 */
class Sport {
    /**
     * @var string
     *
     * @ORM\Column(name="sport_nom", type="string", length=100, nullable=true)
     */
    private $sportNom;

    /**
     * @var integer
     *
     * @ORM\Column(name="sport_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sportId;

    /**
     * @return string
     */
    public function getSportNom(): string {
        return $this->sportNom;
    }

    /**
     * @param string $sportNom
     */
    public function setSportNom(string $sportNom) {
        $this->sportNom = $sportNom;
    }

    /**
     * @return int
     */
    public function getSportId(): int {
        return $this->sportId;
    }

    /**
     * @param int $sportId
     */
    public function setSportId(int $sportId) {
        $this->sportId = $sportId;
    }



}

