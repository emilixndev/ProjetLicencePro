<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialRepository::class)]
#[ApiResource]
class Material
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isAvailable = null;

    #[ORM\ManyToOne(inversedBy: 'materials')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $budget = null;

    #[ORM\Column(length: 255)]
    private ?string $BCnumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $deleveryDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endOfGuarantyDate = null;

    #[ORM\Column(length: 255)]
    private ?string $InventoryNumber = null;

    #[ORM\ManyToOne(inversedBy: 'materials')]
    private ?Supplier $supplier = null;

    #[ORM\ManyToMany(targetEntity: MaterialType::class, mappedBy: 'material')]
    private Collection $materialTypes;

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: Reservation::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->materialTypes = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBudget(): ?string
    {
        return $this->budget;
    }

    public function setBudget(string $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getBCnumber(): ?string
    {
        return $this->BCnumber;
    }

    public function setBCnumber(string $BCnumber): self
    {
        $this->BCnumber = $BCnumber;

        return $this;
    }

    public function getDeleveryDate(): ?\DateTimeInterface
    {
        return $this->deleveryDate;
    }

    public function setDeleveryDate(\DateTimeInterface $deleveryDate): self
    {
        $this->deleveryDate = $deleveryDate;

        return $this;
    }

    public function getEndOfGuarantyDate(): ?\DateTimeInterface
    {
        return $this->endOfGuarantyDate;
    }

    public function setEndOfGuarantyDate(?\DateTimeInterface $endOfGuarantyDate): self
    {
        $this->endOfGuarantyDate = $endOfGuarantyDate;

        return $this;
    }

    public function getInventoryNumber(): ?string
    {
        return $this->InventoryNumber;
    }

    public function setInventoryNumber(string $InventoryNumber): self
    {
        $this->InventoryNumber = $InventoryNumber;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * @return Collection<int, MaterialType>
     */
    public function getMaterialTypes(): Collection
    {
        return $this->materialTypes;
    }

    public function addMaterialType(MaterialType $materialType): self
    {
        if (!$this->materialTypes->contains($materialType)) {
            $this->materialTypes->add($materialType);
            $materialType->addMaterial($this);
        }

        return $this;
    }

    public function removeMaterialType(MaterialType $materialType): self
    {
        if ($this->materialTypes->removeElement($materialType)) {
            $materialType->removeMaterial($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setMaterial($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getMaterial() === $this) {
                $reservation->setMaterial(null);
            }
        }

        return $this;
    }
}
