<?php
namespace Geekco\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Geekco\CmsBundle\Entity\Page;
use Geekco\CmsBundle\Entity\PageResource;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class PageResourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {



        $builder->addEventListener(FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($builder)
            {
                $form = $event->getForm();
                $child = $event->getData();

                if ($child instanceof PageResource) {
                    $child->getLabel() !== null ? $label = $child->getLabel() : $label = $child->getName();

                    $form
                        ->add('page', EntityType::class, [
                            'label' => $label,
                            'class' => Page::class,
                            'required' => true,
                            'placeholder' => 'Choisir une page'
                        ])
                        ;             


                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PageResource::class,
        ));
    }
}
