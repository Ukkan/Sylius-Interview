<?php
namespace App\Entity\Order;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\OrderInterface;

#[ORM\Entity(repositoryClass: \App\Repository\OrderNoteRepository::class)]
#[ORM\Table(name: 'order_note')]
class OrderNote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: \Sylius\Component\Core\Model\Order::class)]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', onDelete: 'CASCADE', nullable: false, unique: true)]
    private OrderInterface $order;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private ?string $note = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): OrderInterface
    {
        return $this->order;
    }

    public function setOrder(OrderInterface $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;
        return $this;
    }
}
