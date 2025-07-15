<?php

namespace App\Manager;

use App\Repository\ServicioRepository;
use App\Repository\UsuarioRepository;
use App\Repository\DisponibilidadRepository;


class ReservaManager
{
    private ServicioRepository $servicioRepository;
    private UsuarioRepository $usuarioRespository;
    private disponibilidadRepository $disponibilidadRepository;

    public function __construct(ServicioRepository $servicioRepository, UsuarioRepository $usuarioRespository, disponibilidadRepository $disponibilidadRepository)
    {
        $this->servicioRepository = $servicioRepository;
        $this->usuarioRepository= $usuarioRespository;
        $this->disponibilidadRepository= $disponibilidadRepository;
    }

    public function findAllServicio()
    {
        return $this->servicioRepository->findAll();
    }

    public function findAllPeluquero()
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

   public function obtenerDisponibilidadesConIntervalos(int $idPeluquero, int $mesSeleccionado): array
{
    $disponibilidades = $this->disponibilidadRepository->findBy([
        'peluquero' => $idPeluquero
    ]);

    $disponibilidadesFiltradas = array_filter($disponibilidades, function($disp) use ($mesSeleccionado) {
        return (int) $disp->getDia()->format('n') === $mesSeleccionado;
    });

    $disponibilidadesConIntervalos = [];

    foreach ($disponibilidadesFiltradas as $disp) {
        $fecha = $disp->getDia(); // DateTime
        $dia = (int) $fecha->format('j');

        $horaInicio = clone $disp->getHoraInicio(); // aseguramos no modificar el original
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
    public function obtenerDisponibilidadPorPeluquero(int $idPeluquero) :array
    {
        return $this->disponibilidadRepository->findBy(['peluquero' => $idPeluquero]);
    }
}