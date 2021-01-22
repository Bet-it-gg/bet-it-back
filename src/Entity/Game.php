<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="gamesAsTeamOne")
     */
    private $teamOne;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="gamesAsTeamTwo")
     */
    private $teamTwo;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="wonGames")
     */
    private $winner;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="firstBloodGames")
     */
    private $firstBlood;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="forstTowerGames")
     */
    private $firstTower;

    /**
     * @ORM\ManyToOne(targetEntity=Meeting::class, inversedBy="games")
     */
    private $meeting;

    /**
     * @ORM\OneToMany(targetEntity=Statistic::class, mappedBy="game")
     */
    private $statistics;

    /**
     * @ORM\OneToMany(targetEntity=PlayerStatistic::class, mappedBy="game")
     */
    private $playerStatistics;

    /**
     * @ORM\OneToMany(targetEntity=Cote::class, mappedBy="game")
     */
    private $cotes;

    /**
     * @ORM\OneToMany(targetEntity=Bet::class, mappedBy="game")
     */
    private $bets;

    /**
     * @ORM\Column(type="integer")
     */
    private $gameNumber;

    public function __construct()
    {
        $this->statistics = new ArrayCollection();
        $this->playerStatistics = new ArrayCollection();
        $this->cotes = new ArrayCollection();
        $this->bets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamOne(): ?Team
    {
        return $this->teamOne;
    }

    public function setTeamOne(?Team $teamOne): self
    {
        $this->teamOne = $teamOne;

        return $this;
    }

    public function getTeamTwo(): ?Team
    {
        return $this->teamTwo;
    }

    public function setTeamTwo(?Team $teamTwo): self
    {
        $this->teamTwo = $teamTwo;

        return $this;
    }

    public function getWinner(): ?Team
    {
        return $this->winner;
    }

    public function setWinner(?Team $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    public function getFirstBlood(): ?Team
    {
        return $this->firstBlood;
    }

    public function setFirstBlood(?Team $firstBlood): self
    {
        $this->firstBlood = $firstBlood;

        return $this;
    }

    public function getFirstTower(): ?Team
    {
        return $this->firstTower;
    }

    public function setFirstTower(?Team $firstTower): self
    {
        $this->firstTower = $firstTower;

        return $this;
    }

    public function getMeeting(): ?Meeting
    {
        return $this->meeting;
    }

    public function setMeeting(?Meeting $meeting): self
    {
        $this->meeting = $meeting;

        return $this;
    }

    /**
     * @return Collection|Statistic[]
     */
    public function getStatistics(): Collection
    {
        return $this->statistics;
    }

    public function addStatistic(Statistic $statistic): self
    {
        if (!$this->statistics->contains($statistic)) {
            $this->statistics[] = $statistic;
            $statistic->setGame($this);
        }

        return $this;
    }

    public function removeStatistic(Statistic $statistic): self
    {
        if ($this->statistics->removeElement($statistic)) {
            // set the owning side to null (unless already changed)
            if ($statistic->getGame() === $this) {
                $statistic->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PlayerStatistic[]
     */
    public function getPlayerStatistics(): Collection
    {
        return $this->playerStatistics;
    }

    public function addPlayerStatistic(PlayerStatistic $playerStatistic): self
    {
        if (!$this->playerStatistics->contains($playerStatistic)) {
            $this->playerStatistics[] = $playerStatistic;
            $playerStatistic->setGame($this);
        }

        return $this;
    }

    public function removePlayerStatistic(PlayerStatistic $playerStatistic): self
    {
        if ($this->playerStatistics->removeElement($playerStatistic)) {
            // set the owning side to null (unless already changed)
            if ($playerStatistic->getGame() === $this) {
                $playerStatistic->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cote[]
     */
    public function getCotes(): Collection
    {
        return $this->cotes;
    }

    public function addCote(Cote $cote): self
    {
        if (!$this->cotes->contains($cote)) {
            $this->cotes[] = $cote;
            $cote->setGame($this);
        }

        return $this;
    }

    public function removeCote(Cote $cote): self
    {
        if ($this->cotes->removeElement($cote)) {
            // set the owning side to null (unless already changed)
            if ($cote->getGame() === $this) {
                $cote->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bet[]
     */
    public function getBets(): Collection
    {
        return $this->bets;
    }

    public function addBet(Bet $bet): self
    {
        if (!$this->bets->contains($bet)) {
            $this->bets[] = $bet;
            $bet->setGame($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): self
    {
        if ($this->bets->removeElement($bet)) {
            // set the owning side to null (unless already changed)
            if ($bet->getGame() === $this) {
                $bet->setGame(null);
            }
        }

        return $this;
    }

    public function getGameNumber(): ?int
    {
        return $this->gameNumber;
    }

    public function setGameNumber(int $gameNumber): self
    {
        $this->gameNumber = $gameNumber;

        return $this;
    }
}
