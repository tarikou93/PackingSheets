<?php
namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PackingType extends AbstractType
{

	public function buildform(FormBuilderInterface $builder, array $options)
	{

		$builder

		->add('parts', CollectionType::class, array(
				'entry_type' => PackingPartType::class,
				'entry_options'  => array(
						'parts_list'  => $options['parts']
				),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
		));

	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => 'PackingSheets\Domain\Packing', 'parts_list' => null))
		;
	}

	public function getName() {
		return 'packing';
	}
}



