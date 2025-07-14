<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Manager\ReservaManager;
use App\Manager\DisponibilidadManager;

final class DisponibilidadController extends AbstractController
{
    #[Route('/disponibilidad', name: 'disponibilidad')]
    public function disponibilidad(ReservaManager $reservaManager): Response
    {
        $peluquero = $reservaManager->findAllPeluquero();

        return $this->render('disponibilidad/disponibilidad.html.twig', [
            'peluquero' => $peluquero
        ]);
    }

    #[Route('/disponibilidad/nueva_disponibilidad', name: 'nueva_disponibilidad', methods: ['POST'])]
    public function nuevaDisponibilidad(Request $request, DisponibilidadManager $disponibilidadManager): Response
{
    $disponibilidad = [
        'dia'       => $request->request->get('dia'),
        'inicio'    => $request->request->get('inicio'),
        'fin'       => $request->request->get('fin'),
        'peluquero' => $request->request->get('peluquero'),
        'activo'    => $request->request->getBoolean('activo'),
    ];

    try {
        $disponibilidadManager->nuevaDisponibilidad($disponibilidad);
        $this->addFlash('success', 'Disponibilidad creada correctamente.');
    } catch (\LogicException $e) {
        $this->addFlash('error', $e->getMessage());
    } catch (\Exception $e) {
        $this->addFlash('error', 'Error inesperado: ' . $e->getMessage());
    }

    return $this->redirectToRoute('disponibilidad');
}

}
