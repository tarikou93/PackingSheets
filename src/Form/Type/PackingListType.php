<?php
namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PackingListType extends AbstractType
{

	public function buildform(FormBuilderInterface $builder, array $options)
	{

		$builder
		
		->add('psParts', CollectionType::class, array(
				'entry_type' => PackingSheetPartType::class,
				'allow_add' => true,
				'allow_delete' => true
		))
		
		->add('save', SubmitType::class);


	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => array('PackingSheets\Domain\PackingSheetPart'), 'parts' => null))
		;
	}
	
	public function getName() {
		return 'packingList';
	}
}

