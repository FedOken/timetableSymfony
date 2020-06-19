<?php

namespace App\Entity;

use App\Entity\Handler\TeacherHandler;
use App\Helper\MagicTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeacherRepository")
 *
 * @UniqueEntity(
 *     fields={"university", "name"},
 *     errorPath="name",
 *     message="entity_exist"
 * )
 *
 * @property int $id
 * @property string $name
 * @property string $name_full
 * @property TeacherPosition $position
 * @property University $university
 * @property Schedule[] $schedules
 * @property User[] $users
 *
 * @property TeacherHandler $handler
 */
class Teacher
{
    use MagicTrait;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name_full;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TeacherPosition", inversedBy="teachers")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Schedule", mappedBy="teacher")
     */
    private $schedules;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\University", inversedBy="teachers")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $university;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="teacher")
     */
    private $users;

    public $handler;

    public function __construct()
    {
        $this->schedules = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function setTest(int $i)
    {
        $this->test = $i;
        return $this;
    }

    public function __toString(){
        return $this->name;
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

    public function getPosition(): ?TeacherPosition
    {
        return $this->position;
    }

    public function setPosition(?TeacherPosition $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Schedule[]
     */
    public function getSchedules(): array
    {
        return $this->schedules->getValues();
    }

    public function addSchedule(Schedule $schedule): self
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules[] = $schedule;
            $schedule->setTeacher($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): self
    {
        if ($this->schedules->contains($schedule)) {
            $this->schedules->removeElement($schedule);
            // set the owning side to null (unless already changed)
            if ($schedule->getTeacher() === $this) {
                $schedule->setTeacher(null);
            }
        }

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
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users->getValues();
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setTeacher($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getTeacher() === $this) {
                $user->setTeacher(null);
            }
        }

        return $this;
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_full' => $this->name_full,
            'position' => $this->position ? $this->position->serialize() : null,
        ];
    }
}
