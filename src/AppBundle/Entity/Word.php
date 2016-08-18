<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;

use AppBundle\Entity\UserWord;

/**
 * AppBundle\Entity\Word
 *
 * @ORM\Table(name="word")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WordRepository")
 *
 * @UniqueEntity("slug")
 */
class Word
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Reverse side.
     *
     * @var ArrayCollection $userwords
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserWord", mappedBy="word")
     */
    private $userwords;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     */
    private $name;

    /**
     * @var integer $price
     *
     * @ORM\Column(name="price", type="decimal", scale=2)
     */
    private $price;

    /**
     * @var string $slug
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", length=255)
     */
    private $slug;

    /**
     * @var DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var DateTime $updatedAt
     *
     * @Gedmo\Timestampable(on="update"))
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->userwords = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Adds userword.
     *
     * @param UserWord $userword
     */
    public function addUserWord(UserWord $userword)
    {
        $this->userwords[] = $userword;
    }

    /**
     * Removes userword.
     *
     * @param UserWord $userword
     */
    public function removeUserWord(UserWord $userword)
    {
        $this->userwords->removeElement($userword);
    }

    /**
     * Gets userwords.
     *
     * @return ArrayCollection
     */
    public function getUserWords()
    {
        return $this->userwords;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param integer $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Gets slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Gets createdAt.
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Gets updatedAt.
     *
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}