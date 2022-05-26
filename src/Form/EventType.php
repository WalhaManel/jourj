<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',null,["label"=>"Nom :","attr"=>["class"=>"form-control"]])
            ->add('img',null,["label"=>"Nom de l'image :","attr"=>["class"=>"form-control"]])
            ->add('detail',TextareaType::class,["label"=>"Détails :","attr"=>["class"=>"form-control"]])
            ->add('Continuer',SubmitType::class,["attr"=>["class"=>"btn btn-success"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
