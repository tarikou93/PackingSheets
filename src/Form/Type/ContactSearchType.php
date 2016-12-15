<?php
namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

class ContactSearchType extends AbstractType
{

	public function buildform(FormBuilderInterface $builder, array $options)
	{

		$builder
					
		->add('name', TextType::class, array(
				'required' => false))
		->add('mail', EmailType::class, array(
				'required' => false))
		->add('phoneNr', TextType::class, array(
				'required' => false))
		->add('faxNr', TextType::class, array(
				'required' => false));
		;
	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => 'PackingSheets\Domain\ContactSearch'))
		;
	}

	public function getName() {
		return 'contactSearch';
	}
}