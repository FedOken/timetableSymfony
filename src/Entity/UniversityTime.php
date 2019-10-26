<?php

namespace App\Entity;

use App\Helper\MagicTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UniversityTimeRepository")
 *
 * @property int $id
 * @property string $name
 * @property DateTime $timeFrom
 * @property DateTime $timeTo
 * @property University[] $university
 */
class UniversityTime
{
    use MagicTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="time", nullable=false)
     */
    private $timeFrom;

    /**
     * @ORM\Column(type="time", nullable=false)
     */
    private $timeTo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\University", inversedBy="universityTimes")
     */
    private $university;

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

    public function setName(): self
    {
        $timeFrom = $this->getTimeFrom()->getTimestamp() + 10800;
        $timeTo = $this->getTimeTo()->getTimestamp() + 10800;
        $this->name = gmdate("H:i", $timeFrom).' - '.gmdate("H:i", $timeTo);

        return $this;
    }

    public function getTimeFrom(): ?\DateTimeInterface
    {
        return $this->timeFrom;
    }

    public function setTimeFrom(?\DateTimeInterface $timeFrom): self
    {
        $this->timeFrom = $timeFrom;

        return $this;
    }

    public function getTimeTo(): ?\DateTimeInterface
    {
        return $this->timeTo;
    }

    public function setTimeTo(?\DateTimeInterface $timeTo): self
    {
        $this->timeTo = $timeTo;

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
}
