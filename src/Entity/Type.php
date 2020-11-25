<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 */
class Type
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Bet::class, mappedBy="type")
     */
    private $bets;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Cote::class, mappedBy="type")
     */
    private $cotes;

    public function __construct()
    {
        $this->bets = new ArrayCollection();
        $this->cotes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $bet->setType($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): self
    {
        if ($this->bets->removeElement($bet)) {
            // set the owning side to null (unless already changed)
            if ($bet->getType() === $this) {
                $bet->setType(null);
            }
        }

        return $this;
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
            $cote->setType($this);
        }

        return $this;
    }

    public function removeCote(Cote $cote): self
    {
        if ($this->cotes->removeElement($cote)) {
            // set the owning side to null (unless already changed)
            if ($cote->getType() === $this) {
                $cote->setType(null);
            }
        }

        return $this;
    }
}
