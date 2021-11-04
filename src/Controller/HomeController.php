<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {
    public function index() {
        $user = $this->getUser();
        return $this->render('index.html.twig', ['user' => $user]);
    }

    #[Route('/blagues', name: 'blagues_index', methods: ['GET'])]
    public function getApi(){
        
    }
}