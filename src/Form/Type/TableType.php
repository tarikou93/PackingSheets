<?php

namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TableType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				
		->add('codeId', ChoiceType::class, array(
				'choice_label' => 'label',
				'choices' => $options['codes'],
				'choice_value' => 'id',
				'multiple' => false,
				'mapped' => $options['mapped']
		))
				
		->add('label', TextareaType::class, array(
				'mapped' => $options['labelField']
		))
		
		->add('text', TextareaType::class, array(
				'mapped' => $options['textField']
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
		$resolver->setDefaults(array('codes' => null, 'mapped' => null, 'selectedTable' => null, 'textField' => null, 'labelField' => null));
	}

	public function getName()
	{
		return 'tableObject';
	}
}


