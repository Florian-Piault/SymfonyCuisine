<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecipeRepository::class)
 */
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $preparationTime;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cookingTime;

    /**
     * @ORM\OneToMany(targetEntity=Step::class, mappedBy="recipe", cascade={"persist","remove"})
     */
    private $steps;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="recipe", cascade={"persist","remove"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=IngredientQuantity::class, mappedBy="recipe", cascade={"persist","remove"})
     */
    private $ingredientQuantities;
    
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rating;

    /**
     * @ORM\OneToMany(targetEntity=Rate::class, mappedBy="recipe", cascade={"remove","persist"})
     */
    private $rates;

    /**
     * @ORM\OneToMany(targetEntity=FavoriteRecipe::class, mappedBy="recipe", cascade={"remove"})
     */
    private $favoriteRecipes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureUrl;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->ingredientQuantities = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->rates = new ArrayCollection();
        $this->favoriteRecipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPreparationTime(): ?int
    {
        return $this->preparationTime;
    }

    public function setPreparationTime(int $preparationTime): self
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    public function getCookingTime(): ?int
    {
        return $this->cookingTime;
    }

    public function setCookingTime(?int $cookingTime): self
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getTimeConverted($time): ?string {
        $result = '';
        $convertedTime = $time;
            
        $seconds = $convertedTime % 60;
        $result = $seconds == 0 ? '' : $seconds.'s';
        (int) $convertedTime /= 60;

        $minutes = $convertedTime % 60;
        $result = $minutes == 0 ? '' : $minutes.'mn'.$result;
        (int) $convertedTime /= 60;

        $hours = $convertedTime % 24;
        $result .= $hours == 0 ? '' : $hours.'h'.$result;
        (int) $convertedTime /= 24;

        return $result;
    }

    // public function getCookingTimeConverted(): ?string {
        
    // }

    /**
     * @return Collection|Step[]
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): self
    {
        if (!$this->steps->contains($step)) {
            $this->steps[] = $step;
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): self
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setRecipe($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getRecipe() === $this) {
                $comment->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|IngredientQuantity[]
     */
    public function getIngredientQuantities(): Collection
    {
        return $this->ingredientQuantities;
    }

    public function addIngredientQuantity(IngredientQuantity $ingredientQuantity): self
    {
        if (!$this->ingredientQuantities->contains($ingredientQuantity)) {
            $this->ingredientQuantities[] = $ingredientQuantity;
            $ingredientQuantity->setRecipe($this);
        }

        return $this;
    }

    public function removeIngredientQuantity(IngredientQuantity $ingredientQuantity): self
    {
        if ($this->ingredientQuantities->removeElement($ingredientQuantity)) {
            // set the owning side to null (unless already changed)
            if ($ingredientQuantity->getRecipe() === $this) {
                $ingredientQuantity->setRecipe(null);
            }
        }

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|Rate[]
     */
    public function getRates(): Collection
    {
        return $this->rates;
    }

    public function addRate(Rate $rate): self
    {
        if (!$this->rates->contains($rate)) {
            $this->rates[] = $rate;
            $rate->setRecipe($this);
        }

        return $this;
    }

    public function removeRate(Rate $rate): self
    {
        if ($this->rates->removeElement($rate)) {
            // set the owning side to null (unless already changed)
            if ($rate->getRecipe() === $this) {
                $rate->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FavoriteRecipe[]
     */
    public function getFavoriteRecipes(): Collection
    {
        return $this->favoriteRecipes;
    }

    public function addFavoriteRecipe(FavoriteRecipe $favoriteRecipe): self
    {
        if (!$this->favoriteRecipes->contains($favoriteRecipe)) {
            $this->favoriteRecipes[] = $favoriteRecipe;
            $favoriteRecipe->setRecipe($this);
        }

        return $this;
    }

    public function removeFavoriteRecipe(FavoriteRecipe $favoriteRecipe): self
    {
        if ($this->favoriteRecipes->removeElement($favoriteRecipe)) {
            // set the owning side to null (unless already changed)
            if ($favoriteRecipe->getRecipe() === $this) {
                $favoriteRecipe->setRecipe(null);
            }
        }

        return $this;
    }

    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    public function setPictureUrl(?string $pictureUrl): self
    {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }

}
