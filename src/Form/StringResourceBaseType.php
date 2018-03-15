<?php

namespace Geekco\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Geekco\CmsBundle\Entity\StringResource;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class StringResourceBaseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('constraints', ChoiceType::class, [
                'multiple' => true,
                'required' => false,
                'choices'  => array(
                    'Url' => 'Url',
                    'NotBlank' => 'NotBlank',
                ),
            ])
            ->add('value')
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => StringResource::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'geekcocmsbundle_stringresourcebase';
    }
}
