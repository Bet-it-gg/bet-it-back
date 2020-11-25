<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompetitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CompetitionRepository::class)
 */
class Competition
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
     * @ORM\ManyToOne(targetEntity=Area::class, inversedBy="competitions")
     */
    private $area;

    /**
     * @ORM\OneToMany(targetEntity=Meeting::class, mappedBy="competition")
     */
    private $meetings;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $competitionId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $format;

    /**
     * @ORM\OneToMany(targetEntity=CompetitionDetails::class, mappedBy="competitions")
     */
    private $competitionDetails;

    /**
     * @ORM\OneToMany(targetEntity=CompetitionDetails::class, mappedBy="competition")
     */
    private $competitionsDetails;

    public function __construct()
    {
        $this->meetings = new ArrayCollection();
        $this->competitionsDetails = new ArrayCollection();
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

    public function getArea(): ?Area
    {
        return $this->area;
    }

    public function setArea(?Area $area): self
    {
        $this->area = $area;

        return $this;
    }

    /**
     * @return Collection|Meeting[]
     */
    public function getMeetings(): Collection
    {
        return $this->meetings;
    }

    public function addMeeting(Meeting $meeting): self
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings[] = $meeting;
            $meeting->setCompetition($this);
        }

        return $this;
    }

    public function removeMeeting(Meeting $meeting): self
    {
        if ($this->meetings->removeElement($meeting)) {
            // set the owning side to null (unless already changed)
            if ($meeting->getCompetition() === $this) {
                $meeting->setCompetition(null);
            }
        }

        return $this;
    }

    public function getCompetitionId(): ?string
    {
        return $this->competitionId;
    }

    public function setCompetitionId(string $competitionId): self
    {
        $this->competitionId = $competitionId;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return Collection|CompetitionDetails[]
     */
    public function getCompetitionsDetails(): Collection
    {
        return $this->competitionsDetails;
    }

    public function addCompetitionsDetail(CompetitionDetails $competitionsDetail): self
    {
        if (!$this->competitionsDetails->contains($competitionsDetail)) {
            $this->competitionsDetails[] = $competitionsDetail;
            $competitionsDetail->setCompetition($this);
        }

        return $this;
    }

    public function removeCompetitionsDetail(CompetitionDetails $competitionsDetail): self
    {
        if ($this->competitionsDetails->removeElement($competitionsDetail)) {
            // set the owning side to null (unless already changed)
            if ($competitionsDetail->getCompetition() === $this) {
                $competitionsDetail->setCompetition(null);
            }
        }

        return $this;
    }

}
