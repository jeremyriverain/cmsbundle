<?php

namespace Geekco\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Geekco\CmsBundle\Entity\StringResource;

class StringResourceType extends AbstractType
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

                if ($child instanceof StringResource) {
                    $child->getLabel() !== null ? $label = $child->getLabel() : $label = $child->getName();
                    $child->getHelp() !== null ? $help = $child->getHelp(): $help = null;

                    $constraints = [];
                    
                    if (!empty($child->getConstraints())) {
                        foreach ($child->getConstraints() as $constraint) {
                            $compound = "Symfony\\Component\\Validator\\Constraints\\".$constraint;
                            $constraints[] = new $compound();
                        }
                    }
                    
                    $form->add('value', null, [
                        'label' => $label,
                        'attr' => [
                            'help' => $help
                        ],
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
            'data_class' => StringResource::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_stringresource';
    }
}
