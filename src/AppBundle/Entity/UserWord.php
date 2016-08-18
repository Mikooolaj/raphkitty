<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

use AppBundle\Entity\User;
use AppBundle\Entity\Word;

/**
 * AppBundle\Entity\UserWord
 *
 * @ORM\Table(name="user_word")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserWordRepository")
 */
class UserWord
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
     * @var User $user
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="userwords")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var Word $word
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Word", inversedBy="userwords")
     * @ORM\JoinColumn(nullable=false)
     */
    private $word;

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
     * Sets user.
     *
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * Gets user.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets word.
     *
     * @param Word $word
     */
    public function setWord(Word $word)
    {
        $this->word = $word;
    }

    /**
     * Gets word.
     *
     * @return Word
     */
    public function getWord()
    {
        return $this->word;
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
