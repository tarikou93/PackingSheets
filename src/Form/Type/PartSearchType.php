<?php

namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PartSearchType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('pn', TextType::class, array(
				'constraints' => array(new Assert\Regex(array (
						'pattern' => '/^[ A-Za-z0-9-]*$/'))),
				'required' => false))
				
		->add('serial', TextType::class, array(
				'required' => false))
				
		->add('desc', TextareaType::class, array(
				'required' => false))
				
		->add('hscode', TextType::class, array(
				'required' => false));
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'PackingSheets\Domain\Part'
		));
	}

	public function getName()
	{
		return 'partSearch';
	}
}


