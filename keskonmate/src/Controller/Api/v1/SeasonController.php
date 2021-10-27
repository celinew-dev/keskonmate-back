<?php

namespace App\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeasonController extends AbstractController
{
    /**
     * @Route("/api/v1/season", name="api_v1_season")
     */
    public function index(): Response
    {
        return $this->render('api/v1/season/index.html.twig', [
            'controller_name' => 'SeasonController',
        ]);
    }
}
