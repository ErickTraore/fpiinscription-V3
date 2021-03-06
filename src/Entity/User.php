<?php

// src/Entity/User.php


namespace App\Entity;

use App\Controller\TestezController;
use App\Entity\Adhesion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user") 
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern     = "/^((\+|00)33\s?)[67](\s?\d{2}){4}$/")
     * 
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * * @Assert\Length(
     *      min = 4,
     *      max = 50,
     *      minMessage = "Your PASSWORD must be at least {{ 4 }} characters long",
     *      maxMessage = "Your PASSWORD cannot be longer than {{ 50 }} characters"
     * )
     */
    private $plainPassword;

    private $passwordEncoder;


    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=70)
     */
    private $password;

     /**
     * @ORM\Column(name="date_crea", type="datetime")
     * @Assert\DateTime()
     */
    private $date_crea;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Adhesion", cascade={"persist","remove"})
     */
    private $adhesion;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_signat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $signature;

    /**
     * @ORM\OneToMany(targetEntity=Fpicount::class, mappedBy="user")
     */
    private $fpicounts;

    /**
     *  @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function __construct()
    {
        
        $this->roles = array('ROLE_SYMPATHISANT');
        $this->date_crea = new \Datetime();
        $this->fpicounts = new ArrayCollection();

    }

    // other properties and methods


    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(?string $username)
    {
        $this->username = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

     /**
     * @see UserInterface
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

     /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }


    public function getRoles(): array   {
        $roles = $this->roles;    
        $roles[] = '';
  return array_unique($roles); 
    }

    public function eraseCredentials()
    {
    }
    
    /** 
    * @var blob|null
    */
    public function getAdhesion()
    {
        return $this->adhesion;
    }

    public function setAdhesion($adhesion)
    {
        $this->adhesion = $adhesion;

        return $this;
    }

    public function setDateCrea(\DATETIME $dateCrea)
    {
        $this->date_crea = $dateCrea;

        return $this;
    }

    /**
     * Get dateCrea
     *
     * @return \DATETIME
     */
    public function getDateCrea()
    {
        return $this->date_crea;
    }

    /**
    * toString
    * @return string
    */
    public function __toString(){
        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get dateCrea
     *
     * @return \DATETIME
     */
    public function getDateSignat(): ?\DateTimeInterface
    {
        return $this->date_signat;
    }

    public function setDateSignat(?\DateTimeInterface $dateSignat): self
    {
        $this->date_signat = $dateSignat;

        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * @return Collection|Fpicount[]
     */
    public function getFpicounts(): Collection
    {
        return $this->fpicounts;
    }

    public function addFpicount(Fpicount $fpicount): self
    {
        if (!$this->fpicounts->contains($fpicount)) {
            $this->fpicounts[] = $fpicount;
            $fpicount->setUser($this);
        }

        return $this;
    }

    public function removeFpicount(Fpicount $fpicount): self
    {
        if ($this->fpicounts->contains($fpicount)) {
            $this->fpicounts->removeElement($fpicount);
            // set the owning side to null (unless already changed)
            if ($fpicount->getUser() === $this) {
                $fpicount->setUser(null);
            }
        }

        return $this;
    }

    }
  