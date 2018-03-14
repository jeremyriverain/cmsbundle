<?php

namespace Geekco\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Geekco\CmsBundle\Form\ResourceBaseType;
use Geekco\CmsBundle\Entity\Module;

class ModuleBaseType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{

		$builder
			->add('label')
			->add('pathThemeRelative')
			->add('onlyOne', null)
            ->add('resource', ResourceBaseType::class, [
            'label' => false
            ])
			;

		$builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
			$module = $event->getData();
			$form = $event->getForm();

			if (!$module || null === $module->getId()) {
				$form->add('name');
			}
		});


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
		return 'geekcocmsbundle_modulebase';
	}


}
