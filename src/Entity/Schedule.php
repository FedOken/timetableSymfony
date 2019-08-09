<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScheduleRepository")
 */
class Schedule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lesson_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Party", inversedBy="schedules")
     */
    private $party;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LessonType", inversedBy="schedules")
     */
    private $lesson_type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Teacher", inversedBy="schedules")
     */
    private $teacher;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Building", inversedBy="schedules")
     */
    private $building;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cabinet", inversedBy="schedules")
     */
    private $cabinet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Week", inversedBy="schedules")
     */
    private $week;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Day", inversedBy="schedules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $day;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLessonName(): ?string
    {
        return $this->lesson_name;
    }

    public function setLessonName(?string $lesson_name): self
    {
        $this->lesson_name = $lesson_name;

        return $this;
    }

    public function getParty(): ?Party
    {
        return $this->party;
    }

    public function setParty(?Party $party): self
    {
        $this->party = $party;

        return $this;
    }

    public function getLessonType(): ?LessonType
    {
        return $this->lesson_type;
    }

    public function setLessonType(?LessonType $lesson_type): self
    {
        $this->lesson_type = $lesson_type;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getBuilding(): ?Building
    {
        return $this->building;
    }

    public function setBuilding(?Building $building): self
    {
        $this->building = $building;

        return $this;
    }

    public function getCabinet(): ?Cabinet
    {
        return $this->cabinet;
    }

    public function setCabinet(?Cabinet $cabinet): self
    {
        $this->cabinet = $cabinet;

        return $this;
    }

    public function getWeek(): ?Week
    {
        return $this->week;
    }

    public function setWeek(?Week $week): self
    {
        $this->week = $week;

        return $this;
    }

    public function getDay(): ?Day
    {
        return $this->day;
    }

    public function setDay(?Day $day): self
    {
        $this->day = $day;

        return $this;
    }
}
