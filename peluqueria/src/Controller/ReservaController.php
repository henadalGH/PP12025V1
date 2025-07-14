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
            'servicio' => $servicio, 
            'peluquero' => $peluquero
        ]);
    }

    #[Route('/reserva_nueva', name: 'nueva_reservas', methods: ['POST'])]
    public function nuevaReserva(ReservaManager $reservamanager): Response
    {
        // Implementar lógica para guardar reserva
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
    // Obtener el mes enviado por query (?mes=1..12), o mes actual si no viene
    $mesSeleccionado = (int) $request->query->get('mes', (new \DateTime())->format('n'));

    // Obtener todas las disponibilidades para el peluquero
    $disponibilidades = $this->reservaManager->obtenerDisponibilidadPorPeluquero($idPeluquero);

    // Filtrar las disponibilidades para el mes seleccionado
    $disponibilidadesFiltradas = array_filter($disponibilidades, function($disp) use ($mesSeleccionado) {
        return (int)$disp->getDia()->format('n') === $mesSeleccionado;
    });

    $disponibilidadesConIntervalos = [];

    foreach ($disponibilidadesFiltradas as $disp) {
        $fecha = $disp->getDia(); // DateTime
        $dia = (int) $fecha->format('j');

        $horaInicio = $disp->getHoraInicio();
        $horaFin = $disp->getHoraFin();

        $intervalos = [];
        $interval = new \DateInterval('PT30M');
        $periodo = new \DatePeriod($horaInicio, $interval, $horaFin);

        foreach ($periodo as $hora) {
            $intervalos[] = $hora->format('H:i');
        }

        $disponibilidadesConIntervalos[] = [
            'fecha' => $fecha,
            'dia' => $dia,
            'intervalos' => $intervalos,
        ];
    }

    $diaSeleccionado = $request->query->get('dia');

    return $this->render('reserva/disponibilidad2.html.twig', [
        'disponibilidades' => $disponibilidadesConIntervalos,
        'diaSeleccionado' => $diaSeleccionado,
        'idPeluquero' => $idPeluquero,
        'mes' => $mesSeleccionado,
    ]);
}

}
