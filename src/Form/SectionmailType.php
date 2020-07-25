<?php

namespace App\Form;

use App\Entity\Sectionmail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SectionmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user1name', HiddenType::class)
            ->add('user2name', HiddenType::class)
            ->add('user3mail', HiddenType::class)
            ->add('content', TextareaType::class)
            ->add('sg1name', HiddenType::class)
            ->add('sg2name', HiddenType::class)
            ->add('sg3mail', HiddenType::class)
            // ->add('dateMail', DateType::class, [
            //     // renders it as a single text box
            //     'widget' => 'single_text',
                
            // ])
            ->add('gender', HiddenType::class , [
                'data' => 'abcdef'
            ])
            ->add('Annuler', SubmitType :: class , [
                'label' => 'Annuler',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sectionmail::class,
        ]);
    }
}
