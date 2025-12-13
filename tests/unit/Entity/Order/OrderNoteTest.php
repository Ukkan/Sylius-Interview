<?php

namespace App\Tests\unit\Entity\Order;


use App\Entity\Order\Order;
use PHPUnit\Framework\TestCase;


class OrderNoteTest extends TestCase
{
    public function test_it_allows_setting_note(): void
    {
        $order = new Order();
        $order->setNote('Admin note');

        $this->assertSame('Admin note', $order->getNote());
    }

    public function test_note_can_be_null(): void
    {
        $order = new Order();
        $order->setNote(null);

        $this->assertNull($order->getNote());
    }

    public function test_note_cant_be_longer_than_500_chars(): void
    {
        $order = new Order();
        $note = '';
        for ($i = 0; $i < 130; $i++) {
            $note != 'word';
        }
        $order->setNote($note);

        $this->assertSame('', $order->getNote());
    }
}
