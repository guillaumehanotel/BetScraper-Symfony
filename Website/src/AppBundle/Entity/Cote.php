<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cote
 *
 * @ORM\Table(name="cote", indexes={@ORM\Index(name="FK_cote_match_id", columns={"match_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CoteRepository")
 */
class Cote {
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cote_date", type="datetime", nullable=true)
     */
    private $coteDate;

    /**
     * @var float
     *
     * @ORM\Column(name="cote_equipe1", type="float", precision=6, scale=2, nullable=true)
     */
    private $coteEquipe1;

    /**
     * @var float
     *
     * @ORM\Column(name="cote_equipe2", type="float", precision=6, scale=2, nullable=true)
     */
    private $coteEquipe2;

    /**
     * @var float
     *
     * @ORM\Column(name="cote_nul", type="float", precision=6, scale=2, nullable=true)
     */
    private $coteNul;

    /**
     * @var float
     *
     * @ORM\Column(name="cote_var_nul", type="float", precision=6, scale=2, nullable=true)
     */
    private $coteVarNul;

    /**
     * @var float
     *
     * @ORM\Column(name="cote_var_equipe1", type="float", precision=6, scale=2, nullable=true)
     */
    private $coteVarEquipe1;

    /**
     * @var float
     *
     * @ORM\Column(name="cote_var_equipe2", type="float", precision=6, scale=2, nullable=true)
     */
    private $coteVarEquipe2;

    /**
     * @var integer
     *
     * @ORM\Column(name="cote_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $coteId;

    /**
     * @var \AppBundle\Entity\SpMatch
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SpMatch")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="match_id", referencedColumnName="match_id")
     * })
     */
    private $match;

    /**
     * @return \DateTime
     */
    public function getCoteDate(): \DateTime {
        return $this->coteDate;
    }

    /**
     * @param \DateTime $coteDate
     */
    public function setCoteDate(\DateTime $coteDate) {
        $this->coteDate = $coteDate;
    }

    /**
     * @return float
     */
    public function getCoteEquipe1(): float {
        return $this->coteEquipe1;
    }

    /**
     * @param float $coteEquipe1
     */
    public function setCoteEquipe1(float $coteEquipe1) {
        $this->coteEquipe1 = $coteEquipe1;
    }

    /**
     * @return float
     */
    public function getCoteEquipe2(): float {
        return $this->coteEquipe2;
    }

    /**
     * @param float $coteEquipe2
     */
    public function setCoteEquipe2(float $coteEquipe2) {
        $this->coteEquipe2 = $coteEquipe2;
    }

    /**
     * @return float
     */
    public function getCoteNul(): float {
        return $this->coteNul;
    }

    /**
     * @param float $coteNul
     */
    public function setCoteNul(float $coteNul) {
        $this->coteNul = $coteNul;
    }

    /**
     * @return int
     */
    public function getCoteId(): int {
        return $this->coteId;
    }

    /**
     * @param int $coteId
     */
    public function setCoteId(int $coteId) {
        $this->coteId = $coteId;
    }

    /**
     * @return SpMatch
     */
    public function getMatch(): SpMatch {
        return $this->match;
    }

    /**
     * @param SpMatch $match
     */
    public function setMatch(SpMatch $match) {
        $this->match = $match;
    }


    /**
     * Set coteVarNul
     *
     * @param float $coteVarNul
     *
     * @return Cote
     */
    public function setCoteVarNul($coteVarNul) {
        $this->coteVarNul = $coteVarNul;

        return $this;
    }

    /**
     * Get coteVarNul
     *
     * @return float
     */
    public function getCoteVarNul() {
        return $this->coteVarNul;
    }

    /**
     * Set coteVarEquipe1
     *
     * @param float $coteVarEquipe1
     *
     * @return Cote
     */
    public function setCoteVarEquipe1($coteVarEquipe1) {
        $this->coteVarEquipe1 = $coteVarEquipe1;

        return $this;
    }

    /**
     * Get coteVarEquipe1
     *
     * @return float
     */
    public function getCoteVarEquipe1() {
        return $this->coteVarEquipe1;
    }

    /**
     * Set coteVarEquipe2
     *
     * @param float $coteVarEquipe2
     *
     * @return Cote
     */
    public function setCoteVarEquipe2($coteVarEquipe2) {
        $this->coteVarEquipe2 = $coteVarEquipe2;

        return $this;
    }

    /**
     * Get coteVarEquipe2
     *
     * @return float
     */
    public function getCoteVarEquipe2() {
        return $this->coteVarEquipe2;
    }
}
