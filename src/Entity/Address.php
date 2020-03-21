<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 * @UniqueEntity("email",message="This Email address is already used")
 * @UniqueEntity("phone",message="This Phone number is already used")
 * @UniqueEntity(fields = {"first_name","last_name"},errorPath="first_name",message="This Name is already used")
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please enter a valid first name")
     * @Assert\Length(min="5", minMessage="First name must contain at least {{ limit }} characters")
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please enter a valid last name")
     * @Assert\Length(min="2", minMessage="Last name must contain at least {{ limit }} characters")
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $street_no;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $zip;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     * @Assert\NotBlank(message = "Please enter a valid phone no")
     * @Assert\Length(min = "10",max="10",exactMessage="Phone number must contain {{ limit }} numbers")
     * @Assert\Type(type = "numeric",message ="Phone no must contain numbers only")
     */
    private $phone;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(message = "Please enter a valid email address")
     * @Assert\NotBlank(message = "Please enter an email address")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $city;

     /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $created_by;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $updated_by;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getStreetNo(): ?int
    {
        return $this->street_no;
    }

    public function setStreetNo(?int $street_no): self
    {
        $this->street_no = $street_no;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getZip(): ?int
    {
        return $this->zip;
    }

    public function setZip(?int $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedBy(): ?int
    {
        return $this->created_by;
    }

    public function setCreatedBy(int $created_by): self
    {
        $this->created_by = $created_by;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getUpdatedBy(): ?int
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(int $updated_by): self
    {
        $this->updated_by = $updated_by;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
