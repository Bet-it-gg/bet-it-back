<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $playerName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $playerId;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="players")
     */
    private $team;

    /**
     * @ORM\OneToMany(targetEntity=PlayerStatistic::class, mappedBy="player")
     */
    private $playerStatistics;

    public function __construct()
    {
        $this->playerStatistics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayerName(): ?string
    {
        return $this->playerName;
    }

    public function setPlayerName(string $playerName): self
    {
        $this->playerName = $playerName;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getPlayerId(): ?string
    {
        return $this->playerId;
    }

    public function setPlayerId(string $playerId): self
    {
        $this->playerId = $playerId;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

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
            $playerStatistic->setPlayer($this);
        }

        return $this;
    }

    public function removePlayerStatistic(PlayerStatistic $playerStatistic): self
    {
        if ($this->playerStatistics->removeElement($playerStatistic)) {
            // set the owning side to null (unless already changed)
            if ($playerStatistic->getPlayer() === $this) {
                $playerStatistic->setPlayer(null);
            }
        }

        return $this;
    }
}
