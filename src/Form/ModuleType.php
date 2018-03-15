<?php

namespace Geekco\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Geekco\CmsBundle\Form\ResourceType;
use Geekco\CmsBundle\Form\ModuleType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Geekco\CmsBundle\Entity\Module;

class ModuleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('resource', ResourceType::class, ['label' => false])
            ->add('children', CollectionType::class, [
                'entry_type' => ModuleType::class,
                'allow_delete' => true,
                'allow_add' => true,
                'prototype' => false,
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
            'data_class' => Module::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_module';
    }
}
