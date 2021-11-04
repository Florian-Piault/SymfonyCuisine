<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {
    public function index(UserRepository $userRepository) {
        $user = $this->getUser();
        // $favoriteRecipes = $userRepository->getFavoriteRecipes($user);

        // dd($favoriteRecipes);
        
        return $this->render('index.html.twig', [
            'user' => $user 
        ]);
    }
}