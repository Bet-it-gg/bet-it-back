<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StatisticRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=StatisticRepository::class)
 */
class Statistic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
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
    private $inibitors;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $golds;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $turrets;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minions;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $wards;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $damagesChampions;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $damagesHeal;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="statistics")
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="statistics")
     */
    private $team;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $FirstBlood;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $FirstTower;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $FirstInhibitor;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $FirstBaron;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $FirstDragon;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $FirstRiftHerald;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $PentaKills;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $TotalDamageDealtToChampions;

    /**
     * @ORM\Column(type="float")
     */
    private $WardsPlaced;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $WardsKilled;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $fantasyPoints;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKills(): ?int
    {
        return $this->kills;
    }

    public function setKills(?int $kills): self
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

    public function getInibitors(): ?int
    {
        return $this->inibitors;
    }

    public function setInibitors(?int $inibitors): self
    {
        $this->inibitors = $inibitors;

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

    public function getTurrets(): ?int
    {
        return $this->turrets;
    }

    public function setTurrets(?int $turrets): self
    {
        $this->turrets = $turrets;

        return $this;
    }

    public function getMinions(): ?int
    {
        return $this->minions;
    }

    public function setMinions(?int $minions): self
    {
        $this->minions = $minions;

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

    public function getDamagesChampions(): ?int
    {
        return $this->damagesChampions;
    }

    public function setDamagesChampions(?int $damagesChampions): self
    {
        $this->damagesChampions = $damagesChampions;

        return $this;
    }

    public function getDamagesHeal(): ?int
    {
        return $this->damagesHeal;
    }

    public function setDamagesHeal(?int $damagesHeal): self
    {
        $this->damagesHeal = $damagesHeal;

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

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getFirstBlood(): ?bool
    {
        return $this->FirstBlood;
    }

    public function setFirstBlood(?bool $FirstBlood): self
    {
        $this->FirstBlood = $FirstBlood;

        return $this;
    }

    public function getFirstTower(): ?bool
    {
        return $this->FirstTower;
    }

    public function setFirstTower(?bool $FirstTower): self
    {
        $this->FirstTower = $FirstTower;

        return $this;
    }

    public function getFirstInhibitor(): ?bool
    {
        return $this->FirstInhibitor;
    }

    public function setFirstInhibitor(?bool $FirstInhibitor): self
    {
        $this->FirstInhibitor = $FirstInhibitor;

        return $this;
    }

    public function getFirstBaron(): ?bool
    {
        return $this->FirstBaron;
    }

    public function setFirstBaron(?bool $FirstBaron): self
    {
        $this->FirstBaron = $FirstBaron;

        return $this;
    }

    public function getFirstDragon(): ?bool
    {
        return $this->FirstDragon;
    }

    public function setFirstDragon(?bool $FirstDragon): self
    {
        $this->FirstDragon = $FirstDragon;

        return $this;
    }

    public function getFirstRiftHerald(): ?bool
    {
        return $this->FirstRiftHerald;
    }

    public function setFirstRiftHerald(?bool $FirstRiftHerald): self
    {
        $this->FirstRiftHerald = $FirstRiftHerald;

        return $this;
    }

    public function getPentaKills(): ?bool
    {
        return $this->PentaKills;
    }

    public function setPentaKills(?bool $PentaKills): self
    {
        $this->PentaKills = $PentaKills;

        return $this;
    }

    public function getTotalDamageDealtToChampions(): ?float
    {
        return $this->TotalDamageDealtToChampions;
    }

    public function setTotalDamageDealtToChampions(?float $TotalDamageDealtToChampions): self
    {
        $this->TotalDamageDealtToChampions = $TotalDamageDealtToChampions;

        return $this;
    }

    public function getWardsPlaced(): ?float
    {
        return $this->WardsPlaced;
    }

    public function setWardsPlaced(float $WardsPlaced): self
    {
        $this->WardsPlaced = $WardsPlaced;

        return $this;
    }

    public function getWardsKilled(): ?float
    {
        return $this->WardsKilled;
    }

    public function setWardsKilled(?float $WardsKilled): self
    {
        $this->WardsKilled = $WardsKilled;

        return $this;
    }

    public function getFantasyPoints(): ?float
    {
        return $this->fantasyPoints;
    }

    public function setFantasyPoints(?float $fantasyPoints): self
    {
        $this->fantasyPoints = $fantasyPoints;

        return $this;
    }
}
