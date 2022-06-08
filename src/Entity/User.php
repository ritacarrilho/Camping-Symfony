<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert; // allows to make a constraint to a propriety
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Owners;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
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
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

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
