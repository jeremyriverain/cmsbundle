<?php

namespace Geekco\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Geekco\CmsBundle\Entity\IntegerResource;

class IntegerResourceType extends AbstractType
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

                if ($child instanceof IntegerResource) {
                    $child->getLabel() !== null ? $label = $child->getLabel() : $label = $child->getName();

                    $constraints = [];

                    if (!empty($child->getConstraints())) {
                        foreach ($child->getConstraints() as $key => $constraint) {
                            if (!is_array($constraint)) {
                                $compound = "Symfony\\Component\\Validator\\Constraints\\".$constraint;
                                $constraints[] = new $compound();
                            } else {
                                $compound = "Symfony\\Component\\Validator\\Constraints\\".$key;
                                $constraints[] = new $compound($constraint);
                            }
                        }
                    }

                    $form->add('value', null, [
                        'label' => $label,
                        'constraints' => $constraints
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
            'data_class' => IntegerResource::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_integerresource';
    }
}
