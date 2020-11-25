<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
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
    private $teamId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imgUrl;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shortName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $website;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity=Area::class, inversedBy="teams")
     */
    private $area;

    /**
     * @ORM\OneToMany(targetEntity=Player::class, mappedBy="team")
     */
    private $players;

    /**
     * @ORM\OneToMany(targetEntity=CompetitionDetails::class, mappedBy="winer")
     */
    private $competitionWon;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="teamOne")
     */
    private $gamesAsTeamOne;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="teamTwo")
     */
    private $gamesAsTeamTwo;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="winner")
     */
    private $wonGames;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="firstBlood")
     */
    private $firstBloodGames;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="firstTower")
     */
    private $forstTowerGames;

    /**
     * @ORM\OneToMany(targetEntity=Statistic::class, mappedBy="team")
     */
    private $statistics;

    /**
     * @ORM\OneToMany(targetEntity=CompetitionDetails::class, mappedBy="winner")
     */
    private $competitionDetails;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->competitionWon = new ArrayCollection();
        $this->gamesAsTeamOne = new ArrayCollection();
        $this->gamesAsTeamTwo = new ArrayCollection();
        $this->wonGames = new ArrayCollection();
        $this->firstBloodGames = new ArrayCollection();
        $this->forstTowerGames = new ArrayCollection();
        $this->statistics = new ArrayCollection();
        $this->competitionDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamId(): ?string
    {
        return $this->teamId;
    }

    public function setTeamId(string $teamId): self
    {
        $this->teamId = $teamId;

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

    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(string $imgUrl): self
    {
        $this->imgUrl = $imgUrl;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

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
     * @return Collection|Player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setTeam($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getTeam() === $this) {
                $player->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompetitionDetails[]
     */
    public function getCompetitionWon(): Collection
    {
        return $this->competitionWon;
    }

    public function addCompetitionWon(CompetitionDetails $competitionWon): self
    {
        if (!$this->competitionWon->contains($competitionWon)) {
            $this->competitionWon[] = $competitionWon;
            $competitionWon->setWiner($this);
        }

        return $this;
    }

    public function removeCompetitionWon(CompetitionDetails $competitionWon): self
    {
        if ($this->competitionWon->removeElement($competitionWon)) {
            // set the owning side to null (unless already changed)
            if ($competitionWon->getWiner() === $this) {
                $competitionWon->setWiner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGamesAsTeamOne(): Collection
    {
        return $this->gamesAsTeamOne;
    }

    public function addGamesAsTeamOne(Game $gamesAsTeamOne): self
    {
        if (!$this->gamesAsTeamOne->contains($gamesAsTeamOne)) {
            $this->gamesAsTeamOne[] = $gamesAsTeamOne;
            $gamesAsTeamOne->setTeamOne($this);
        }

        return $this;
    }

    public function removeGamesAsTeamOne(Game $gamesAsTeamOne): self
    {
        if ($this->gamesAsTeamOne->removeElement($gamesAsTeamOne)) {
            // set the owning side to null (unless already changed)
            if ($gamesAsTeamOne->getTeamOne() === $this) {
                $gamesAsTeamOne->setTeamOne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGamesAsTeamTwo(): Collection
    {
        return $this->gamesAsTeamTwo;
    }

    public function addGamesAsTeamTwo(Game $gamesAsTeamTwo): self
    {
        if (!$this->gamesAsTeamTwo->contains($gamesAsTeamTwo)) {
            $this->gamesAsTeamTwo[] = $gamesAsTeamTwo;
            $gamesAsTeamTwo->setTeamTwo($this);
        }

        return $this;
    }

    public function removeGamesAsTeamTwo(Game $gamesAsTeamTwo): self
    {
        if ($this->gamesAsTeamTwo->removeElement($gamesAsTeamTwo)) {
            // set the owning side to null (unless already changed)
            if ($gamesAsTeamTwo->getTeamTwo() === $this) {
                $gamesAsTeamTwo->setTeamTwo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getWonGames(): Collection
    {
        return $this->wonGames;
    }

    public function addWonGame(Game $wonGame): self
    {
        if (!$this->wonGames->contains($wonGame)) {
            $this->wonGames[] = $wonGame;
            $wonGame->setWinner($this);
        }

        return $this;
    }

    public function removeWonGame(Game $wonGame): self
    {
        if ($this->wonGames->removeElement($wonGame)) {
            // set the owning side to null (unless already changed)
            if ($wonGame->getWinner() === $this) {
                $wonGame->setWinner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getFirstBloodGames(): Collection
    {
        return $this->firstBloodGames;
    }

    public function addFirstBloodGame(Game $firstBloodGame): self
    {
        if (!$this->firstBloodGames->contains($firstBloodGame)) {
            $this->firstBloodGames[] = $firstBloodGame;
            $firstBloodGame->setFirstBlood($this);
        }

        return $this;
    }

    public function removeFirstBloodGame(Game $firstBloodGame): self
    {
        if ($this->firstBloodGames->removeElement($firstBloodGame)) {
            // set the owning side to null (unless already changed)
            if ($firstBloodGame->getFirstBlood() === $this) {
                $firstBloodGame->setFirstBlood(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getForstTowerGames(): Collection
    {
        return $this->forstTowerGames;
    }

    public function addForstTowerGame(Game $forstTowerGame): self
    {
        if (!$this->forstTowerGames->contains($forstTowerGame)) {
            $this->forstTowerGames[] = $forstTowerGame;
            $forstTowerGame->setFirstTower($this);
        }

        return $this;
    }

    public function removeForstTowerGame(Game $forstTowerGame): self
    {
        if ($this->forstTowerGames->removeElement($forstTowerGame)) {
            // set the owning side to null (unless already changed)
            if ($forstTowerGame->getFirstTower() === $this) {
                $forstTowerGame->setFirstTower(null);
            }
        }

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
            $statistic->setTeam($this);
        }

        return $this;
    }

    public function removeStatistic(Statistic $statistic): self
    {
        if ($this->statistics->removeElement($statistic)) {
            // set the owning side to null (unless already changed)
            if ($statistic->getTeam() === $this) {
                $statistic->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompetitionDetails[]
     */
    public function getCompetitionDetails(): Collection
    {
        return $this->competitionDetails;
    }

    public function addCompetitionDetail(CompetitionDetails $competitionDetail): self
    {
        if (!$this->competitionDetails->contains($competitionDetail)) {
            $this->competitionDetails[] = $competitionDetail;
            $competitionDetail->setWinner($this);
        }

        return $this;
    }

    public function removeCompetitionDetail(CompetitionDetails $competitionDetail): self
    {
        if ($this->competitionDetails->removeElement($competitionDetail)) {
            // set the owning side to null (unless already changed)
            if ($competitionDetail->getWinner() === $this) {
                $competitionDetail->setWinner(null);
            }
        }

        return $this;
    }
}
