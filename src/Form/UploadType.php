<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UploadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'label' => false,
                'data' => null,
                'attr' => [
                    'class' => 'upload-file',
                ],
                'constraints' => [
                    new File([
                        'maxSize'          => '10M',
                        'maxSizeMessage'   => 'Die Datei ist zu groß ({{ size }} {{ suffix }}), Zulässige maximale Größe ist {{ limit }} {{ suffix }}',
                        'mimeTypes'        => [
                            'application/json',
                            'text/plain'
                        ],
                        'mimeTypesMessage' => 'Der Dateityp ist nicht gültig ({{ type }}), die zulässigen Typen sind ({{ types }})',
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'upload',
                'attr' => [
                    'class' => 'upload-btn',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
