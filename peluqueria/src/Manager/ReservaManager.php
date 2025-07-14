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

    public function findAllPeuquero()
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

    public function obtenerDisponibilidadPorPeluquero(int $idPeluquero): array
    {
        return $this->disponibilidadRepository->findBy(
            ['peluquero' => $idPeluquero, 'activo' => true],
            ['fecha' => 'ASC', 'horaInicio' => 'ASC']
        );
    }

    }

