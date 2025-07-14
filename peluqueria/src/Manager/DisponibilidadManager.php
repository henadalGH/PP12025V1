<?php
namespace App\Manager;

use App\Entity\Disponibilidad;
use App\Repository\PeluqueroRepository;
use Doctrine\ORM\EntityManagerInterface;

class DisponibilidadManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private PeluqueroRepository $peluqueroRepository
    ) {}

    public function nuevaDisponibilidad(array $datos): Disponibilidad
    {

        $peluquero = $this->peluqueroRepository->find($datos['peluquero']);
        if (!$peluquero) {
            throw new \Exception("Peluquero no encontrado.");
        }

        $dia = new \DateTime($datos['dia']);
        $inicio = new \DateTime($datos['inicio']);
        $fin = new \DateTime($datos['fin']);

        if ($inicio >= $fin) {
            throw new \LogicException("La hora de inicio debe ser anterior a la hora de fin.");
        }

        $existe = $this->em->getRepository(Disponibilidad::class)->findOneBy([
            'peluquero' => $peluquero,
            'dia' => $dia,
        ]);

        if ($existe) {
            throw new \LogicException("Ya existe una disponibilidad para este peluquero en esa fecha.");
        }

        $disponibilidad = new Disponibilidad();
        $disponibilidad->setDia($dia);
        $disponibilidad->setHoraInicio($inicio);
        $disponibilidad->setHoraFin($fin);
        $disponibilidad->setPeluquero($peluquero);
        $disponibilidad->setActivo($datos['activo']);

        $this->em->persist($disponibilidad);
        $this->em->flush();

        return $disponibilidad;
    }
}
