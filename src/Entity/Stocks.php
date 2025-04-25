<?php

namespace App\Entity;

use App\Repository\StocksRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StocksRepository::class)]
class Stocks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?int $quantity_reserved = null;

    #[ORM\Column]
    private ?int $quantity_available = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    private ?Languages $language = null;

    #[ORM\ManyToOne(inversedBy: 'stock')]
    private ?Books $books = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantityReserved(): ?int
    {
        return $this->quantity_reserved;
    }

    public function setQuantityReserved(int $quantity_reserved): static
    {
        $this->quantity_reserved = $quantity_reserved;

        return $this;
    }

    public function getQuantityAvailable(): ?int
    {
        return $this->quantity_available;
    }

    public function setQuantityAvailable(int $quantity_available): static
    {
        $this->quantity_available = $quantity_available;

        return $this;
    }

    public function getLanguage(): ?Languages
    {
        return $this->language;
    }

    public function setLanguage(?Languages $language): static
    {
        $this->language = $language;

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
}
