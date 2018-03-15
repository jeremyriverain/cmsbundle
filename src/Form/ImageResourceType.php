<?php
namespace Geekco\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Geekco\CmsBundle\Entity\ImageResource;

class ImageResourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ...
            ->add('imageFile', FileType::class, [
                'label' => 'Choisissez une image',
                'required' => false,
            ])
            ->add('image', null, [
                'mapped' => false,
                'label' => false,
                'attr' => [
                    'class' => 'hide',
                ]
            ])
            // ...
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ImageResource::class,
        ));
    }
}
