<?php
namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormBuilderInterface;


class PackingSheetListAddType extends AbstractType
{

	public function buildform(FormBuilderInterface $builder, array $options)
	{

		$builder
		->add('part', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'mapped' => false,
				'choice_label' => 'pn',
				'choices' => $options['parts'],
				'choice_value' => 'id',
				'multiple' => false))
										
		->add('quantity', TextType::class, array(
				'constraints' => array(new Assert\NotBlank(), 
			new Assert\Regex(array(
            'pattern' => '/(?:\d*\.)?\d+/')))));
										
	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => 'PackingSheets\Domain\PackingSheetPart', 'parts' => null))
		;
	}

	public function getName() {
		return 'packingSheetListAdd';
	}
}