<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Manager\AdministradorManager;
use Symfony\Component\HttpFoundation\Request; 

final class AdministradorController extends AbstractController
{
    private AdministradorManager $admManager; 

    public function __construct(AdministradorManager $admManager) {
        $this->admManager = $admManager;
    }

    #[Route('/administrador', name: 'administrador')]
    public function inicioAdminstrador(): Response
    {
        $peluqueros = $this->admManager->obtenerPeluqueros();
        $cliente = $this->admManager->obtenerClientes();
        return $this->render('administrador/inicioAdministrador.html.twig', [
            'peluqueros' => $peluqueros,
            'cliente'=> $cliente
        ]);
    }

    #[Route('/administrador/peluqueros', name: 'administrador_peluqueros')]
    public function inicioPeluquero(): Response 
    {
        $peluqueros = $this->admManager->obtenerPeluqueros();
        return $this->render('administrador/inicioSeccionPeluqueros.html.twig', [
            'peluqueros' => $peluqueros
        ]);
    }

    #[Route('/administrador/peluqueros/registrar', name: 'peluqueros_registrar')]
    public function registroPeluquero(): Response
    {
        return $this->render('administrador/registrarPeluquero.html.twig', []);
    }

    #[Route('/administrador/peluqueros/agregar', name: 'peluqueros_agregar', methods: ['POST'])]
    public function agregarPeluquero(Request $request): Response
    { 
        $nPeluquero = [
            'nombre' => $request->request->get('nombre'),
            'apellido' => $request->request->get('apellido'),
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password') 
        ];

        $this->admManager->registrarPeluquero($nPeluquero); 

        return $this->redirectToRoute('administrador_peluqueros');
    }


    #[Route('/administrador/peluquero/baja/{id}', name: 'peluquero_baja')]
    public function borrarPeluquero(int $id, AdministradorManager $admManager)
    {
        $this->admManager->eleminarPeluquero($id);

        return $this->redirectToRoute('administrador_peluqueros');
    }
}
