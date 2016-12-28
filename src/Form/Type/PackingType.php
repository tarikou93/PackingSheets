<?php
namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PackingType extends AbstractType
{

	public function buildform(FormBuilderInterface $builder, array $options)
	{
		
		$builder

		->add('parts', CollectionType::class, array(
				'entry_type' => PackingPartType::class,
				'entry_options'  => array(
						'parts_list'  => $options['parts_list'],
						'label' => false
				),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'label' => false,
		))
		
		
		->add('M1', TextType::class, array(
				//'attr' => array('readonly' => $options['read_only']),
				'constraints' => array(new Assert\NotBlank())
				
		))
		
		
		->add('M2', TextType::class, array(
				//'attr' => array('readonly' => $options['read_only']),
				'constraints' => array(new Assert\NotBlank())
				
		))
		
		->add('M3', TextType::class, array(
				//'attr' => array('readonly' => $options['read_only']),
				'constraints' => array(new Assert\NotBlank())
				
		))
		
		->add('netWeight', TextType::class, array(
				//'attr' => array('readonly' => $options['read_only']),
				'constraints' => array(new Assert\NotBlank())
				
		))
		
		->add('grossWeight', TextType::class, array(
				//'attr' => array('readonly' => $options['read_only']),
				'constraints' => array(new Assert\NotBlank())
				
		))

		->add('packType_id', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'label',
				'choices' => $options['packing_types'],
				'choice_value' => 'id',
				'multiple' => false,
				//'attr' => array('readonly' => $options['read_only'])
				
		))
			
		->add('save', SubmitType::class, array(
				'label' => false,
				//'attr' => array('readonly' => $options['read_only'])
				
		));
				
	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => 'PackingSheets\Domain\Packing', 'parts_list' => null, 'packing_types' => null, 'read_only' => null, 'readonly' => null,'context' => null))
		;
	}

	public function getName() {
		return 'packing';
	}
}



