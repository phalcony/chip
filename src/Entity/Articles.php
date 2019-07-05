<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticlesRepository")
 */
class Articles
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $urlId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlSlug;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $headline;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subtitle;

    /**
     * @ORM\Column(type="text")
     */
    private $introduction;

    /**
     * @ORM\Column(type="datetime")
     */
    private $displayDate;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Authors", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Images", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chapters", mappedBy="articles", cascade={"persist", "remove"})
     */
    private $chapter;

    public function __construct()
    {
        $this->chapter = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlId(): ?int
    {
        return $this->urlId;
    }

    public function setUrlId(int $urlId): self
    {
        $this->urlId = $urlId;

        return $this;
    }

    public function getUrlSlug(): ?string
    {
        return $this->urlSlug;
    }

    public function setUrlSlug(string $urlSlug): self
    {
        $this->urlSlug = $urlSlug;

        return $this;
    }

    public function getHeadline(): ?string
    {
        return $this->headline;
    }

    public function setHeadline(string $headline): self
    {
        $this->headline = $headline;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getDisplayDate(): ?\DateTimeInterface
    {
        return $this->displayDate;
    }

    public function setDisplayDate(\DateTimeInterface $displayDate): self
    {
        $this->displayDate = $displayDate;

        return $this;
    }

    public function getAuthor(): ?Authors
    {
        return $this->author;
    }

    public function setAuthor(Authors $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getImage(): ?Images
    {
        return $this->image;
    }

    public function setImage(Images $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Chapters[]
     */
    public function getChapter(): Collection
    {
        return $this->chapter;
    }

    public function addChapter(Chapters $chapter): self
    {
        if (!$this->chapter->contains($chapter)) {
            $this->chapter[] = $chapter;
            $chapter->setArticles($this);
        }

        return $this;
    }

    public function removeChapter(Chapters $chapter): self
    {
        if ($this->chapter->contains($chapter)) {
            $this->chapter->removeElement($chapter);
            // set the owning side to null (unless already changed)
            if ($chapter->getArticles() === $this) {
                $chapter->setArticles(null);
            }
        }

        return $this;
    }

    public function getDisplayDateTimestamp(): int
    {
        if ($this->getDisplayDate()) {
            return $this->getDisplayDate()->getTimestamp();
        }
        return 0;
    }

    public function setDisplayDateTimestamp(int $timestamp)
    {
        $this->displayDate = \DateTime::createFromFormat('U', $timestamp);
        return $this;
    }

}
