<?php

namespace App\Form;

use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderNoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('note', TextareaType::class, [
            'label' => 'Order note',
            'required' => false,
            'attr' => [
                'rows' => 3,
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderInterface::class,
            'csrf_protection' => false, // TODO turn on csrf protection for order note
            'csrf_field_name' => '_csrf_token',
            'csrf_token_id' => 'order_note',
        ]);
    }
}
