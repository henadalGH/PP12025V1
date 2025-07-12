<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Disponibilidad;
use App\Entity\Peluquero;
use App\Repository\UsuarioRepository;

class DisponibilidadFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Buscar todos los peluqueros existentes
        $peluqueros = $manager->getRepository(Peluquero::class)->findAll();

        // Comenzar en el 1 de julio de 2025
        $fecha = new \DateTime('2025-07-01');

        for ($i = 0; $i < 31; $i++) {
            $diaSemana = (int) $fecha->format('N');

            if ($diaSemana <= 6) { 
                foreach ($peluqueros as $peluquero) {
                    $disponibilidad = new Disponibilidad();
                    $disponibilidad->setDia(clone $fecha);
                    $disponibilidad->setHoraInicio(new \DateTime('09:00'));
                    $disponibilidad->setHoraFin(new \DateTime('17:00'));
                    $disponibilidad->setActivo(true);

                    $manager->persist($disponibilidad);
                }
            }

            $fecha->modify('+1 day');
        }

        $manager->flush();
    }
}
