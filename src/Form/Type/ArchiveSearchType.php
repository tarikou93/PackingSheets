<?php
namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ArchiveSearchType extends AbstractType
{

	public function buildform(FormBuilderInterface $builder, array $options)
	{

		$builder

		->add('ref', TextType::class, array(
				'required' => false,
				'attr' => array(
						'readonly' => false,
						'placeholder' => 'Archive Reference')
		))

		->add('serializationDate', TextType::class, array(
				'required' => false,
				'attr' => array(
						'readonly' => false,
						'placeholder' => 'Archive Date'
		)))

		->add('user', TextType::class, array(
				'required' => false,
				'attr' => array(
						'readonly' => false,
						'placeholder' => 'Archive User'
		)));
								
	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => 'PackingSheets\Domain\ArchiveSearch'))
		;
	}

	public function getName() {
		return 'archiveSearch';
	}
}





