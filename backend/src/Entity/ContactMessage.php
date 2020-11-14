<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\DBAL\Types\ContactMessageDevice;
use App\DBAL\Types\ContactMessageStatus;
use App\DBAL\Types\ContactMessageType;
use App\Filter\SearchFilter;
use App\Repository\ContactMessageRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"ContactMessage:read", "ContactTheme:read"}},
 *     "denormalization_context"={"groups"={"ContactMessage:write"}}
 * })
 * @ORM\Entity(repositoryClass=ContactMessageRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class ContactMessage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"ContactMessage:read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ContactTheme::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"ContactMessage:read", "ContactTheme:read"})
     */
    private $theme;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Groups({"ContactMessage:read", "ContactMessage:write"})
     * @ApiFilter(SearchFilter::class)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Groups({"ContactMessage:read", "ContactMessage:write"})
     * @ApiFilter(SearchFilter::class)
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Groups({"ContactMessage:read", "ContactMessage:write"})
     */
    private $content;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"ContactMessage:read", "ContactMessage:write"})
     */
    private $type;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"ContactMessage:read", "ContactMessage:write"})
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"ContactMessage:read", "ContactMessage:write"})
     */
    private $ip;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"ContactMessage:read", "ContactMessage:write"})
     */
    private $language;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"ContactMessage:read", "ContactMessage:write"})
     */
    private $device;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"ContactMessage:read", "ContactMessage:write"})
     */
    private $userAgent;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"ContactMessage:read", "ContactMessage:write"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"ContactMessage:read", "ContactMessage:write"})
     */
    private $deletedAt;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return ContactTheme|null
     */
    public function getTheme(): ?ContactTheme
    {
        return $this->theme;
    }

    /**
     * @param ContactTheme $theme
     *
     * @return $this
     */
    public function setTheme(ContactTheme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
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
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return $this
     */
    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
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
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     *
     * @return $this
     */
    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param string|null $language
     *
     * @return $this
     */
    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDevice(): ?int
    {
        return $this->device;
    }

    /**
     * @param int|null $device
     *
     * @return $this
     */
    public function setDevice(?int $device): self
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    /**
     * @param string|null $userAgent
     *
     * @return $this
     */
    public function setUserAgent(?string $userAgent): self
    {
        $this->userAgent = $userAgent;

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
     * @Groups({"ContactMessage:read"})
     */
    public function getTypeLabel(): ?string
    {
        return ContactMessageType::$choices[$this->type] ?? null;
    }

    /**
     * @Groups({"ContactMessage:read"})
     */
    public function getStatusLabel(): ?string
    {
        return ContactMessageStatus::$choices[$this->status] ?? null;
    }

    /**
     * @Groups({"ContactMessage:read"})
     */
    public function getDeviceLabel(): ?string
    {
        return ContactMessageDevice::$choices[$this->device] ?? null;
    }


    public function equalStatus($status): bool
    {
        $choices = ContactMessageStatus::$choices;

        return !empty($choices[$status]) && $this->status == $status;
    }
}
