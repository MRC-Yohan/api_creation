<?php

namespace App\Form;

use App\Entity\Casino;
use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nb_of_player')
            ->add('name')
            ->add('casino', EntityType::class, [
                'class' => Casino::class,
                'label' => 'Choisir un casino',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
