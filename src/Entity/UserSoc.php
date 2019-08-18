<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserSocRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Un autre utilisateur s'est deja inscrit avec cette adresse email, merci de la modifier"
 * )
 */
class UserSoc implements UserInterface
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
    private $name;

    /**
     * @ORM\Column(type="bigint")
     */
    private $tva;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;
    /**
     * @Assert\EqualTo(propertyPath="hash", message="Vous n'avez pas correctement confirmer votre mot de passe!")
     */
    public $passwordConfirm;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", inversedBy="userSocs")
     */
    private $roles;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Mission", inversedBy="userSocs")
     */
    private $usersoc_mission;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="userSocs")
     */
    private $usersoc_skill;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $introduction;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mission", mappedBy="userSoc")
     */
    private $missions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Apply", mappedBy="userSoc")
     */
    private $applies;

    public function getFullName(){

        return "{$this->name}";
    }


    /**
     * Permet d initialiser le slug
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     */

    public function initializeSlug(){
        if(empty($this->slug))  {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->name);
        }
    }


    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->usersoc_mission = new ArrayCollection();
        $this->usersoc_skill = new ArrayCollection();
        $this->missions = new ArrayCollection();
        $this->applies = new ArrayCollection();
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

    public function getTva(): ?int
    {
        return $this->tva;
    }

    public function setTva(int $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getRoles()
    {
        $roles = $this->roles->map(function ($role) {
            return $role->getTitle();
        })->toArray();
        $roles[] = 'ROLE_USERSOC';

        return $roles;
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }

    public function getPassword(){
        return $this->hash;
    }

    public function getSalt(){}
    function getUsername(){
        return $this->email;
    }

    public function eraseCredentials(){}

    /**
     * @return Collection|Mission[]
     */
    public function getUsersocMission(): Collection
    {
        return $this->usersoc_mission;
    }

    public function addUsersocMission(Mission $usersocMission): self
    {
        if (!$this->usersoc_mission->contains($usersocMission)) {
            $this->usersoc_mission[] = $usersocMission;
        }

        return $this;
    }

    public function removeUsersocMission(Mission $usersocMission): self
    {
        if ($this->usersoc_mission->contains($usersocMission)) {
            $this->usersoc_mission->removeElement($usersocMission);
        }

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getUsersocSkill(): Collection
    {
        return $this->usersoc_skill;
    }

    public function addUsersocSkill(Skill $usersocSkill): self
    {
        if (!$this->usersoc_skill->contains($usersocSkill)) {
            $this->usersoc_skill[] = $usersocSkill;
        }

        return $this;
    }

    public function removeUsersocSkill(Skill $usersocSkill): self
    {
        if ($this->usersoc_skill->contains($usersocSkill)) {
            $this->usersoc_skill->removeElement($usersocSkill);
        }

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions[] = $mission;
            $mission->setUserSoc($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->contains($mission)) {
            $this->missions->removeElement($mission);
            // set the owning side to null (unless already changed)
            if ($mission->getUserSoc() === $this) {
                $mission->setUserSoc(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Apply[]
     */
    public function getApplies(): Collection
    {
        return $this->applies;
    }

    public function addApply(Apply $apply): self
    {
        if (!$this->applies->contains($apply)) {
            $this->applies[] = $apply;
            $apply->setUserSoc($this);
        }

        return $this;
    }

    public function removeApply(Apply $apply): self
    {
        if ($this->applies->contains($apply)) {
            $this->applies->removeElement($apply);
            // set the owning side to null (unless already changed)
            if ($apply->getUserSoc() === $this) {
                $apply->setUserSoc(null);
            }
        }

        return $this;
    }
}
