<?php

namespace App\Form;

use App\Entity\Apropos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AproposType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('date_enregistrement')
            ->add('update_at')
            ->add('delate_at')
            ->add('titre')
            ->add('files')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Apropos::class,
        ]);
    }
}
