<?php

namespace App\Controller;

use App\Repository\ServicioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ServicioRepository $servicioRepository): Response
    {
        $servicio = $servicioRepository->findAll(); // obtiene todos los servicios desde la base de datos

        return $this->render('index/index.html.twig', [
            'servicio' => $servicio,
        ]);
    }
}
