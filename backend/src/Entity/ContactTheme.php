<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ContactThemeRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"ContactTheme:read"}},
 *     "denormalization_context"={"groups"={"ContactTheme:write"}}
 * })
 * @ORM\Entity(repositoryClass=ContactThemeRepository::class)
 */
class ContactTheme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"ContactTheme:read"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=ContactMessage::class, mappedBy="theme", cascade={"persist", "remove"})
     */
    private $messages;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"ContactTheme:read", "ContactTheme:write"})
     */
    private $subject;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"ContactTheme:read", "ContactTheme:write"})
     */
    private $enabled;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"ContactTheme:read", "ContactTheme:write"})
     */
    private $createdAt;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
