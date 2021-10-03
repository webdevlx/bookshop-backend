<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @see SearchFilter
 */
#[ApiResource(
    denormalizationContext: ['groups' => ['books:write']],
    normalizationContext: ['groups' => ['books:read']]
)]
#[ApiFilter(SearchFilter::class, properties: ['category' => 'exact'])]
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['books:read'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['books:read', 'books:write'])]
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(['books:read', 'books:write'])]
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['books:read', 'books:write'])]
    private $category;

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
