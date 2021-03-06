<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MissionRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *     fields={"title"},
 *     message="Une autre annonce possède deja ce titre"
 *     )
 */

class Mission
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
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date(message="Attention, la date d'arrivée doit etre au bon format!")
     */
    public $start_day;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date(message="Attention, la date d'arrivée doit etre au bon format!")
     */
    public $end_date;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="miss")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Skill",
     *      inversedBy="miss")
     */
    private $skills;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="user_mission")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $coverImage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Apply", mappedBy="mission")
     */
    private $applies;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UserSoc", mappedBy="usersoc_mission")
     */
    private $userSocs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserSoc", inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userSoc;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;




    public function __construct()
    {

        $this->users = new ArrayCollection();
        $this->startDate = new ArrayCollection();
        $this->applies = new ArrayCollection();
        $this->userSocs = new ArrayCollection();
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
            $this->slug = $slugify->slugify($this->title);
        }
    }

    /**
     * Callback appelé à chaque fois qu'on créé une candidature
     *
     * @ORM\PrePersist
     *
     * @return void
     *
     */
    public function prePersist()
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }

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
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getStartDay(): ?\DateTimeInterface
    {
        return $this->start_day;
    }

    public function setStartDay(\DateTimeInterface $start_day): self
    {
        $this->start_day = $start_day;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
{
    return $this->category;
}

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
    public function getSkills(): ?Skill
    {
        return $this->skills;
    }

    public function setSkills(?Skill $skills): self
    {
        $this->skills = $skills;

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
            $user->addUserMission($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeUserMission($this);
        }

        return $this;
    }



    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

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
            $apply->setMission($this);
        }

        return $this;
    }

    public function removeApply(Apply $apply): self
    {
        if ($this->applies->contains($apply)) {
            $this->applies->removeElement($apply);
            // set the owning side to null (unless already changed)
            if ($apply->getMission() === $this) {
                $apply->setMission(null);
            }
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
            $userSoc->addUsersocMission($this);
        }

        return $this;
    }

    public function removeUserSoc(UserSoc $userSoc): self
    {
        if ($this->userSocs->contains($userSoc)) {
            $this->userSocs->removeElement($userSoc);
            $userSoc->removeUsersocMission($this);
        }

        return $this;
    }

    public function getUserSoc(): ?UserSoc
    {
        return $this->userSoc;
    }

    public function setUserSoc(?UserSoc $userSoc): self
    {
        $this->userSoc = $userSoc;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


}
