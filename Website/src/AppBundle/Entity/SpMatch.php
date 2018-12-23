<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpMatch
 *
 * @ORM\Table(name="sp_match", indexes={@ORM\Index(name="FK_sp_match_sport_id", columns={"sport_id"}), @ORM\Index(name="FK_sp_match_equipe_1_id", columns={"equipe_1_id"}), @ORM\Index(name="FK_sp_match_equipe_2_id", columns={"equipe_2_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpMatchRepository")
 */
class SpMatch {
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="match_date", type="datetime", nullable=true)
     */
    private $matchDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="match_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $matchId;

    /**
     * @var \AppBundle\Entity\Equipe
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipe_1_id", referencedColumnName="equipe_id")
     * })
     */
    private $equipe1;

    /**
     * @var \AppBundle\Entity\Equipe
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipe_2_id", referencedColumnName="equipe_id")
     * })
     */
    private $equipe2;

    /**
     * @var \AppBundle\Entity\Sport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sport_id", referencedColumnName="sport_id")
     * })
     */
    private $sport;

    /**
     * @return \DateTime
     */
    public function getMatchDate(): \DateTime {
        return $this->matchDate;
    }

    /**
     * @param \DateTime $matchDate
     */
    public function setMatchDate(\DateTime $matchDate) {
        $this->matchDate = $matchDate;
    }

    /**
     * @return int
     */
    public function getMatchId(): int {
        return $this->matchId;
    }

    /**
     * @param int $matchId
     */
    public function setMatchId(int $matchId) {
        $this->matchId = $matchId;
    }

    /**
     * @return Equipe
     */
    public function getEquipe1(): Equipe {
        return $this->equipe1;
    }

    /**
     * @param Equipe $equipe1
     */
    public function setEquipe1(Equipe $equipe1) {
        $this->equipe1 = $equipe1;
    }

    /**
     * @return Equipe
     */
    public function getEquipe2(): Equipe {
        return $this->equipe2;
    }

    /**
     * @param Equipe $equipe2
     */
    public function setEquipe2(Equipe $equipe2) {
        $this->equipe2 = $equipe2;
    }

    /**
     * @return Sport
     */
    public function getSport(): Sport {
        return $this->sport;
    }

    /**
     * @param Sport $sport
     */
    public function setSport(Sport $sport) {
        $this->sport = $sport;
    }

    public function __toString() {
        return (string)$this->matchId;
    }


}

