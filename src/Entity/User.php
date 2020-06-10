<?php

namespace App\Entity;

use App\Entity\Base\UserBase;
use App\Entity\Handler\UserHandler;
use App\Helper\MagicTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Json;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 *
 * @property int $id
 * @property string $email
 * @property array $roles
 * @property string $password
 * @property Role $role_label
 * @property string $access_code
 * @property bool $enable
 * @property string $reset_password_code
 * @property string $check_email_code
 * @property int $status
 * @property string $phone
 * @property string $first_name
 * @property string $last_name
 * @property string $code
 *
 * @property University $university
 * @property Faculty $faculty
 * @property Party $party
 * @property Teacher $teacher
 *
 * @property UserHandler $handler
 */
class User extends UserBase implements UserInterface
{
    use MagicTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $role_label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $access_code;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enable;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reset_password_code;

    /**
     * @ORM\Column(type="string", length=255,  nullable=true)
     */
    private $check_email_code;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $last_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\University", inversedBy="users")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $university;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Faculty", inversedBy="users")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $faculty;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Party", inversedBy="users")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $party;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Teacher", inversedBy="users")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $teacher;

    public $handler;

    /**
     * Set what user see in form by relation
     * @return mixed
     */
    public function __toString() {
        return $this->email;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        //Get current role or set default ROLE_USER
        $roles = $this->roles;

        if(!$roles) {
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    public function getRoleLabel(): ?Role
    {
        return $this->role_label;
    }

    public function setRoleLabel(?Role $role_label): self
    {
        $this->role_label = $role_label;

        return $this;
    }

    public function getAccessCode(): ?string
    {
        return $this->access_code;
    }

    public function setAccessCode(string $access_code): self
    {
        $this->access_code = $access_code;

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

    public function getFaculty(): ?Faculty
    {
        return $this->faculty;
    }

    public function setFaculty(?Faculty $faculty): self
    {
        $this->faculty = $faculty;

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

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getResetPasswordCode(): ?string
    {
        return $this->reset_password_code;
    }

    public function setResetPasswordCode(string $reset_password_code): self
    {
        $this->reset_password_code = $reset_password_code;

        return $this;
    }

    public function getCheckEmailCode(): ?string
    {
        return $this->check_email_code;
    }

    public function setCheckEmailCode(string $check_email_code): self
    {
        $this->check_email_code = $check_email_code;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;
        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }



    /* ADDITIONAL FUNCTIONS */

}
