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
 *     itemOperations={
 *          "get",
 *          "patch" = {"security"="is_granted('ROLE_WRITE')"},
 *          "delete" = {"security"="is_granted('ROLE_WRITE')"}
 * },
 *     denormalizationContext={
 *          "groups" = {"write_key"}
 *     },
 *     normalizationContext={
 *          "groups" = {"read_key"}
 *     },
 *     collectionOperations={
 *          "get",
 *          "post" = {"security"="is_granted('ROLE_WRITE')"},
 *          "export_yaml"={"export_yaml"},
 *          "export_json"={"export_json"}
 *     }
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
     * @ORM\OneToMany(targetEntity=Translation::class, mappedBy="keyValue", fetch="EAGER")
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
        if ($this->translations->removeElement($translation) && $translation->getKeyValue() === $this) {
            // set the owning side to null (unless already changed)
            $translation->setKeyValue(null);
        }

        return $this;
    }
}
