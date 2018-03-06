<?php

namespace Geekco\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Geekco\CmsBundle\Entity\Resource;
use Geekco\CmsBundle\Form\TextResourceType;
use Geekco\CmsBundle\Form\StringResourceType;
use Geekco\CmsBundle\Form\ImageResourceType;
use Geekco\CmsBundle\Entity\Page;
use Geekco\CmsBundle\Form\IntegerResourceType;

class ResourceType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            if ($event->getData() instanceof Resource) {
                $configuration = $event->getData()->getConfiguration();
                $form = $event->getForm();

                $form
                    ->add('textResources', CollectionType::class, [
                        'entry_type' => TextResourceType::class,
                        'allow_delete' => false,
                        'allow_add' => false,
                        'prototype' => true,
                        'delete_empty' => false,
                        'by_reference' => false,
                        'label' => false,
                        'entry_options' => [
                            'label' => false
                        ],
                        'required' => false,
                    ])
                    ->add('stringResources', CollectionType::class, [
                        'entry_type' => StringResourceType::class,
                        'allow_delete' => false,
                        'allow_add' => false,
                        'prototype' => true,
                        'delete_empty' => false,
                        'by_reference' => false,
                        'label' => false,
                        'entry_options' => [
                            'label' => false
                        ],
                        'required' => false,
                    ])
                    ->add('integerResources', CollectionType::class, [
                        'entry_type' => IntegerResourceType::class,
                        'allow_delete' => false,
                        'allow_add' => false,
                        'prototype' => true,
                        'delete_empty' => false,
                        'by_reference' => false,
                        'label' => false,
                        'entry_options' => [
                            'label' => false
                        ],
                        'required' => false,
                    ])
                    ->add('colorResources', CollectionType::class, [
                        'entry_type' => ColorResourceType::class,
                        'allow_delete' => false,
                        'allow_add' => false,
                        'prototype' => true,
                        'delete_empty' => false,
                        'by_reference' => false,
                        'label' => false,
                        'entry_options' => [
                            'label' => false
                        ],
                        'required' => false,
                    ])
                    ->add('booleanResources', CollectionType::class, [
                        'entry_type' => BooleanResourceType::class,
                        'allow_delete' => false,
                        'allow_add' => false,
                        'prototype' => true,
                        'delete_empty' => false,
                        'by_reference' => false,
                        'label' => false,
                        'entry_options' => [
                            'label' => false
                        ],
                        'required' => false,
                    ]);
                if($event->getData()->getImageResources()->count() > 0 || array_key_exists('imageResources', $configuration)){
                    $form->add('imageResources', CollectionType::class, [
                        'entry_type' => ImageResourceType::class,
                        'allow_delete' => $configuration['imageResources']['delete'],
                        'allow_add' => $configuration['imageResources']['add'],
                        'prototype' => true,
                        'delete_empty' => true,
                        'by_reference' => false,
                        'label' => false,
                        'entry_options' => [
                            'label' => false,
                        ],
                        'required' => false,
                    ]);
                }
                if($event->getData()->getPageResources()->count() > 0){
                    $form->add('pageResources', CollectionType::class, [
                        'entry_type' => PageResourceType::class,
                        'allow_delete' => false,
                        'allow_add' => false,
                        'prototype' => true,
                        'delete_empty' => true,
                        'by_reference' => false,
                        'label' => false,
                        'entry_options' => [
                            'label' => false,
                        ],
                        'required' => false,
                    ]);
                }
            }
        });
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
        return 'appbundle_resource';
    }


}
