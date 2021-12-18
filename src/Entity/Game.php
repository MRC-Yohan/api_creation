<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Casino;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
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
    private $nb_of_player;

    /**
     * @ORM\OneToMany(targetEntity=Monitoring::class, mappedBy="game")
     */
    private $games;

    /**
     * @ORM\ManyToOne(targetEntity=casino::class)
     */
    private $casino;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbOfPlayer(): ?int
    {
        return $this->nb_of_player;
    }

    public function setNbOfPlayer(?int $nb_of_player): self
    {
        $this->nb_of_player = $nb_of_player;

        return $this;
    }

    /**
     * @return Collection|Monitoring[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Monitoring $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setGame($this);
        }

        return $this;
    }

    public function removeGame(Monitoring $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getGame() === $this) {
                $game->setGame(null);
            }
        }

        return $this;
    }

    public function getCasino(): ?casino
    {
        return $this->casino;
    }

    public function setCasino(?casino $casino): self
    {
        $this->casino = $casino;

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
}
