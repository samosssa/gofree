<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkillRepository")
 */
class Skill
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
     * @ORM\OneToMany(targetEntity="App\Entity\Mission", mappedBy="skills")
     */
    private $miss;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="user_skill")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UserSoc", mappedBy="usersoc_skill")
     */
    private $userSocs;

    public function __construct()
    {
        $this->miss = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->userSocs = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeMiss(Mission $miss): self
    {
        if ($this->miss->contains($miss)) {
            $this->miss->removeElement($miss);
            // set the owning side to null (unless already changed)
            if ($miss->getSkill() === $this) {
                $miss->setSkill(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addUserSkill($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeUserSkill($this);
        }

        return $this;
    }

    /**
     * @return Collection|UserSoc[]
     */
    public function getUserSocs(): Collection
    {
        return $this->userSocs;
    }

    public function addUserSoc(UserSoc $userSoc): self
    {
        if (!$this->userSocs->contains($userSoc)) {
            $this->userSocs[] = $userSoc;
            $userSoc->addUsersocSkill($this);
        }

        return $this;
    }

    public function removeUserSoc(UserSoc $userSoc): self
    {
        if ($this->userSocs->contains($userSoc)) {
            $this->userSocs->removeElement($userSoc);
            $userSoc->removeUsersocSkill($this);
        }

        return $this;
    }
}
