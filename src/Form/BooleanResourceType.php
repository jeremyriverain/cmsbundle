<?php

namespace Geekco\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Geekco\CmsBundle\Entity\BooleanResource;

class BooleanResourceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($builder) {
                $form = $event->getForm();
                $child = $event->getData();


                if ($child instanceof BooleanResource) {
                    $child->getLabel() !== null ? $label = $child->getLabel() : $label = $child->getName();
                    $form
                        ->add('value', null, [
                            'label' => $label
                        ])
                        ;
                }
            }
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => BooleanResource::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_booleanresource';
    }
}
