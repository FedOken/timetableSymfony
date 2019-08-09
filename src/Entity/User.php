<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Faculty", inversedBy="users")
     */
    private $access_faculties;

    public function __construct()
    {
        $this->access_faculties = new ArrayCollection();
    }

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

    public function getRole(): string
    {
        //Get current role or set default ROLE_USER
        $roles = $this->roles;

        if(!$roles) {
            $roles[] = 'ROLE_USER';
        }

        return $roles[0];
    }

    public function getRoleList()
    {
        return [
            'Admin'                 => 'ROLE_ADMIN' ,
            'User'                  => 'ROLE_USER',
            'University manager'    => 'ROLE_UNIVERSITY_MANAGER',
            'Faculty manager'       => 'ROLE_FACULTY_MANAGER',
            'Group manager'         => 'ROLE_GROUP_MANAGER',
        ];
    }

    public function getRoleLabel()
    {
        $roles = $this->getRoleList();
        $current_role_in_array = $this->getRoles()[0];

        foreach ($roles as $role_label => $role_key)
        {
            if($current_role_in_array == $role_key )
            {
                return $role_label;
            }
        }
        return 'Undefined';
    }


    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function setRole($role): self
    {
        $this->roles = [$role];

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

    /**
     * @return Collection|Faculty[]
     */
    public function getAccessFaculties(): Collection
    {
        return $this->access_faculties;
    }

    public function addAccessFaculty(Faculty $accessFaculty): self
    {
        if (!$this->access_faculties->contains($accessFaculty)) {
            $this->access_faculties[] = $accessFaculty;
        }

        return $this;
    }

    public function removeAccessFaculty(Faculty $accessFaculty): self
    {
        if ($this->access_faculties->contains($accessFaculty)) {
            $this->access_faculties->removeElement($accessFaculty);
        }

        return $this;
    }
}
