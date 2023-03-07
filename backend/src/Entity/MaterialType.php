<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\MaterialTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialTypeRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
    ]
)]
class MaterialType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Material::class, inversedBy: 'materialTypes')]
    private Collection $material;

    public function __construct()
    {
        $this->material = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Material>
     */
    public function getMaterial(): Collection
    {
        return $this->material;
    }

    public function addMaterial(Material $material): self
    {
        if (!$this->material->contains($material)) {
            $this->material->add($material);
        }

        return $this;
    }

    public function removeMaterial(Material $material): self
    {
        $this->material->removeElement($material);

        return $this;
    }
}
