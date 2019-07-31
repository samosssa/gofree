<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Un autre utilisateur s'est deja inscrit avec cette adresse email, merci de la modifier"
 * )
 */
class User implements UserInterface
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

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
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", mappedBy="users")
     */
    private $roles;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Mission", inversedBy="users")
     */
    private $user_mission;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="users")
     */
    private $user_skill;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(message="Veuillez donner une Url valide pour votre avatar")
     *
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10, minMessage="minimum 10 caractère")
     */
    private $introduction;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mission", mappedBy="author")
     */
    private $missions;
    public function getFullName(){

        return "{$this->firstName} {$this->lastName}";
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
            $this->slug = $slugify->slugify($this->firstName.''.$this->lastName);
        }
    }

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->user_mission = new ArrayCollection();
        $this->user_skill = new ArrayCollection();
        $this->missions = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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
        $roles[] = 'ROLE_USER';

        return $roles;
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->addUser($this);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
            $role->removeUser($this);
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
    public function getUserMission(): Collection
    {
        return $this->user_mission;
    }

    public function addUserMission(Mission $userMission): self
    {
        if (!$this->user_mission->contains($userMission)) {
            $this->user_mission[] = $userMission;
        }

        return $this;
    }

    public function removeUserMission(Mission $userMission): self
    {
        if ($this->user_mission->contains($userMission)) {
            $this->user_mission->removeElement($userMission);
        }

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getUserSkill(): Collection
    {
        return $this->user_skill;
    }

    public function addUserSkill(Skill $userSkill): self
    {
        if (!$this->user_skill->contains($userSkill)) {
            $this->user_skill[] = $userSkill;
        }

        return $this;
    }

    public function removeUserSkill(Skill $userSkill): self
    {
        if ($this->user_skill->contains($userSkill)) {
            $this->user_skill->removeElement($userSkill);
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
            $mission->setAuthor($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->contains($mission)) {
            $this->missions->removeElement($mission);
            // set the owning side to null (unless already changed)
            if ($mission->getAuthor() === $this) {
                $mission->setAuthor(null);
            }
        }

        return $this;
    }
}
