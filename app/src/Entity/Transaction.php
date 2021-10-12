<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use App\Repository\TransactionRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={
 *     "get",
 *     "post",
 *     },
 *     itemOperations={
 *      "get",
 *     "put"={"security" = "object.getMadeBy() == user"},
 *     "delete"={"security" = "object.getMadeBy() == user"},
 *     },
 *  normalizationContext={"groups"={"transaction::read"}, "swagger_definition_name"="Read"},
 *  denormalizationContext={"groups"={"transaction::write"}, "swagger_definition_name"="Write"},
 * )
 * @ApiFilter(OrderFilter::class, properties={"createDate": "desc", "value": "desc"})
 * @ApiFilter(DateFilter::class, properties={"createDate"})
 * @ApiFilter(RangeFilter::class, properties={"value"})
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @ORM\EntityListeners({"App\Doctrine\TransactionSetOwnerListener"})
 */
class Transaction
{
    /**
     * @Groups({"transaction::read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction::read", "transaction::write"})
     * @Assert\NotBlank()
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Name cannot be longer than {{ limit }} characters."
     * )
     */
    private string $name;

    /**
     * @Groups({"transaction::read", "transaction::write"})
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    private int $value;

    /**
     * @Groups({"transaction::read", "transaction::write"})
     * @Assert\NotBlank()
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $createDate;

    /**
     * @Groups({"transaction::read", "transaction::write"})
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Description cannot be longer than {{ limit }} characters."
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $description;

    /**
     * @Groups({"transaction::read", "transaction::write"})
     * @Groups({"transaction"})
     * @ORM\ManyToOne(targetEntity=Category::class)
     */
    private ?Category $category;

    /**
     * @Groups({"transaction::read", "transaction::write"})
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity=Currency::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Currency $currency;

    /**
     * @Groups({"transaction::read"})
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private User $madeBy;

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

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getCreateDate(): ?DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): self
    {
        $this->currency = $currency;


        return $this;
    }

    public function getMadeBy(): User
    {
        return $this->madeBy;
    }

    public function setMadeBy(User $madeBy): self
    {
        $this->madeBy = $madeBy;

        return $this;
    }
}
