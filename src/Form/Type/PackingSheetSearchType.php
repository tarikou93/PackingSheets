<?php
namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class PackingSheetSearchType extends AbstractType
{

	public function buildform(FormBuilderInterface $builder, array $options)
	{

		$builder

		->add('ref', TextType::class, array(
				'required' => false,
				'attr' => array(
						'readonly' => false,
						'placeholder' => 'Reference')
		))

		->add('groupId', ChoiceType::class, array(
				'choices' => $options['availableGroups'],
				'multiple' => true,
				'attr' => array(
						'readonly' => false,
						'placeholder' => 'Group',
						'required' => true),
				'constraints' => array(new Assert\NotBlank())))
									
		->add('serviceId', ChoiceType::class, array(
				'required' => false,
				'choice_label' => 'label',
				'choices' => $options['services'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array(
						'placeholder' => 'Service'
				)))																																																																		

		->add('dateIssue', TextType::class, array(
				'required' => false,
				'attr' => array(
						'readonly' => false,
						'placeholder' => 'Date'
				)))

		->add('AWB', TextType::class, array(
				'required' => false,
				'attr' => array(
						'readonly' => false,
						'placeholder' => 'AWB'
				)))
																										

		->add('imputId', ChoiceType::class, array(
				'required' => false,
				'choice_label' => 'label',
				'choices' => $options['imputs'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array(
					'placeholder' => 'Imputation'	
				
				)))

		->add('signed', CheckboxType::class, array(
				'required' => false))

		->add('printed', CheckboxType::class, array(
				'required' => false))
		
		->add('pn', TextType::class, array(
				'constraints' => array(
						new Assert\Regex(array (
							'pattern' => '/^[ A-Za-z0-9-]*$/'))),
				'required' => false,
				'attr' => array(
						'placeholder' => 'Part Number'
			)))
		
		->add('serial', TextType::class, array(
				'required' => false,
				'attr' => array(
						'placeholder' => 'Part Serial'
			)))
		
		->add('desc', TextareaType::class, array(
				'required' => false,
				'attr' => array(
						'placeholder' => 'Part Description'
			)))
		
		->add('hscode', TextType::class, array(
				'required' => false,
				'attr' => array(
						'placeholder' => 'Part HSCode'	
			)))
			
		->add('datalistCode', TextType::class, array(
				'required'=> false))
		
		->add('datalistAddress', TextType::class, array(
				'required'=> false))
		
		->add('datalistContact', TextType::class, array(
				'required'=> false));

	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => 'PackingSheets\Domain\PackingSheetSearch', 'read_only' => null, 
				'codes' => null, 'services' => null, 'imputs' => null,'availableGroups' => null
		))
		;
	}

	public function getName() {
		return 'packingSheetSearch';
	}
}



