<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Repository\BooksRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BooksRepository::class)]
class Books
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Author $author = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Themes $themes = null;

    /**
     * @var Collection<int, Reservations>
     */
    #[ORM\OneToMany(targetEntity: Reservations::class, mappedBy: 'books')]
    private Collection $reservation;

    /**
     * @var Collection<int, Stocks>
     */
    #[ORM\OneToMany(targetEntity: Stocks::class, mappedBy: 'books')]
    private Collection $stock;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'books')]
    private Collection $avis;

    public function __construct()
    {
        $this->reservation = new ArrayCollection();
        $this->stock = new ArrayCollection();
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getThemes(): ?Themes
    {
        return $this->themes;
    }

    public function setThemes(?Themes $themes): static
    {
        $this->themes = $themes;

        return $this;
    }

    /**
     * @return Collection<int, Reservations>
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(Reservations $reservation): static
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation->add($reservation);
            $reservation->setBooks($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): static
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getBooks() === $this) {
                $reservation->setBooks(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Stocks>
     */
    public function getStock(): Collection
    {
        return $this->stock;
    }

    public function addStock(Stocks $stock): static
    {
        if (!$this->stock->contains($stock)) {
            $this->stock->add($stock);
            $stock->setBooks($this);
        }

        return $this;
    }

    public function removeStock(Stocks $stock): static
    {
        if ($this->stock->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getBooks() === $this) {
                $stock->setBooks(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setBooks($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getBooks() === $this) {
                $avi->setBooks(null);
            }
        }

        return $this;
    }
}
