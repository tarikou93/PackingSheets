<?php
namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PackingSheetType extends AbstractType
{

	public function buildform(FormBuilderInterface $builder, array $options)
	{

		$builder

		->add('packings', CollectionType::class, array(
				'entry_type' => PackingType::class,
				'entry_options'  => array(
						'parts_list'  => $options['parts'],
						'packing_types' => $options['packTypes']
				),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
		))

		->add('save', SubmitType::class);
	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => 'PackingSheets\Domain\PackingSheet', 'parts' => null, 'packTypes' => null))
		;
	}

	public function getName() {
		return 'packingSheet';
	}
}


