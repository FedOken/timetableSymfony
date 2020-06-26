<?php

namespace App\Entity;

use App\Entity\Handler\PartyHandler;
use App\Helper\MagicTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartyRepository")
 *
 * @UniqueEntity(
 *     fields={"name", "faculty"},
 *     errorPath="name",
 *     message="entity_exist"
 * )
 *
 * @property int $id
 * @property string $name
 * @property Faculty $faculty
 * @property Course $course
 * @property Schedule[] $schedules
 * @property User[] $users
 *
 * @property PartyHandler $handler
 */
class Party
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Faculty", inversedBy="parties")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $faculty;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Course", inversedBy="parties")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Schedule", mappedBy="party")
     */
    private $schedules;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="party")
     */
    private $users;

    public $handler;

    public function __construct()
    {
        $this->schedules = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getFaculty(): ?Faculty
    {
        return $this->faculty;
    }

    public function setFaculty(?Faculty $faculty): self
    {
        $this->faculty = $faculty;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

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
            $schedule->setParty($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): self
    {
        if ($this->schedules->contains($schedule)) {
            $this->schedules->removeElement($schedule);
            // set the owning side to null (unless already changed)
            if ($schedule->getParty() === $this) {
                $schedule->setParty(null);
            }
        }

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
            $user->setParty($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getParty() === $this) {
                $user->setParty(null);
            }
        }

        return $this;
    }

    /**
     * Serialize
     * @return array
     */
    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'faculty' => $this->faculty ? $this->faculty->serialize() : null,
            'course' => $this->course ? $this->course->serialize() : null,
        ];
    }
}
