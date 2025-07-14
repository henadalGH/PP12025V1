<?php

namespace App\Controller;

use App\Manager\ReservaManager; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReservaController extends AbstractController
{
    private ReservaManager $reservaManager;

    public function __construct(ReservaManager $reservaManager)
    {
        $this->reservaManager = $reservaManager;
    }

    #[Route('/reserva', name: 'reservas')]
    public function getServicio(ReservaManager $reservamanager): Response
    {
        
        $servicio = $reservamanager->findAllServicio();  
        $peluquero = $reservamanager->findAllPeluquero();
        
        return $this->render('reserva/reserva.html.twig', [
            'servicio' => $servicio, 'peluquero' => $peluquero
        ]);
    }

    #[Route('/reserva_nueva', name: 'nueva_reservas', methods: ['POST'])]
    public function nuevaReserva(ReservaManager $reservamanager): Response
    {
        

    }


   #[Route('/reserva/peluquero', name: 'enviar_Peluquero', methods: ['POST'])]
public function VerDisponibilidad(Request $request): Response
{
    $idPeluquero = $request->request->get('peluquero');

    $this->reservaManager->obtenerDisponibilidadPorPeluquero($idPeluquero);

    return $this->redirectToRoute('mostrar_disponibilidad',['idPeluquero'=>$idPeluquero]);
}

    #[Route('/disponibilidad/{idPeluquero}', name: 'mostrar_disponibilidad')]
public function mostrarDisponibilidad(int $idPeluquero): Response
{
    $disponibilidades = $this->reservaManager->obtenerDisponibilidadPorPeluquero($idPeluquero);

    return $this->render('reserva/disponibilidad.html.twig', [
        'disponibilidades' => $disponibilidades
    ]);
}

}
