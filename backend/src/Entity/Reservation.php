<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
    ],
    normalizationContext: [
        "groups"=>["read:reservation"]
    ],
    order: [
        "startDate" =>'DESC'
    ],
    paginationItemsPerPage: 5
)]
#[ApiFilter(
    SearchFilter::class, properties: ["material"=> "exact"]
)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read:reservation","read:materials"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[Groups("read:reservation")]
    private ?Material $material = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups("read:reservation")]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups("read:reservation")]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(length: 255)]
    private ?string $emailBorrower = null;

    #[ORM\Column(length: 255)]
    private ?string $statutBorrower = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaterial(): ?Material
    {
        return $this->material;
    }

    public function setMaterial(?Material $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getEmailBorrower(): ?string
    {
        return $this->emailBorrower;
    }

    public function setEmailBorrower(string $emailBorrower): self
    {
        $this->emailBorrower = $emailBorrower;

        return $this;
    }

    public function getStatutBorrower(): ?string
    {
        return $this->statutBorrower;
    }

    public function setStatutBorrower(string $statutBorrower): self
    {
        $this->statutBorrower = $statutBorrower;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }
}
