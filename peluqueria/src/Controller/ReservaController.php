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
    
    #[Route('/cliente', name: 'cliente')]
    public function TraerServicio(ReservaManager $reservamanager): Response
    {
        $servicio = $reservamanager->findAllServicio();  
        
        return $this->render('reservar/inicioReserva.html.twig', [
            'servicio' => $servicio, 
        ]);
    }

    #[Route('/reserva', name: 'reservas')]
    public function getServicio(ReservaManager $reservamanager): Response
    {
        $servicio = $reservamanager->findAllServicio();  
        $peluquero = $reservamanager->findAllPeluquero();
        
        return $this->render('reserva/reserva.html.twig', [
            'servicio' => $servicio, 
            'peluquero' => $peluquero
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
public function mostrarDisponibilidad(int $idPeluquero, Request $request): Response
{
    $mesSeleccionado = (int) $request->query->get('mes', (new \DateTime())->format('n'));
    $diaSeleccionado = $request->query->get('dia');

    $disponibilidadesConIntervalos = $this->reservaManager
        ->obtenerDisponibilidadesConIntervalos($idPeluquero, $mesSeleccionado);

    return $this->render('reserva/disponibilidad2.html.twig', [
        'disponibilidades' => $disponibilidadesConIntervalos,
        'diaSeleccionado' => $diaSeleccionado,
        'idPeluquero' => $idPeluquero,
        'mes' => $mesSeleccionado,
    ]);
}



}