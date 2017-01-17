<?php
namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormBuilderInterface;


class PackingListPartType extends AbstractType
{

	public function buildform(FormBuilderInterface $builder, array $options)
	{

		$builder
		->add('part_id', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'completeInfos',
				'choices' => $options['parts_list'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('class' => 'form-control'),
				'label' => false,
				'required' => false
		))
												
		->add('quantity', TextType::class, array(
				'constraints' => array(new Assert\NotBlank(), 
					new Assert\Regex(array(
		            'pattern' => '/(?:\d*\.)?\d+/'))),
				'attr' => array('class' => 'form-control')
			));
										
	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => 'PackingSheets\Domain\PackingListPart', 'parts_list' => null))
		;
	}

	public function getName() {
		return 'packingListPart';
	}
}