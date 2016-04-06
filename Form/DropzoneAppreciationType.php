<?php

namespace Innova\CollecticielBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DropzoneAppreciationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $defaultDateTimeOptions = array(
            'required'      => false,
            'read_only'     => false,
            'component'     => true,
            'autoclose'     => true,
            'language'      => $options['language'],
            'date_format'   => $options['date_format'],
            'format'        => $options['date_format'],
        );

        $builder
            ->add('gradingScale', 'collection',
             ('type' => new GradingScale()
             )
            )

            ;
    }
    public function getName()
    {
        return 'innova_collecticiel_appreciation_form';
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'language' => 'fr',
                'translation_domain' => 'innova_collecticiel',
                'date_format'     => DateType::HTML5_FORMAT,
            )
        );
    }
}
