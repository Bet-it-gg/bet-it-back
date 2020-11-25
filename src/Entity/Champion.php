<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChampionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ChampionRepository::class)
 */
class Champion
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=PlayerStatistic::class, mappedBy="champion")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $playerStatistic->setChampion($this);
        }

        return $this;
    }

    public function removePlayerStatistic(PlayerStatistic $playerStatistic): self
    {
        if ($this->playerStatistics->removeElement($playerStatistic)) {
            // set the owning side to null (unless already changed)
            if ($playerStatistic->getChampion() === $this) {
                $playerStatistic->setChampion(null);
            }
        }

        return $this;
    }
}
