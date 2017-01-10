<?php

namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TableType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				
		->add('label', TextareaType::class, array(
				'mapped' => $options['labelField'],
				'required' => $options['labelField']
		))
		
		->add('text', TextareaType::class, array(
				'mapped' => $options['textField'],
				'required' => false
		))
			
		->add('save', SubmitType::class, array(
				'label' => false
		));
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array('selectedTable' => null, 'textField' => null, 'labelField' => null));
	}

	public function getName()
	{
		return 'tableObject';
	}
}


