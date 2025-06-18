<?php

namespace App\DataFixtures;

use App\Entity\Servicio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServicioFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nombre = [
            " ",
            "Corte de Cabello",
            "Coloración",
            "Peinado",
            "Manicure",
            "Pedicure",
            "Tratamiento Capilar",
            "Depilación"
        ];

        $descripciones = [
            " ",
            "Corte profesional para todas las edades.",
            "Coloración permanente o semi con productos de calidad.",
            "Peinados para fiestas, bodas o eventos.",
            "Manicure clásico y con esmalte semipermanente.",
            "Pedicure spa con exfoliación y masajes.",
            "Tratamiento hidratante y reparador del cabello.",
            "Depilación con cera para diferentes zonas del cuerpo."
        ];
        
        
        for ($i=1; $i<count($nombre) ; $i++) { 
            $servicio = new Servicio();
            $servicio->setNombre($nombre[$i]);
            $servicio->setDescripción($descripciones[$i]);
            $servicio->setDuracion(mt_rand(15,50));
            $servicio->setPrecio(mt_rand(2000, 5000));
            $manager->persist($servicio);
        }
            $manager->flush();
    }
}
