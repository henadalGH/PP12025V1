<?php

namespace App\Controller;

use App\Manager\ReservaManager;  // Asegúrate de importar la clase ReservaManager
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservaController extends AbstractController
{
    

    #[Route('/reserva', name: 'lista_Servicio')]
    public function getServicio(ReservaManager $reservamanager): Response
    {
        
        $servicio = $reservamanager->servicioAll();  
        $peluquero = $reservamanager->peluqueroAll(); 

        return $this->render('reserva/reserva.html.twig', [
            'servicio' => $servicio, 'peluquero' => $peluquero
        ]);
    }

}
