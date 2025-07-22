<?php
namespace App\Manager;

use App\Repository\ServicioRepository;
use App\Repository\PeluqueroRepository;
use App\Repository\ClienteRepository;
use App\Repository\DisponibilidadRepository;
use App\Repository\UsuarioRepository;
use App\Repository\ReservaRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Reserva;

class ReservaManager
{
    private ServicioRepository $servicioRepository;
    private PeluqueroRepository $peluqueroRepository;
    private DisponibilidadRepository $disponibilidadRepository;
    private UsuarioRepository $usuarioRepository;
    private EntityManagerInterface $em;
    private ClienteRepository $clienteRepository;
    private ReservaRepository $reservaRespository; 

    public function __construct(
        ServicioRepository $servicioRepository,
        PeluqueroRepository $peluqueroRepository,
        DisponibilidadRepository $disponibilidadRepository,
        UsuarioRepository $usuarioRepository,
        EntityManagerInterface $em,
        ClienteRepository $clienteRepository,
        ReservaRepository $reservaRespository
    
    ) {
        $this->servicioRepository = $servicioRepository;
        $this->peluqueroRepository = $peluqueroRepository;
        $this->disponibilidadRepository = $disponibilidadRepository;
        $this->usuarioRepository = $usuarioRepository;
        $this->clienteRepository = $clienteRepository;
        $this->reservaRepository = $reservaRespository;
        $this->em =$em;
    }

    
    public function getServicio(): array
    {
        return $this->servicioRepository->findAll();
    }

    public function getPeluquero(): array
    {
        $usuarios = $this->usuarioRepository->findAll();
        $peluqueros = [];

        foreach ($usuarios as $usuario) {
            if (in_array('ROLE_PELUQUERO', $usuario->getRoles())) {
                $peluqueros[] = $usuario;
            }
        }

        return $peluqueros;
    }

    public function obtenerDisponibilidadesConIntervalos(int $idPeluquero, int $mes, int $anio): array
    {
        $disponibilidades = $this->disponibilidadRepository->findBy(['peluquero' => $idPeluquero]);

        // Filtrar disponibilidades por mes y año
        $disponibilidadesFiltradas = array_filter($disponibilidades, function ($disp) use ($mes, $anio) {
            $fecha = $disp->getDia(); // DateTime
            return ((int) $fecha->format('n') === $mes) && ((int) $fecha->format('Y') === $anio);
        });

        $disponibilidadesConIntervalos = [];

        foreach ($disponibilidadesFiltradas as $disp) {
            $fecha = $disp->getDia(); // DateTime
            $dia = (int) $fecha->format('j');

            $horaInicio = clone $disp->getHoraInicio();
            $horaFin = clone $disp->getHoraFin();

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

        return $disponibilidadesConIntervalos;
    }

public function crearReserva(array $reserva)
{
    // Crear objeto DateTime directamente
    $fechaHoraStr = sprintf(
        '%04d-%02d-%02d %s:00',
        $reserva['anio'],
        $reserva['mes'],
        $reserva['dia'],
        $reserva['hora']
    );
    $fechaHora = new \DateTime($fechaHoraStr);


    $peluquero = $this->peluqueroRepository->find($reserva['idPeluquero']);
    $cliente = $this->clienteRepository->findOneBy(['usuario' => $reserva['idCliente']]);
    $servicio = $this->servicioRepository->find($reserva['idServicio']);

    
    $nReserva = new Reserva();
    $nReserva->setPeluquero($peluquero);
    $nReserva->setCliente($cliente);
    $nReserva->setServicio($servicio);
    $nReserva->setFechaHora($fechaHora);
    $nReserva->setEstado('pendiente');

    $this->em->persist($nReserva);
    $this->em->flush();
}
public function obtenerCitasPendientePorPeluquero(int $idPeluquero): array
    {
        $peluquero = $this->peluqueroRepository->find($idPeluquero);
        

        return $this->reservaRepository->findBy([
            'peluquero' => $peluquero,
            'estado' => 'pendiente'
        ], ['fechaHora' => 'ASC']);
    }

   public function cambiarEstado(String $estado, int $idReserva): void
{
    $reserva = $this->reservaRepository->find($idReserva);
    $reserva->setEstado($estado);
    $this->em->flush();
    //$this->addFlash('success', 'La cita fue ' . $estado . ' correctamente.');
}

}