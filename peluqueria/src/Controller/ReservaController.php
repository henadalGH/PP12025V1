<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Manager\ReservaManager;

class ReservaController extends AbstractController
{
    
    private ReservaManager $resevaManager;
    public function __construct(ReservaManager $resevaManager)
    {
        $this->reservaManager = $resevaManager;
    }

   #[Route('/cliente', name: 'cliente')]
   public function Cliente(ReservaManager $reservaManager)
   {
        $servicios = $reservaManager->getServicio();
        return $this->render('reserva/inicioCliente.html.twig', [
            'servicio' => $servicios
            
        ]);

   }
   
    #[Route('/reserva', name: 'reserva', methods: ['GET'])]
public function reserva(Request $request, ReservaManager $reservaManager): Response
{
    $servicios = $reservaManager->getServicio();
    $peluqueros = $reservaManager->getPeluquero();


    $servicioSeleccionado = (int) $request->query->get('servicio', $servicios[0]->getId());

    $idPeluquero = (int) $request->query->get('idPeluquero', $peluqueros[0]->getId());
    $mes = (int) $request->query->get('mes', date('n'));
    $anio = (int) $request->query->get('anio', date('Y'));
    $diaSeleccionado = $request->query->get('dia');

    $disponibilidades = $reservaManager->obtenerDisponibilidadesConIntervalos($idPeluquero, $mes, $anio);
    $diasDelMes = array_map(fn($d) => $d['dia'], $disponibilidades);

    return $this->render('reserva/reserva.html.twig', [
        'servicio' => $servicios,
        'peluquero' => $peluqueros,
        'disponibilidades' => $disponibilidades,
        'diasDelMes' => $diasDelMes,
        'diaSeleccionado' => $diaSeleccionado,
        'idPeluquero' => $idPeluquero,
        'servicioSeleccionado' => $servicioSeleccionado,
        'mes' => $mes,
        'anio' => $anio,
    ]);
}

    #[Route('/confirmar', name: 'confirmarReserva' , methods: ['POST'])]
public function confirmarReserva(Request $request): Response
{
    $reserva = [
        'idCliente'   => (int) $request->request->get('idCliente'),
        'idServicio'  => (int) $request->request->get('servicio'),
        'idPeluquero' => (int) $request->request->get('idPeluquero'),
        'dia'         => (int) $request->request->get('dia'),
        'mes'         => (int) $request->request->get('mes'),
        'anio'        => (int) $request->request->get('anio'),
        'hora'        => $request->request->get('hora'), 
    ];

    $this->reservaManager->crearReserva($reserva);

    return $this->redirectToRoute('reserva');
}

#[Route('/peluquero', name: 'peluquero')]
public function inicioPeluquero(ReservaManager $reservaManager, Request $request): Response
{   

    $idPeluquero = (int) $request->query->get('idPeluquero');
    $reserva = $reservaManager->obtenerCitasPendiente($idPeluquero);
    return $this->render('reserva/inicioPeluquero.html.twig', [
        'reserva' => $reserva 
    ]);
}

//trae reesevas mendientes
#[Route('/peluquero', name: 'peluquero')]
    public function citasPendientes(ReservaManager $reservaManager): Response
    {
        $peluquero = $this->getUser();

        $citas = $reservaManager->obtenerCitasPendientePorPeluquero($peluquero->getId());

        return $this->render('peluquero/pendiente.html.twig', [
            'citas' => $citas
        ]);
    }

    
#[Route('/estado/{id}', name: 'estado', methods: ['POST'])]
    public function cambiarEstado(ReservaManager $reservaManager, Request $request, int $id): Response
    {   
            $estado = $request->request->get('estado');
            $this->reservaManager->cambiarEstado($estado, $id);

            return $this->redirectToRoute('peluquero');
    }

    #[Route('/peluquero/confirmadas', name: 'peluquero_confirmada')]
    public function citasConfirmadas(ReservaManager $reservaManager): Response
    {
        $peluquero = $this->getUser();

        $citas = $reservaManager->obtenerCitasConfirmadasPorPeluquero($peluquero->getId());

        return $this->render('peluquero/inicioPeluquero.html.twig', [
            'citas' => $citas
        ]);
    }

}




