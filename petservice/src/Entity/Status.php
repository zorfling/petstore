<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatusRepository")
 */
class Status
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pet", mappedBy="status")
     */
    private $pets;

    public function __construct()
    {
        $this->pets = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Pet[]
     */
    public function getPets(): Collection
    {
        return $this->pets;
    }

    /**
     * @param Pet $pet
     *
     * @return self
     */
    public function addPet(Pet $pet): self
    {
        if (!$this->pets->contains($pet)) {
            $this->pets[] = $pet;
            $pet->setStatus($this);
        }

        return $this;
    }

    /**
     * @param Pet $pet
     *
     * @return self
     */
    public function removePet(Pet $pet): self
    {
        if ($this->pets->contains($pet)) {
            $this->pets->removeElement($pet);
            // set the owning side to null (unless already changed)
            if ($pet->getStatus() === $this) {
                $pet->setStatus(null);
            }
        }

        return $this;
    }
}
