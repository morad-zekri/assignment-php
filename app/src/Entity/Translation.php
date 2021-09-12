<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *            "get"
 *     },
 *     itemOperations={
 *         "patch" = {"security"="is_granted('ROLE_WRITE')"},
 *          "get"
 *     }
 * )
 * @ORM\Entity(repositoryClass=TranslationRepository::class)
 */
class Translation
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
     * @ORM\Column(type="text")
     * @Groups({"read_key"})
     *
     * @var string
     */
    private $textValue;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="translations")
     * @Groups({"read_key"})
     *
     * @var mixed
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity=Key::class, inversedBy="translations")
     *
     * @var mixed
     */
    private $keyValue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextValue(): ?string
    {
        return $this->textValue;
    }

    public function setTextValue(string $textValue): self
    {
        $this->textValue = $textValue;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getKeyValue(): ?Key
    {
        return $this->keyValue;
    }

    public function setKeyValue(?Key $keyValue): self
    {
        $this->keyValue = $keyValue;

        return $this;
    }
}
