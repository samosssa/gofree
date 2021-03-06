<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Mission;
use App\Entity\Skill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MissionType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function(Category $cat) {
                    return sprintf('(%d) %s', $cat->getId(), $cat->getTitle());
                }
            ])

            ->add('title',
                TextType::class,
                $this->getConfiguration("Titre", "Tapez un Titre")
            )
            ->add('slug',
                TextType::class,
                $this->getConfiguration("Adresse web", "Taper l'adresse web(automatique", [
                    'required' => false
                ])
            )
            ->add('startDay',
                DateType::class,
                $this->getConfiguration("Date d'arrivée", "date à laquelle vous comptez arriver", ["widget" => "single_text"
                ])
            )
            ->add('endDate',
                DateType::class,
                $this->getConfiguration("Date de départ", "La date à laquelle vous quittez les lieux", ["widget" => "single_text"
                ])
            )
            ->add('coverImage',
                UrlType::class,
                $this->getConfiguration("URL de l'image principale", "Donnez l'adresse d'une image qui donne envie")
            )
            ->add('description',
                TextType::class,
                $this->getConfiguration("description", "Donnez une description"))

            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => function(Skill $skill) {
                    return sprintf('(%d) %s', $skill->getId(), $skill->getTitle());
                }
            ])
            ->add(
                'price',
                MoneyType::class,
                $this->getConfiguration("Prix par mission","Indiquer le prix que vous voulez pour la mission!")
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
