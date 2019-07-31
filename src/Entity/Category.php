<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mission", mappedBy="category")
     */
    private $miss;

    public function __construct()
    {
        $this->miss = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getMiss(): Collection
    {
        return $this->miss;
    }

    public function addMiss(Mission $miss): self
    {
        if (!$this->miss->contains($miss)) {
            $this->miss[] = $miss;
            $miss->setCategory($this);
        }

        return $this;
    }

    public function removeMiss(Mission $miss): self
    {
        if ($this->miss->contains($miss)) {
            $this->miss->removeElement($miss);
            // set the owning side to null (unless already changed)
            if ($miss->getCategory() === $this) {
                $miss->setCategory(null);
            }
        }

        return $this;
    }
}
