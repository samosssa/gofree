<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{

    /**
     * Permet d avoir la config d un champ
     * @param $label
     * @param $placeholder
     * @param array $options
     * @return array
     */
    protected function getConfiguration($label, $placeholder, $options = []){
        return array_merge([
            'label'=> $label,
            'attr' => [
                'placeholder' => $placeholder
            ]

        ], $options);
    }
}
