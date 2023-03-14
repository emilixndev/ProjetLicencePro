<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ImgMaterialRepository;
use App\Service\ContainerParametersHelper;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ImgMaterialRepository::class)]
#[Vich\Uploadable]
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


    #[Groups(["read:materials"])]
    #[Vich\UploadableField(mapping:"material_images", fileNameProperty:"path")]
    private File|null $file=null;

    #[ORM\ManyToOne(inversedBy: 'imgMaterials')]
    private ?Material $Material = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file)
    {
        $this->file = $file;

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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }
}
