<?php

namespace Geekco\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Geekco\CmsBundle\Entity\ColorResource;
use Symfony\Component\Validator\Constraints\Regex;

class ColorResourceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($builder)
            {
                $form = $event->getForm();
                $child = $event->getData();

                if ($child instanceof ColorResource) {
                    $child->getLabel() !== null ? $label = $child->getLabel() : $label = $child->getName();

                    $form->add('value', null, [
                        'label' => $label,
                      'attr' => [
                                'class' => 'color-picker'
                            ],
                        'constraints' => [
                          new Regex(array('pattern'=>"/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", 'message'=> "La couleur n'est pas enregistrée dans un format valide."))
                        ]
                    ]);

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
            'data_class' => ColorResource::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_colorresource';
    }


}
