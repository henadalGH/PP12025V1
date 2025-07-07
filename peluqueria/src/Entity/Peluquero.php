<?php

namespace App\Entity;

use App\Repository\PeluqueroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeluqueroRepository::class)]
class Peluquero
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Disponibilidad>
     */
    #[ORM\OneToMany(targetEntity: Disponibilidad::class, mappedBy: 'peluquero', orphanRemoval: true)]
    private Collection $disponibilidads;

    /**
     * @var Collection<int, Reserva>
     */
    #[ORM\OneToMany(targetEntity: Reserva::class, mappedBy: 'peluquero', orphanRemoval: true)]
    private Collection $reservas;

    /**
     * @var Collection<int, Reserva>
     */
    #[ORM\OneToMany(targetEntity: Reserva::class, mappedBy: 'pelu')]
    private Collection $reserva;

    #[ORM\OneToOne(inversedBy: 'peluquero', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    public function __construct()
    {
        $this->disponibilidads = new ArrayCollection();
        $this->reservas = new ArrayCollection();
        $this->reserva = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Disponibilidad>
     */
    public function getDisponibilidads(): Collection
    {
        return $this->disponibilidads;
    }

    public function addDisponibilidad(Disponibilidad $disponibilidad): static
    {
        if (!$this->disponibilidads->contains($disponibilidad)) {
            $this->disponibilidads->add($disponibilidad);
            $disponibilidad->setPeluquero($this);
        }

        return $this;
    }

    public function removeDisponibilidad(Disponibilidad $disponibilidad): static
    {
        if ($this->disponibilidads->removeElement($disponibilidad)) {
            // set the owning side to null (unless already changed)
            if ($disponibilidad->getPeluquero() === $this) {
                $disponibilidad->setPeluquero(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reserva>
     */
    public function getReservas(): Collection
    {
        return $this->reservas;
    }

    public function addReserva(Reserva $reserva): static
    {
        if (!$this->reservas->contains($reserva)) {
            $this->reservas->add($reserva);
            $reserva->setPeluquero($this);
        }

        return $this;
    }

    public function removeReserva(Reserva $reserva): static
    {
        if ($this->reservas->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getPeluquero() === $this) {
                $reserva->setPeluquero(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reserva>
     */
    public function getReserva(): Collection
    {
        return $this->reserva;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }
}
