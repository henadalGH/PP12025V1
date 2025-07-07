<?php

namespace App\Entity;

use App\Repository\DisponibilidadRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DisponibilidadRepository::class)]
class Disponibilidad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'disponibilidads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Peluquero $peluquero = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dia = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $horaInicio = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $horaFin = null;

    #[ORM\Column]
    private ?bool $activo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeluquero(): ?Peluquero
    {
        return $this->peluquero;
    }

    public function setPeluquero(?Peluquero $peluquero): static
    {
        $this->peluquero = $peluquero;

        return $this;
    }

    public function getDia(): ?\DateTime
    {
        return $this->dia;
    }

    public function setDia(\DateTime $dia): static
    {
        $this->dia = $dia;

        return $this;
    }

    public function getHoraInicio(): ?\DateTime
    {
        return $this->horaInicio;
    }

    public function setHoraInicio(\DateTime $horaInicio): static
    {
        $this->horaInicio = $horaInicio;

        return $this;
    }

    public function getHoraFin(): ?\DateTime
    {
        return $this->horaFin;
    }

    public function setHoraFin(\DateTime $horaFin): static
    {
        $this->horaFin = $horaFin;

        return $this;
    }

    public function isActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): static
    {
        $this->activo = $activo;

        return $this;
    }
}
