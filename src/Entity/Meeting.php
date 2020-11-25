<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MeetingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=MeetingRepository::class)
 */
class Meeting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $matchDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idMatch;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $week;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $groupName;

    /**
     * @ORM\ManyToOne(targetEntity=Competition::class, inversedBy="meetings")
     */
    private $competition;

    /**
     * @ORM\ManyToOne(targetEntity=CompetitionDetails::class, inversedBy="meetings")
     */
    private $competitionDetails;

    /**
     * @ORM\ManyToOne(targetEntity=TypeMeeting::class, inversedBy="meetings")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="meeting")
     */
    private $games;

    /**
     * @ORM\OneToMany(targetEntity=Bet::class, mappedBy="meeting")
     */
    private $bets;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->bets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatchDate(): ?\DateTimeInterface
    {
        return $this->matchDate;
    }

    public function setMatchDate(\DateTimeInterface $matchDate): self
    {
        $this->matchDate = $matchDate;

        return $this;
    }

    public function getIdMatch(): ?string
    {
        return $this->idMatch;
    }

    public function setIdMatch(string $idMatch): self
    {
        $this->idMatch = $idMatch;

        return $this;
    }

    public function getWeek(): ?string
    {
        return $this->week;
    }

    public function setWeek(string $week): self
    {
        $this->week = $week;

        return $this;
    }

    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    public function setGroupName(string $groupName): self
    {
        $this->groupName = $groupName;

        return $this;
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): self
    {
        $this->competition = $competition;

        return $this;
    }

    public function getCompetitionDetails(): ?CompetitionDetails
    {
        return $this->competitionDetails;
    }

    public function setCompetitionDetails(?CompetitionDetails $competitionDetails): self
    {
        $this->competitionDetails = $competitionDetails;

        return $this;
    }

    public function getType(): ?TypeMeeting
    {
        return $this->type;
    }

    public function setType(?TypeMeeting $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setMeeting($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getMeeting() === $this) {
                $game->setMeeting(null);
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
            $bet->setMeeting($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): self
    {
        if ($this->bets->removeElement($bet)) {
            // set the owning side to null (unless already changed)
            if ($bet->getMeeting() === $this) {
                $bet->setMeeting(null);
            }
        }

        return $this;
    }
}
