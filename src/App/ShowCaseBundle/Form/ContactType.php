<?php

namespace App\ShowCaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;


class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contactLastname',null,  [
                'label' => 'Nom',
            ])
            ->add('contactFirstname',null,  [
                'label' => 'Prénom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('phone', null, [
                'label' => 'Téléphone mobile',
            ])
            ->add('method', ChoiceType::class, [
                'label' => 'Type d\'envoi',
                'choices' => [
                    'SMS' => 'SMS',
                    'Email' => 'EMAIL',
                    'messagerie instantanée' => 'MESSAGERIE'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('messageContent', TextareaType::class, [
                'label' => 'Votre message',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-success top-space'
                ]
            ])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\ShowCaseBundle\Entity\Contact'
        ));
    }




}
