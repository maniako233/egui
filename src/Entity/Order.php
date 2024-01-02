<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $statut = null;

    #[ORM\Column]
    private ?int $total = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Detailorder::class, orphanRemoval: true)]
    private Collection $detailorders;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->detailorders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

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
            $detailorder->setCommande($this);
        }

        return $this;
    }

    public function removeDetailorder(Detailorder $detailorder): static
    {
        if ($this->detailorders->removeElement($detailorder)) {
            // set the owning side to null (unless already changed)
            if ($detailorder->getCommande() === $this) {
                $detailorder->setCommande(null);
            }
        }

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
