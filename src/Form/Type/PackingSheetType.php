<?php
namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
//use Symfony\Component\Form\FormEvents;
//use Symfony\Component\Form\FormEvent;
//use Symfony\Component\Form\FormInterface;
//use PackingSheets\Domain\Code;
use PackingSheets\Domain\Address;
use PackingSheets\DAO\AddressDAO;

class PackingSheetType extends AbstractType
{

	public function buildform(FormBuilderInterface $builder, array $options)
	{

		$builder
		
		->add('ref', TextType::class, array(
				'attr' => array('readonly' => $options['read_only'])		
		))
				
		->add('groupId', ChoiceType::class, array(
				'choices' => $options['availableGroups'],
				'attr' => array('readonly' => $options['read_only']),
				'constraints' => array(new Assert\NotBlank())))
				
		->add('consignedCode', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'mapped' => false,
				'choice_label' => 'label',
				'choices' => $options['codes'],
				'choice_value' => 'id',
				'multiple' => false,
				'data' => $options['consignedOldCode']
		))
		
		->add('deliveryCode', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'mapped' => false,
				'choice_label' => 'label',
				'choices' => $options['codes'],
				'choice_value' => 'id',
				'multiple' => false,
				'data' => $options['deliveryOldCode']
		))
		
		->add('consignedAddressId', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'label',
				'choices' => $options['consignedAddresses'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('readonly' => $options['read_only'])))
		
		->add('deliveryAddressId', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'label',
				'choices' => $options['deliveryAddresses'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('consignedContactId', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'completeInfos',
				'choices' => $options['contacts'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('deliveryContactId', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'completeInfos',
				'choices' => $options['contacts'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('serviceId', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'label',
				'choices' => $options['services'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('contentId', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'label',
				'choices' => $options['contents'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('priorityId', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'label',
				'choices' => $options['priorities'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('shipperId', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'label',
				'choices' => $options['shippers'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('yrOrder', TextType::class, array(
				'attr' => array('readonly' => $options['read_only']),
				'constraints' => array(new Assert\NotBlank())))
				
		->add('dateIssue', TextType::class, array(
				'attr' => array('readonly' => $options['read_only']),
				'constraints' => array(new Assert\NotBlank())))
				
		->add('AWB', TextType::class, array(
				'attr' => array('readonly' => $options['read_only']),
				'constraints' => array(new Assert\NotBlank())))
				
		->add('collect', CheckboxType::class, array(
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('autorityId', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'label',
				'choices' => $options['autorities'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('customStatusId', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'label',
				'choices' => $options['customStatuses'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('incTypeId', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'label',
				'choices' => $options['incTypes'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('incLocId', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'label',
				'choices' => $options['incLocs'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('currencyId', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'label',
				'choices' => $options['currencies'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('imputId', ChoiceType::class, array(
				'constraints' => array(new Assert\NotBlank()),
				'choice_label' => 'label',
				'choices' => $options['imputs'],
				'choice_value' => 'id',
				'multiple' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
				
		->add('nbrPieces', TextType::class, array(
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('weight', TextType::class, array(
				'attr' => array('readonly' => $options['read_only'])))
						
		->add('totalPrice', TextType::class, array(
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('signed', CheckboxType::class, array(
				'attr' => array('readonly' => $options['read_only'])))
						
		->add('printed', CheckboxType::class, array(
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('memo', TextareaType::class, array(
				'attr' => array('readonly' => $options['read_only'])))	

		->add('packings', CollectionType::class, array(
				'entry_type' => PackingType::class,
				'entry_options'  => array(
						'parts_list'  => $options['parts'],
						'packing_types' => $options['packTypes'],
						//'read_only' => $options['read_only'],
						'label' => false
				),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'label' => false,
		));

		if($options['read_only'] === false){
			$builder->add('save', SubmitType::class);
		}
		
		/*
		$formModifierConsigned = function (FormInterface $form, Code $code, AddressDAO $adr) {
		
			$consignedAddresses = null === $code ? array() : $adr->findByCode($code->getId());
				
			$form->add('consignedAddressId', ChoiceType::class, array(
					'constraints' => array(new Assert\NotBlank()),
					'choice_label' => 'label',
					'choice_value' => 'id',
					'choices' => $consignedAddresses,
					'placeholder' => '',
					'multiple' => false,
						
			));
		};
		
		$builder->addEventListener(
				FormEvents::PRE_SET_DATA,
				function (FormEvent $event) use ($formModifierConsigned, $options) {
					$data = $event->getData();
		
					$formModifierConsigned($event->getForm(), $data->getConsignedAddressId()->getCodeId(), $options['address']);
						
				}
		);
		
		
		$builder->get('consignedCode')->addEventListener(
				FormEvents::POST_SUBMIT,
				function (FormEvent $event) use ($formModifierConsigned, $options) {
					$code = $event->getForm()->getData();
					$formModifierConsigned($event->getForm()->getParent(), $code, $options['address']);
				}
		);*/
		
	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => 'PackingSheets\Domain\PackingSheet', 'parts' => null, 'packTypes' => null, 'read_only' => null, 'address' => null, 'status' => null,
				'codes' => null,'consignedAddresses' => null, 'deliveryAddresses' => null, 'contacts' => null, 'services' => null, 'contents' => null, 'priorities' => null, 'shippers' => null,
				'autorities' => null, 'customStatuses' => null, 'incTypes' => null, 'incLocs' => null, 'currencies' => null, 'imputs' => null,
				'deliveryOldCode' =>  null, 'consignedOldCode' => null, 'availableGroups' => null
		))
		->setRequired('address')
		->setAllowedTypes('address', 'PackingSheets\DAO\AddressDAO')
		;
	}

	public function getName() {
		return 'packingSheet';
	}
}


