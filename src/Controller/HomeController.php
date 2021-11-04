<?php

namespace App\Controller;

use App\Service\ApiService;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {
    public function index(ApiService $apiService) {
        
        $dataApi = $apiService->getData();
        $user = $this->getUser();

        return $this->render('index.html.twig', [
            'user' => $user,
            'dataApi' => $dataApi
        ]);
    }
}