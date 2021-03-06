<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 * @UniqueEntity("token")
 */
class Reservation
{

    public function __construct()
    {
        $this->billets = new ArrayCollection();
        $this->dateReservation = new DateTime();
        $this->token = substr(sha1(random_bytes(10)), 0, 10);
    }

    const TYPE = [
        0 => 'Journée',
        1 => 'Demi-journée'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @CustomAssert\Nombre()
     */
    private $nombreBillets;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @CustomAssert\Type()
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateReservation;

    /**
     * @ORM\Column(type="date")
     *
     * @CustomAssert\Date()
     */
    private $dateVisite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Billet", mappedBy="reservation", orphanRemoval=true, cascade={"persist"})
     */
    private $billets;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $token;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreBillets(): ?int
    {
        return $this->nombreBillets;
    }

    public function setNombreBillets(int $nombreBillets): self
    {
        $this->nombreBillets = $nombreBillets;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Reservation
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function getDateVisite(): ?\DateTimeInterface
    {
        return $this->dateVisite;
    }

    public function setDateVisite(\DateTimeInterface $dateVisite): self
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    /**
     * @return Collection|Billet[]
     */
    public function getBillets(): Collection
    {
        return $this->billets;
    }

    public function addBillet(Billet $billet): self
    {
        if (!$this->billets->contains($billet)) {
            $this->billets[] = $billet;
            $billet->setReservation($this);
        }

        return $this;
    }

    public function removeBillet(Billet $billet): self
    {
        if ($this->billets->contains($billet)) {
            $this->billets->removeElement($billet);
            // set the owning side to null (unless already changed)
            if ($billet->getReservation() === $this) {
                $billet->setReservation(null);
            }
        }

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
