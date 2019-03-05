<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreBillets')
            ->add('type', ChoiceType::class, [
                'choices' => $this->getTypes()
            ])
//            ->add('mail')
//            ->add('dateReservation')
            ->add('dateVisite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }

    public function getTypes(){
        $types = Reservation::TYPE;
        $output = [];
        foreach ($types as $key => $value){
            $output[$value] = $key;
        }
        return $output;
    }
}
