<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Repository\UsuarioRepository;
use App\Entity\Cliente;

class ClienteFixtures extends Fixture
{
    private UsuarioRepository $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function load(ObjectManager $manager): void
    {
    
        $usuarios = $this->usuarioRepository->findAll();

        foreach ($usuarios as $usuario) {
            if (\in_array('ROLE_CLIENTE', $usuario->getRoles())) {

                if ($usuario->getCliente() === null) {
                    $cliente = new Cliente();
                    $cliente->setUsuario($usuario); 
                    $cliente->setContacto('123456789');

                    $manager->persist($cliente);
                }
            }
        }

        $manager->flush();
    }
}
