<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\KeyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={"get","patch","delete"},
 *     denormalizationContext={
 *          "groups" = {"write_key"}
 *     },
 *     normalizationContext={
 *          "groups" = {"read_key"}
 *     },
 * )
 * @ORM\Entity(repositoryClass=KeyRepository::class)
 * @ORM\Table(name="`key`")
 * @UniqueEntity("name")
 */
class Key
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"write_key", "read_key"})
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Translation::class, mappedBy="keyValue")
     * @Groups({"read_key"})
     *
     * @var mixed
     */
    private $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return ArrayCollection|mixed
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    public function addTranslation(Translation $translation): self
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setKeyValue($this);
        }

        return $this;
    }

    public function removeTranslation(Translation $translation): self
    {
        if ($this->translations->removeElement($translation)) {
            // set the owning side to null (unless already changed)
            if ($translation->getKeyValue() === $this) {
                $translation->setKeyValue(null);
            }
        }

        return $this;
    }
}
