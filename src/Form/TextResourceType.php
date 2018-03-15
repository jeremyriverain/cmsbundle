<?php

namespace Geekco\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Geekco\CmsBundle\Entity\TextResource;

class TextResourceType extends AbstractType
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


                if ($child instanceof TextResource) {
                    $child->getLabel() !== null ? $label = $child->getLabel() : $label = $child->getName();
                    if ($child->getIsHtml() === false) {
                        $form
                            ->add('value', null, [
                                'label' => $label,
                                'attr' => [
                                'class' => 'textarea-ckeditor materialize-textarea'
                                ]
                            ])
                            ;
                    } else {
                        $form->add('value', null, [
                            'label' => $label,
                            'attr' => [
                            'class' => 'textarea-ckeditor html materialize-textarea'
                            ],
                        ])
                        ;
                    }
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
            'data_class' => TextResource::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_textresource';
    }
}
