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
		
		->add('parts', CollectionType::class, array(
				'entry_type' => PackingListPartType::class,
				'entry_options'  => array(
        			'parts_list'  => $options['parts'],
					'label' => false
    			),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'label' => false
		))
		
		->add('save', SubmitType::class);
	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => 'PackingSheets\Domain\PackingList', 'parts' => null))
		;
	}
	
	public function getName() {
		return 'packingList';
	}
}

