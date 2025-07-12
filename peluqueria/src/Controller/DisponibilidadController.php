<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Manager\ReservaManager;

final class DisponibilidadController extends AbstractController
{
    #[Route('/disponibilidad', name: 'disponibilidad')]
    public function disponibilidad(ReservaManager $peluquero): Response
    {
        $peluquero = $peluquero->peluqueroAll();
        return $this->render('disponibilidad/disponibilidad.html.twig', [ 
            'peluquero' => $peluquero
        ]);
    }


    #[Router('/disponibilidad/nueva_disponiibilidad', name: 'nuva_diponibilidad', methods: ['POST'])]
    public function nuevaDisponibilidad(Request $resquest): Response
    {
        $disponibilidad = [
            'dia'   => $request->request->get('dia'),
            'inicio' => $request->request->get('inicio'),
            'fin'    => $request->request->get('fin'),
            'peluquero' => $request->request->get('peluquero'),
            'activo' => $request->request->get('activo'),
        ];

        $this->disponibilidadManager->nuevaDisponibilidad($disponibilidad);

        return $this->redirectToRoute('login');
    }
}
