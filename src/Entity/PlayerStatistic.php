<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PlayerStatisticRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PlayerStatisticRepository::class)
 */
class PlayerStatistic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $kills;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $assists;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $deaths;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $golds;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $wards;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="playerStatistics")
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity=Player::class, inversedBy="playerStatistics")
     */
    private $player;

    /**
     * @ORM\ManyToOne(targetEntity=Champion::class, inversedBy="playerStatistics")
     */
    private $champion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKills(): ?int
    {
        return $this->kills;
    }

    public function setKills(int $kills): self
    {
        $this->kills = $kills;

        return $this;
    }

    public function getAssists(): ?int
    {
        return $this->assists;
    }

    public function setAssists(?int $assists): self
    {
        $this->assists = $assists;

        return $this;
    }

    public function getDeaths(): ?int
    {
        return $this->deaths;
    }

    public function setDeaths(?int $deaths): self
    {
        $this->deaths = $deaths;

        return $this;
    }

    public function getGolds(): ?int
    {
        return $this->golds;
    }

    public function setGolds(?int $golds): self
    {
        $this->golds = $golds;

        return $this;
    }

    public function getWards(): ?int
    {
        return $this->wards;
    }

    public function setWards(?int $wards): self
    {
        $this->wards = $wards;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getChampion(): ?Champion
    {
        return $this->champion;
    }

    public function setChampion(?Champion $champion): self
    {
        $this->champion = $champion;

        return $this;
    }
}
