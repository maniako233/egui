<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 25)]
    private ?string $image = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Coupe $coupe = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Supplier $supplier = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Detailorder::class, orphanRemoval: true)]
    private Collection $detailorders;

    public function __construct()
    {
        $this->detailorders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
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

    public function getCoupe(): ?Coupe
    {
        return $this->coupe;
    }

    public function setCoupe(?Coupe $coupe): static
    {
        $this->coupe = $coupe;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): static
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * @return Collection<int, Detailorder>
     */
    public function getDetailorders(): Collection
    {
        return $this->detailorders;
    }

    public function addDetailorder(Detailorder $detailorder): static
    {
        if (!$this->detailorders->contains($detailorder)) {
            $this->detailorders->add($detailorder);
            $detailorder->setProduct($this);
        }

        return $this;
    }

    public function removeDetailorder(Detailorder $detailorder): static
    {
        if ($this->detailorders->removeElement($detailorder)) {
            // set the owning side to null (unless already changed)
            if ($detailorder->getProduct() === $this) {
                $detailorder->setProduct(null);
            }
        }

        return $this;
    }
}
