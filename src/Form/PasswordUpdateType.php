<?php

namespace App\Form;


use App\Form\ApplicationType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, $this->getConfiguration("Ancien mot de passe", "Donnez votre mot de passe actuel..."))
            ->add('newPassword', passwordType::class, $this->getConfiguration("Nouveau mot de passe", "Donnez votre nouveau mot de passe..."))
            ->add('confirmPassword', passwordType::class, $this->getConfiguration("confirmation du mot de passe", "Confirmer votre nouveau mot de passe"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
