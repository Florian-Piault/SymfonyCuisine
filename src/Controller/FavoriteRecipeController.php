<?php

namespace App\Controller;

use App\Entity\FavoriteRecipe;
use App\Entity\Recipe;
use App\Form\FavoriteRecipeType;
use App\Repository\FavoriteRecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/favorite/recipe')]
class FavoriteRecipeController extends AbstractController
{
    #[Route('/', name: 'favorite_recipe_index', methods: ['GET'])]
    public function index(FavoriteRecipeRepository $favoriteRecipeRepository): Response
    {
        return $this->render('favorite_recipe/index.html.twig', [
            'favorite_recipes' => $favoriteRecipeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'favorite_recipe_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $favoriteRecipe = new FavoriteRecipe();
        $recipeId = $request->query->get('id');
        $recipe = $this->getDoctrine()
                        ->getRepository(Recipe::class)
                        ->find($recipeId);
        $user = $this->getUser();

        $form = $this->createForm(FavoriteRecipeType::class, $favoriteRecipe);
        $form->handleRequest($request);

        $favoriteRecipe->setRecipe($recipe);
        $favoriteRecipe->setUser($user);


        // if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($favoriteRecipe);
            $entityManager->flush();

            return $this->redirectToRoute('recipe_show', ['id' => $recipeId], Response::HTTP_SEE_OTHER);
        // }

        // return $this->renderForm('favorite_recipe/new.html.twig', [
        //     'favorite_recipe' => $favoriteRecipe,
        //     'form' => $form,
        // ]);
    }

    #[Route('/{id}', name: 'favorite_recipe_show', methods: ['GET'])]
    public function show(FavoriteRecipe $favoriteRecipe): Response
    {
        return $this->render('favorite_recipe/show.html.twig', [
            'favorite_recipe' => $favoriteRecipe,
        ]);
    }

    #[Route('/{id}/edit', name: 'favorite_recipe_edit', methods: ['GET','POST'])]
    public function edit(Request $request, FavoriteRecipe $favoriteRecipe): Response
    {
        $form = $this->createForm(FavoriteRecipeType::class, $favoriteRecipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('favorite_recipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('favorite_recipe/edit.html.twig', [
            'favorite_recipe' => $favoriteRecipe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'favorite_recipe_delete', methods: ['POST'])]
    public function delete(Request $request, FavoriteRecipe $favoriteRecipe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$favoriteRecipe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($favoriteRecipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('favorite_recipe_index', [], Response::HTTP_SEE_OTHER);
    }
}
