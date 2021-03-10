<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

//use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
//use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource( 
 *  collectionOperations={
 *      "post"={"security"="is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"}
 *  },
 *  itemOperations={
 *      "get"={"path"="users/{id}","security"="is_granted('ROLE_USER')"},
 *      "put"={"path"="users/{id}","security"="is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"},
 *      "delete"={"path"="users/{id}","security"="is_granted('ROLE_USER')"},
 *     },
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("user:read")
     */
    private string $id;

    /**
     * @ORM\Column(name="email", type="string", length=191, unique=true)
     * @Assert\Email
     * 
     * @Groups({"user:read", "user:write"})
     */
    private string $email;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @Groups("user:write")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="array")
     * @var array<string>
     * 
     * @Groups("user:read")
     */
    private array $roles;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"user:read", "user:write"})
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"user:read", "user:write"})
     */
    private string $lastName;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Groups({"user:read", "user:write"})
     */
    private $betties;

    /**
     * @ORM\Column(type="string", length=255)
     *
     *  @Groups({"user:read", "user:write"})
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     *
     *  @Groups({"user:read", "user:write"})
     */
    private $PhoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     *
     *  @Groups({"user:read", "user:write"})
     */
    private $sexe;

    /**
     * @ORM\Column(type="date", nullable=true)
     *
     *  @Groups({"user:read", "user:write"})
     */
    private $birthday;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getplainPassword()
    {
        return $this->plainPassword;
    }

    public function setplainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;

    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBetties(): ?int
    {
        return $this->betties;
    }

    public function setBetties(?int $betties): self
    {
        $this->betties = $betties;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(string $PhoneNumber): self
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }
}
