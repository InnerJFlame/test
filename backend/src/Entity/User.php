<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity=Area::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $area;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank(groups={"SignUp"})
     * @Assert\Email(groups={"SignUp"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, nullable=true))
     * @Assert\NotBlank(groups={"ChangeEmail"})
     * @Assert\Email(groups={"ChangeEmail"})
     */
    private $newEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="smallint", options={"default":0})
     */
    private $status;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotBlank(groups={"SignUp"})
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=100)
     * @SecurityAssert\UserPassword(groups={"ChangePassword", "DeleteAccount"})
     */
    private $password;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"SignUp", "ChangePassword"})
     * @Assert\Length(groups={"SignUp", "ChangePassword"}, min=6)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(groups={"SignUp"})
     */
    private $token;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $age;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    private $hasPrivateMessage;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    private $hasPhotoRotation;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    private $hasReviews;

    /**
     * @ORM\Column(type="array")
     */
    private $availableDays;

    /**
     * @ORM\Column(type="array")
     */
    private $contactMethods;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $height;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $weight;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $eyeColor;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $hairColor;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $chestSize;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    private $isSmoking;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    private $hasTattoo;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    private $hasPiercings;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        $this->setToken((string)Uuid::v6());
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNewEmail(): ?string
    {
        return $this->newEmail;
    }

    /**
     * @param string|null $newEmail
     *
     * @return $this
     */
    public function setNewEmail(?string $newEmail): self
    {
        $this->newEmail = $newEmail;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return $this
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     *
     * @return $this
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     *
     * @return $this
     */
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     *
     * @return $this
     */
    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return $this
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     *
     * @return $this
     */
    public function setCountry(Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return City|null
     */
    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * @param City $city
     *
     * @return $this
     */
    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Area|null
     */
    public function getArea(): ?Area
    {
        return $this->area;
    }

    /**
     * @param Area $area
     *
     * @return $this
     */
    public function setArea(Area $area): self
    {
        $this->area = $area;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return bool
     */
    public function getHasPrivateMessage(): bool
    {
        return $this->hasPrivateMessage;
    }

    /**
     * @param bool $hasPrivateMessage
     *
     * @return $this
     */
    public function setHasPrivateMessage(bool $hasPrivateMessage): self
    {
        $this->hasPrivateMessage = $hasPrivateMessage;

        return $this;
    }

    /**
     * @return bool
     */
    public function getHasPhotoRotation(): bool
    {
        return boolval($this->hasPhotoRotation);
    }

    /**
     * @param bool $hasPhotoRotation
     *
     * @return $this
     */
    public function setHasPhotoRotation(bool $hasPhotoRotation): self
    {
        $this->hasPhotoRotation = $hasPhotoRotation;

        return $this;
    }

    /**
     * @return bool
     */
    public function getHasReviews(): bool
    {
        return boolval($this->hasReviews);
    }

    /**
     * @param bool $hasReviews
     *
     * @return $this
     */
    public function setHasReviews(bool $hasReviews): self
    {
        $this->hasReviews = $hasReviews;

        return $this;
    }

    /**
     * @return array
     */
    public function getAvailableDays(): array
    {
        return $this->availableDays ? $this->availableDays : [];
    }

    /**
     * @param array $availableDays
     *
     * @return $this
     */
    public function setAvailableDays(array $availableDays): self
    {
        $this->availableDays = $availableDays;

        return $this;
    }

    /**
     * @return array
     */
    public function getContactMethods(): array
    {
        return $this->contactMethods ? $this->contactMethods : [];
    }

    /**
     * @param array $contactMethods
     *
     * @return $this
     */
    public function setContactMethods(array $contactMethods): self
    {
        $this->contactMethods = $contactMethods;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return $this
     */
    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     *
     * @return $this
     */
    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return string
     */
    public function getEyeColor(): string
    {
        return $this->eyeColor;
    }

    /**
     * @param string $eyeColor
     *
     * @return $this
     */
    public function setEyeColor(string $eyeColor): self
    {
        $this->eyeColor = $eyeColor;

        return $this;
    }

    /**
     * @return string
     */
    public function getHairColor(): string
    {
        return $this->hairColor;
    }

    /**
     * @param string $hairColor
     *
     * @return $this
     */
    public function setHairColor(string $hairColor): self
    {
        $this->hairColor = $hairColor;

        return $this;
    }

    /**
     * @return string
     */
    public function getChestSize(): string
    {
        return $this->chestSize;
    }

    /**
     * @param string $chestSize
     *
     * @return $this
     */
    public function setChestSize(string $chestSize): self
    {
        $this->chestSize = $chestSize;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsSmoking(): bool
    {
        return boolval($this->isSmoking);
    }

    /**
     * @param $isSmoking
     *
     * @return $this
     */
    public function setIsSmoking($isSmoking): self
    {
        $this->isSmoking = $isSmoking;

        return $this;
    }

    /**
     * @return bool
     */
    public function getHasTattoo(): bool
    {
        return boolval($this->hasTattoo);
    }

    /**
     * @param bool $hasTattoo
     *
     * @return $this
     */
    public function setHasTattoo(bool $hasTattoo): self
    {
        $this->hasTattoo = $hasTattoo;

        return $this;
    }

    /**
     * @return bool
     */
    public function getHasPiercings(): bool
    {
        return boolval($this->hasPiercings);
    }

    /**
     * @param bool $hasPiercings
     *
     * @return $this
     */
    public function setHasPiercings(bool $hasPiercings): self
    {
        $this->hasPiercings = $hasPiercings;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    /**
     * @param DateTimeInterface $deletedAt
     *
     * @return $this
     */
    public function setDeletedAt(DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {

    }
}
