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
    private $meetingDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idMeeting;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $week;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $groupName;

    /**
     * @ORM\ManyToOne(targetEntity=Competition::class, inversedBy="meetings")
     */
    private $competition;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="meeting")
     */
    private $games;

    /**
     * @ORM\OneToMany(targetEntity=Bet::class, mappedBy="meeting")
     */
    private $bets;

    /**
     * @ORM\ManyToOne(targetEntity=Round::class, inversedBy="meetings")
     */
    private $rounds;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->bets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeetingDate(): ?\DateTimeInterface
    {
        return $this->meetingDate;
    }

    public function setMeetingDate(\DateTimeInterface $meetingDate): self
    {
        $this->meetingDate = $meetingDate;

        return $this;
    }

    public function getIdMeeting(): ?string
    {
        return $this->idMeeting;
    }

    public function setIdMeeting(string $idMeeting): self
    {
        $this->idMeeting = $idMeeting;

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

    public function getRounds(): ?Round
    {
        return $this->rounds;
    }

    public function setRounds(?Round $rounds): self
    {
        $this->rounds = $rounds;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
