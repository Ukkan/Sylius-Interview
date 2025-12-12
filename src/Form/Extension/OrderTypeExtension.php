<?php

declare(strict_types=1);

namespace App\Form\Extension;

use Sylius\Bundle\AdminBundle\Form\Type\OrderType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class OrderTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note', TextType::class, [
                'required' => false,
                'label' => 'app.form.order.note',
            ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [OrderType::class];
    }
}
