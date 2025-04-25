<?php

namespace App\Entity;

use App\Repository\LanguagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguagesRepository::class)]
class Languages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Stocks>
     */
    #[ORM\OneToMany(targetEntity: Stocks::class, mappedBy: 'language')]
    private Collection $stocks;

    public function __construct()
    {
        $this->stocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Stocks>
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stocks $stock): static
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks->add($stock);
            $stock->setLanguage($this);
        }

        return $this;
    }

    public function removeStock(Stocks $stock): static
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getLanguage() === $this) {
                $stock->setLanguage(null);
            }
        }

        return $this;
    }
}
