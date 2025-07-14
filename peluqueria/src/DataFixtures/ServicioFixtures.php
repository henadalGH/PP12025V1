<?php
namespace App\DataFixtures;

use App\Entity\Servicio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServicioFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nombres = [
            "Corte de Cabello",
            "Coloración",
            "Peinado",
            "Pedicure",
            "Manicure",
            "Tratamiento Capilar",
            "Depilación"
        ];

        $descripciones = [
            "Corte profesional para todas las edades.",
            "Coloración permanente o semi con productos de calidad.",
            "Peinados para fiestas, bodas o eventos.",
            "Pedicure spa con exfoliación y masajes.",
            "Manicure clásico y con esmalte semipermanente.",
            "Tratamiento hidratante y reparador del cabello.",
            "Depilación con cera para diferentes zonas del cuerpo."
        ];

        $repo = $manager->getRepository(Servicio::class);

        for ($i = 0; $i < count($nombres); $i++) {
            // Buscar servicio existente por nombre
            $existente = $repo->findOneBy(['nombre' => $nombres[$i]]);

            if (!$existente) {
                $servicio = new Servicio();
                $servicio->setNombre($nombres[$i]);
                $servicio->setDescripcion($descripciones[$i]);
                $servicio->setDuracion(mt_rand(15, 60));
                $servicio->setPrecio(mt_rand(2000, 5000));
                $manager->persist($servicio);
            }
        }

        $manager->flush();
    }
}
