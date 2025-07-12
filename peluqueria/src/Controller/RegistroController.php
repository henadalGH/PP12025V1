<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Manager\RegistroManager;

final class RegistroController extends AbstractController
{
    private RegistroManager $registroManager;

    public function __construct(RegistroManager $registroManager)
    {
        $this->registroManager = $registroManager;
    }

    #[Route('/registro/nuevo', name: 'Nuevo_registro', methods: ['POST'])]
    public function crearUsuario(Request $request): Response
    {
        $usuario = [
            'nombre'   => $request->request->get('nombre'),
            'apellido' => $request->request->get('apellido'),
            'email'    => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'telefono' => $request->request->get('telefono'),
        ];

        $this->registroManager->nuevoUsuario($usuario);

        return $this->redirectToRoute('login');
    }

    #[Route('/registro', name: 'registro')]
    public function Registrarse(): Response
    {
        return $this->render('registro/registro.html.twig', [
            'controller_name' => 'RegistroController',
        ]);
    }
}
