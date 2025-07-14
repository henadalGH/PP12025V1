<?php

namespace App\Controller;

use App\Manager\ReservaManager; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservaController extends AbstractController
{
    

    #[Route('/reserva', name: 'reservas')]
    public function getServicio(ReservaManager $reservamanager): Response
    {
        
        $servicio = $reservamanager->findAllServicio();  
        $peluquero = $reservamanager->findAllPeuquero();
        
        return $this->render('reserva/reserva.html.twig', [
            'servicio' => $servicio, 'peluquero' => $peluquero
        ]);
    }

    #[Route('/reserva_nueva', name: 'nueva_reservas', methods: ['POST'])]
    public function nuevaReserva(ReservaManager $reservamanager): Response
    {
        

    }


    #[Route('/reserva{idPeluquero}', name: 'ver_disponibilidad')]
    public function VerDisponibilidad(ReservaManager $reservamanager, int $idPeluquero): Response
    {
        $disponibilidades = $disponibilidadManager->obtenerDisponibilidadPorPeluquero($idPeluquero);
        return $this->render('turno/disponibilidad.html.twig', [
            'disponibilidades' => $disponibilidades,
        ]);
    }
}
