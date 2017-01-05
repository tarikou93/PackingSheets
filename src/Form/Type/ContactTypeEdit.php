<?php
namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormBuilderInterface;
use PackingSheets\Domain\Code;
use PackingSheets\Domain\Address;
use PackingSheets\DAO\AddressDAO;

class ContactTypeEdit extends AbstractType
{

	public function buildform(FormBuilderInterface $builder, array $options)
	{
		
		$builder
			->add('code', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'mapped' => false,
				'choice_label' => 'label',
				'choices' => $options['codes'],
				'choice_value' => 'id',
				'multiple' => false,
				'data' => $options['codeOld']))
			
			->add('name', TextType::class, array(
				'constraints' => array(new Assert\NotBlank())))
			->add('mail', EmailType::class, array(
				'required' => false))
			->add('phoneNr', TextType::class, array(
				'required' => false))
			->add('faxNr', TextType::class, array(
				'required' => false));
		;
		
		$formModifier = function (FormInterface $form, Code $code) {

			$addresses = null === $code ? array() : $code->getAddresses();
			
			$form->add('addressId', ChoiceType::class, array(
                        'constraints' => array(new Assert\NotBlank()),
                        'choice_label' => 'label',
						'choice_value' => 'id',
                        'choices' => $addresses,
						//'placeholder' => '',
                        'multiple' => false,
					
			));
		};
		
		$builder->addEventListener(
			FormEvents::PRE_SET_DATA,
			function (FormEvent $event) use ($formModifier, $options) {
				$data = $event->getData();
				
				$addressTemp = $options['addressDAO']->find($data->getAddressId());
				$codeTemp = $options['codeDAO']->find($addressTemp->getCodeId());
				
			$formModifier($event->getForm(), $codeTemp);
			
			}
		);
		

		$builder->get('code')->addEventListener(
			FormEvents::POST_SUBMIT,
			function (FormEvent $event) use ($formModifier, $options) {
				$code = $event->getForm()->getData();
				$formModifier($event->getForm()->getParent(), $code);
			}
		);
	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		//->setDefault('codes', null)
		->setDefaults(array('data_class' => 'PackingSheets\Domain\Contact', 'codes' => null, 'codeOld' => null, 'addressDAO' => null, 'codeDAO' => null))
		->setRequired('codes', 'code', 'address')
		->setAllowedTypes('codes', array('array'))
		->setAllowedTypes('addressDAO', 'PackingSheets\DAO\AddressDAO')
		;
	}
	
	public function getName() {
		return 'contact';
	}
}