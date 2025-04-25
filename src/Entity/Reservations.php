<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Enum\ReservationStatus;
use App\Repository\ReservationsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(nullable: true, enumType: ReservationStatus::class)]
    private ?ReservationStatus $status = null;

    #[ORM\Column]
    private ?bool $handed_over = null;

    #[ORM\ManyToOne(inversedBy: 'reservation')]
    private ?Books $books = null;

    #[ORM\ManyToOne(inversedBy: 'reservation')]
    private ?User $user = null;

    public function __construct()
    {
        $this->usager = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getStatus(): ?ReservationStatus
    {
        return $this->status;
    }

    public function setStatus(?ReservationStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function isHandedOver(): ?bool
    {
        return $this->handed_over;
    }

    public function setHandedOver(bool $handed_over): static
    {
        $this->handed_over = $handed_over;

        return $this;
    }

    public function getBooks(): ?Books
    {
        return $this->books;
    }

    public function setBooks(?Books $books): static
    {
        $this->books = $books;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
