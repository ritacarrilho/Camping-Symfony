<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert; // allows to make a constraint to a propriety
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Owners;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *  fields={"email"},
 *  message="This email exist already"
 * ) 
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     * Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Your password must have 8 or more characters")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Your password must be the same")
     */
    private $confirm_password;

    /**
     * @ORM\OneToOne(targetEntity=Owners::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $ownerId;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword(string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;

        return $this;
    }


    public function getOwnerId(): ?Owners
    {
        return $this->ownerId;
    }

    public function setOwnerId(Owners $ownerId): self
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getRoles()
    {
        return [$this->getRole()]; // returns an array with the role of the entity
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    // TODO: Implement eraseCredentials() method. 
    }

    public function getUsername()
    {
        return $this->getEmail;
    }

    public function __call($name, $arguments)
    {
    // TODO: Implement @method string getUserIdentifier() }
    }

    public function serialize()
    {
        return serialize([
            $this->getId(),
            $this->getEmail(),
            $this->getPassword()
        ]);
    }

    public function unserialize($data)
    { // recovers the serielized data in serialize()
        list($this->id, $this->email, $this->password) = 
            unserialize($data, ['allowed_classes' => false]);
    }

    public function getUserIdentifier() 
    {

    }

}
