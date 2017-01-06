<?php
namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class PackingAssignationType extends AbstractType
{

	public function buildform(FormBuilderInterface $builder, array $options)
	{

		$builder

		->add('packingListPart', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'part_id.completeInfos',
				'choices' => $options['packingListParts'],
				'choice_value' => 'id',
				'multiple' => false

		))
		
		->add('packing', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'getCompleteInfos',
				'choices' => $options['packings'],
				'choice_value' => 'id',
				'multiple' => false
		
		))
		
		->add('origin', TextType::class, array(
				'constraints' => array(new Assert\NotBlank())
		))
		
		->add('price', TextType::class, array(
				'constraints' => array(new Assert\NotBlank())
		))

		->add('save', SubmitType::class, array(
				'label' => false
		));
	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => 'PackingSheets\Domain\PackingAssignation', 'packingListParts' => null, 'packings' => null))
		;
	}

	public function getName() {
		return 'packingAssignation';
	}
}



