<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=BetRepository::class)
 */
class Bet
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
    private $BetDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Bet::class, inversedBy="betChild")
     */
    private $betParent;

    /**
     * @ORM\OneToMany(targetEntity=Bet::class, mappedBy="betParent")
     */
    private $betChild;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="bets")
     */
    private $type;

    public function __construct()
    {
        $this->betChild = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBetDate(): ?\DateTimeInterface
    {
        return $this->BetDate;
    }

    public function setBetDate(\DateTimeInterface $BetDate): self
    {
        $this->BetDate = $BetDate;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getBetParent(): ?self
    {
        return $this->betParent;
    }

    public function setBetParent(?self $betParent): self
    {
        $this->betParent = $betParent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getBetChild(): Collection
    {
        return $this->betChild;
    }

    public function addBetChild(self $betChild): self
    {
        if (!$this->betChild->contains($betChild)) {
            $this->betChild[] = $betChild;
            $betChild->setBetParent($this);
        }

        return $this;
    }

    public function removeBetChild(self $betChild): self
    {
        if ($this->betChild->removeElement($betChild)) {
            // set the owning side to null (unless already changed)
            if ($betChild->getBetParent() === $this) {
                $betChild->setBetParent(null);
            }
        }

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }
}
