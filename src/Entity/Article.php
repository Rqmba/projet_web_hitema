<?php

namespace App\Entity;

use AllowDynamicProperties;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Index(name : 'article_slug_index', columns: ['slug'])]
#[ORM\UniqueConstraint(name: 'article_title_slug_unique', columns: ['title', 'slug'])]
#[AllowDynamicProperties]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column(length: 100)]
    private ?string $slug = null;

    #[ORM\Column(length: 80)]
    private null|string|UploadedFile $picture = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $quantityinStock = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column]
    private ?bool $statut = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Manga $manga = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
     * @var Collection<int, OrdersDetails>
     */
    #[ORM\OneToMany(targetEntity: OrdersDetails::class, mappedBy: 'article')]
    private Collection $ordersDetails;

    public function __construct()
    {
        $this->ordersDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPicture(): null|string|UploadedFile 
    {
        return $this->picture;
    }

    public function setPicture(null|string|UploadedFile  $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantityinStock(): ?int
    {
        return $this->quantityinStock;
    }

    public function setQuantityinStock(?int $quantityinStock): static
    {
        $this->quantityinStock = $quantityinStock;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getManga(): ?manga
    {
        return $this->manga;
    }

    public function setManga(?manga $manga): static
    {
        $this->manga = $manga;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, OrdersDetails>
     */
    public function getOrdersDetails(): Collection
    {
        return $this->ordersDetails;
    }

    public function addOrdersDetail(OrdersDetails $ordersDetail): static
    {
        if (!$this->ordersDetails->contains($ordersDetail)) {
            $this->ordersDetails->add($ordersDetail);
            $ordersDetail->setArticle($this);
        }

        return $this;
    }

    public function removeOrdersDetail(OrdersDetails $ordersDetail): static
    {
        if ($this->ordersDetails->removeElement($ordersDetail)) {
            // set the owning side to null (unless already changed)
            if ($ordersDetail->getArticle() === $this) {
                $ordersDetail->setArticle(null);
            }
        }

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
   public function generateSlug(SluggerInterface $slugger)
   {
       if (!$this->slug) {
           $this->slug = $slugger->slug($this->title)->lower();
       }
   }
}

