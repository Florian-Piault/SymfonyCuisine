<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 */
class Ingredient
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
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $picture;

    /**
     * @ORM\OneToOne(targetEntity=IngredientQuantity::class, mappedBy="ingredient", cascade={"persist", "remove"})
     */
    private $ingredientQuantity;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getIngredientQuantity(): ?IngredientQuantity
    {
        return $this->ingredientQuantity;
    }

    public function setIngredientQuantity(?IngredientQuantity $ingredientQuantity): self
    {
        // unset the owning side of the relation if necessary
        if ($ingredientQuantity === null && $this->ingredientQuantity !== null) {
            $this->ingredientQuantity->setIngredient(null);
        }

        // set the owning side of the relation if necessary
        if ($ingredientQuantity !== null && $ingredientQuantity->getIngredient() !== $this) {
            $ingredientQuantity->setIngredient($this);
        }

        $this->ingredientQuantity = $ingredientQuantity;

        return $this;
    }

    public function __toString() {
        return $this->name;
    }
}
