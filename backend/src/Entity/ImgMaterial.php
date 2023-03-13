<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ImgMaterialRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ImgMaterialRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
    ],
    normalizationContext: [
        "groups"=>["read:category"]
    ],
    order: [
        "name" =>'ASC'
    ],
)]
class ImgMaterial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read:materials"])]
    private ?string $path = null;

    #[ORM\ManyToOne(inversedBy: 'imgMaterials')]
    private ?Material $Material = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getMaterial(): ?Material
    {
        return $this->Material;
    }

    public function setMaterial(?Material $Material): self
    {
        $this->Material = $Material;

        return $this;
    }
}
