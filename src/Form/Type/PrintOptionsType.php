<?php
namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class PrintOptionsType extends AbstractType
{

	public function buildform(FormBuilderInterface $builder, array $options)
	{

		$builder

		->add('header', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'text',
				'choices' => $options['headers'],
				'choice_value' => 'id',
				'multiple' => false

		))

		->add('footer', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'text',
				'choices' => $options['footers'],
				'choice_value' => 'id',
				'multiple' => false

		))

		->add('hscodesStatus', CheckboxType::class, array(
				'required' => false))

		->add('save', SubmitType::class, array(
				'label' => false
		));
	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => 'PackingSheets\Domain\PrintOptions', 'headers' => null, 'footers' => null))
		;
	}

	public function getName() {
		return 'printOptions';
	}
}




