<?php
namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;

class ImageType extends AbstractType
{

	public function buildform(FormBuilderInterface $builder, array $options)
	{

		$builder

		->add('img1', FileType::class, array(
				'label' => 'Image (.jpg/.png file)',
				'required' => false,
				'data_class' => null
		))
		
		->add('img2', FileType::class, array(
				'label' => 'Image (.jpg/.png file)',
				'required' => false,
				'data_class' => null
		))
		
		->add('img3', FileType::class, array(
				'label' => 'Image (.jpg/.png file)',
				'required' => false,
				'data_class' => null
		))
		
		->add('img4', FileType::class, array(
				'label' => 'Image (.jpg/.png file)',
				'required' => false,
				'data_class' => null
		))
		
		->add('img5', FileType::class, array(
				'label' => 'Image (.jpg/.png file)',
				'required' => false,
				'data_class' => null
		))

		->add('save', SubmitType::class, array(
				'label' => false,
				//'attr' => array('readonly' => $options['read_only'])

		));
	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => 'PackingSheets\Domain\ImageForm'))
		;
	}

	public function getName() {
		return 'image';
	}
}



