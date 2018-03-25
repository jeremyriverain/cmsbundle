<?php

namespace Geekco\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Geekco\CmsBundle\Entity\Page;
use Geekco\CmsBundle\Form\ImageResourceType;

class PageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $page = $event->getData();
            $form = $event->getForm();

            if (!$page || null === $page->getId()) {
                $form->add('name', null, [
                    'label' => 'Titre de la page',
                    'attr' => [
                        'help' => "L'URL est déduite directement du titre de la page."
                    ]
                ])
                ;
            } else {
                $form->add('image', ImageResourceType::class, ['label' => false]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Page::class
        ));
    }
}
