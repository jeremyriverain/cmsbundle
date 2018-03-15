<?php

namespace Geekco\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Geekco\CmsBundle\Entity\Resource;

class ResourceBaseType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('stringResources', CollectionType::class, [
                'entry_type' => StringResourceBaseType::class,
                'allow_delete' => true,
                'allow_add' => true,
                'prototype' => true,
                'delete_empty' => true,
                'by_reference' => false,
                'label' => false,
                'entry_options' => [
                    'label' => false
                ],
                'required' => false,
            ])
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Resource::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'geekcocmsbundle_resourcebase';
    }
}
