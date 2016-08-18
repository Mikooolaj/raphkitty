<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;

use AppBundle\Entity\UserWord;

/**
 * AppBundle\Entity\User
 *
 * @ORM\Table(name="user", indexes={@ORM\Index(columns={"slug"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 *
 * @UniqueEntity("slug")
 */
class User
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserWord", mappedBy="user")
     */
    private $userwords;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Regex("/^[a-zA-Z0-9-_]+$/")
     * @Assert\Length(min=3, max=255)
     */
    private $name;

    /**
     * @var ineteger $balance
     *
     * @ORM\Column(name="balance", type="decimal", scale=2)
     */
    private $balance;

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
     */
    public function __construct()
    {
        $this->userwords = new ArrayCollection();
        $this->balance = 0;
    }

    /**
     * Gets id.
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
     * Sets name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets the name of the User.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set balance
     *
     * @param integer $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * Get balance
     *
     * @return integer
     */
    public function getBalance()
    {
        return $this->balance;
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
