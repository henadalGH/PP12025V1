<?php

namespace App\Manager;

use App\Repository\ServicioRepository;
use App\Repository\UsuarioRepository;


class ReservaManager
{
    private ServicioRepository $servicioRepository;
    private UsuarioRepository $usuarioRespository;

    public function __construct(ServicioRepository $servicioRepository, UsuarioRepository $usuarioRespository)
    {
        $this->servicioRepository = $servicioRepository;
        $this->usuarioRepository= $usuarioRespository;
    }

    public function servicioAll()
    {
        return $this->servicioRepository->findAll();
    }

    public function peluqueroAll()
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

    }

