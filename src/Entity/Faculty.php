<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FacultyRepository")
 *
 * @property int $id
 * @property string $name
 * @property string $name_full
 * @property bool $enable
 * @property University $university
 * @property ArrayCollection $parties
 * @property ArrayCollection $users
 */

class Faculty
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name_full;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\University", inversedBy="faculties")
     */
    private $university;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Party", mappedBy="faculty")
     */
    private $parties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="faculty")
     */
    private $users;

    public function __construct()
    {
        $this->parties = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function __toString(){
        return $this->name_full;
    }

    public function __get($propertyName)
    {
        return $this->$propertyName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNameFull(): ?string
    {
        return $this->name_full;
    }

    public function setNameFull(?string $name_full): self
    {
        $this->name_full = $name_full;

        return $this;
    }

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    public function getUniversity(): ?University
    {
        return $this->university;
    }

    public function setUniversity(?University $university): self
    {
        $this->university = $university;

        return $this;
    }

    /**
     * @return Collection|Party[]
     */
    public function getParties(): Collection
    {
        return $this->parties;
    }

    public function addParty(Party $party): self
    {
        if (!$this->parties->contains($party)) {
            $this->parties[] = $party;
            $party->setFaculty($this);
        }

        return $this;
    }

    public function removeParty(Party $party): self
    {
        if ($this->parties->contains($party)) {
            $this->parties->removeElement($party);
            // set the owning side to null (unless already changed)
            if ($party->getFaculty() === $this) {
                $party->setFaculty(null);
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
            $user->setFaculty($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getFaculty() === $this) {
                $user->setFaculty(null);
            }
        }

        return $this;
    }
}
