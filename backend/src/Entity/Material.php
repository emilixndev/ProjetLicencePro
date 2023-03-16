<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MaterialRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
    ],
    normalizationContext: [
        "groups"=>["read:materials"]
    ],
    paginationItemsPerPage: 30
)]
class Material
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read:reservation","read:materials"])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["read:materials"])]
    private ?bool $isAvailable = null;

    #[ORM\ManyToOne(inversedBy: 'materials')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read:materials"])]
    private ?string $BCnumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(["read:materials"])]
    private ?\DateTimeInterface $deleveryDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(["read:materials"])]
    private ?\DateTimeInterface $endOfGuarantyDate = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read:materials"])]
    private ?string $InventoryNumber = null;

    #[ORM\ManyToOne(inversedBy: 'materials')]
    #[Groups(["read:materials"])]
    private ?Supplier $supplier = null;

    #[ORM\ManyToMany(targetEntity: MaterialType::class, mappedBy: 'material')]
    #[Groups(["read:materials"])]
    private Collection $materialTypes;

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: Reservation::class)]
    #[Groups(["read:materials"])]
    private Collection $reservations;

    #[ORM\Column(length: 255)]
    #[Groups(["read:materials",'read:reservation'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["read:materials"])]
    private ?string $description = null;



    #[ORM\ManyToOne(inversedBy: 'materials')]
    #[Groups(["read:materials"])]
    private ?Brand $brand = null;

    #[ORM\OneToMany(mappedBy: 'Material', targetEntity: ImgMaterial::class, cascade: ['persist','remove'],orphanRemoval: true)]
    #[Groups(["read:materials"])]
    private Collection $imgMaterials;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["read:materials"])]
    private ?string $link = null;

    #[ORM\ManyToOne(inversedBy: 'Material')]
    private ?Budget $budget = null;

    public function __construct()
    {
        $this->materialTypes = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->brands = new ArrayCollection();
        $this->imgMaterials = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, ImgMaterial>
     */
    public function getImgMaterials(): Collection
    {
        return $this->imgMaterials;
    }

    public function addImgMaterial(ImgMaterial $imgMaterial): self
    {
        if (!$this->imgMaterials->contains($imgMaterial)) {
            $this->imgMaterials->add($imgMaterial);
            $imgMaterial->setMaterial($this);
        }

        return $this;
    }

    public function removeImgMaterial(ImgMaterial $imgMaterial): self
    {
        if ($this->imgMaterials->removeElement($imgMaterial)) {
            // set the owning side to null (unless already changed)
            if ($imgMaterial->getMaterial() === $this) {
                $imgMaterial->setMaterial(null);
            }
        }

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getBudget(): ?Budget
    {
        return $this->budget;
    }

    public function setBudget(?Budget $budget): self
    {
        $this->budget = $budget;

        return $this;
    }
    public function __toString(): string
    {
        return $this->name;
    }

    public function getExportedData(){
        return[
            'id'=>$this->id,
            'Nom'=>$this->name,
            'Description'=>$this->description,
            'Bc Number'=>$this->BCnumber,
            'Date de livraison'=>date_format($this->deleveryDate, 'Y-m-d'),
            'Date de fin de garantie'=>date_format($this->endOfGuarantyDate, 'Y-m-d'),
            'Numero inventaire'=>$this->InventoryNumber,
            'Marque'=>$this->brand->getName(),
            'Budget'=>$this->budget->getName(),
            'Fournisseur'=>$this->supplier->getName(),
            'Proprietaire'=>$this->user->getFirstName()." ".$this->user->getLastName(),
        ];
    }

}
