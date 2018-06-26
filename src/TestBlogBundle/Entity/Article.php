<?php

namespace TestBlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="TestBlogBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(message = "This field should not be empty")
     * @Assert\Regex(
     *     pattern="/[^0-9a-zA-ZñÑÓÍÉÚÁá-úé ]/i",
     *     match=false,
     *     message="This value is not allowed"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     * @Assert\Image(
     *     maxSize = "4M",
     *     mimeTypes = {"image/jpeg", "image/png","image/jpg"},
     *     mimeTypesMessage = "The file must be an image"
     * )
     */
    private $image;

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/articles/';
    }

    public function upload($fileName) {
// the file property can be empty if the field is not required
        if (null === $this->getImage()) {
            return;
        }
        $trozos = explode(".", $this->getImage()->getClientOriginalName());
        $extension = end($trozos);
        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the
        // target filename to move to
        /* $this->getUrlOriginal()->move(
          $this->getUploadDir(), $userID . '_' . $name
          ); */
        $this->getImage()->move(
            $this->getUploadDir(), $fileName . '.' . $extension
        );

        // set the path property to the filename where you've saved the file
        //$this->urlOriginal = $this->getUploadDir() . $userID . '_' . $name;
        $this->image = $this->getUploadDir() . $fileName . '.' . $extension;
    }

    public function removeUpload($file) {
        unlink($file);
    }

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank(message = "This field should not be empty")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="categories", type="string", length=255)
     * @Assert\NotBlank(message = "This field should not be empty")
     * @Assert\Regex(
     *     pattern="/[^0-9a-zA-ZñÑÓÍÉÚÁá-úé ,]/i",
     *     match=false,
     *     message="This value is not allowed"
     * )
     */
    private $categories;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $author;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Article
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Article
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set author
     *
     * @param \TestBlogBundle\Entity\User $author
     *
     * @return Article
     */
    public function setAuthor(\TestBlogBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \TestBlogBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }


    /**
     * Set categories
     *
     * @param string $categories
     *
     * @return Article
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return string
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
