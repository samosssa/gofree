<?php

namespace App\Form;

use App\Entity\UserSoc;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationSocType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration("Nom de la société", "Votre société est..."))
            ->add('tva', IntegerType::class, $this->getConfiguration("TVA", "Votre numéro de tva est.."))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Votre adresse email..."))
            ->add('picture', UrlType::class, $this->getConfiguration("Photo de profil", "Url de votre avatar..."))
            ->add('hash', PasswordType::class, $this->getConfiguration("Mot de passe","Choisissez un bon mot de passe !"))
            ->add('passwordConfirm', PasswordType::class, $this->getConfiguration("Confirmation mot de passe", "Retapper le meme mot de passe"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Présentez vous en quelques mots..."))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSoc::class,
        ]);
    }
}
