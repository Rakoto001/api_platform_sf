<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use App\Controller\PostCountController;
use App\Controller\PostPublishController;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:collection']],
    denormalizationContext: ['groups' => ['write:Post']],
    collectionOperations: [
        'get',
        'post' => ['validation_groups' => ['create:Post']],
        'count' => [
            'method' => 'GET',
            'path' => '/posts/all/count',
            'controller' => PostCountController::class,
            'read' => false,
            'filters' => [],
            'pagination_enabled' => false,
            'openapi_context' => [
                'summary' => 'Affiche le nombre des articles',
                'parametters' => [
                    [
                        'in' => 'query',
                        'name' => 'online',
                        'schema' => [
                            'types' => 'integer',
                            'maximum' => 1,
                            'minimum' => 0, 
                        ],
                        'description' => 'filtre les articles en ligne'

                    ]
                ]
            ]
        ]

    ],
    itemOperations: [

        'put' => [ 'denormalization_context' => ['groups' => ['put:Post'] ] ],
        'get' => [ 'normalization_context' => ['groups' => ['read:item', 'read:Post']]],
        'publish' => [
            'method' => 'POST',
            'path' => 'posts/{id}/publish',
            'controller' => PostPublishController::class,
            'openapi_context' => [
                'summary' => 'Permet l\'activation d\'un article',
                'requestBody' => [
                    'content' => [
                        'application/ld+json' => [
                            // 'schema' => []
                        ]
                    ]
                ]
                
            ]
        ]

    ]
)]
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:collection'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:collection', 'put:Post', 'write:Post'])]
    #[Assert\Length(min: 5, groups: ['create:Post'])]
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:collection', 'put:Post', 'write:Post'])]
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(['read:item', 'put:Post', 'write:Post'])]
    private $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(['read:item'])]
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

   


    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="posts", cascade={"persist"})
     */
    #[Groups(['read:item', 'write:Post'])]
    private $category;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Groups(['read:collection'])]
    private $online;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->createdAt = new \DatetimeImmutable();
        $this->updatedAt = new \DatetimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    /**
     * @return Collection<int, self>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(self $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setCategory($this);
        }

        return $this;
    }

    public function removePost(self $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getCategory() === $this) {
                $post->setCategory(null);
            }
        }

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

    public function isOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }
}
