<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Disponibilidad;

class DisponibilidadFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
           /* $peluquero = $manager->getRepository(Peluquero::class)->findOneBy([]); // primer peluquero

            if (!$peluquero) {
                throw new \Exception("No hay peluquero cargado en la base de datos.");
            }
        for ($d = 1; $d <= 6; $d++) {
            $disponibilidad = new Disponibilidad();
            $fecha = new \DateTime("2025-07-0" . ($d + 6));
            $disponibilidad->setPeluero();
            $disponibilidad->setDia($fecha);
            $disponibilidad->setHoraInicio(new \DateTime('09:00'));
            $disponibilidad->setHoraFin(new \DateTime('17:00'));
            $disponibilidad->setActivo(true);

            $manager->persist($disponibilidad);
        }
        $manager->flush();*/
    }
}
