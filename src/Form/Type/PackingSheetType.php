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
				'constraints' => array(new Assert\NotBlank()),
				'required' => true
		))
				
		->add('consignedCode', ChoiceType::class, array(
				'mapped' => false,
				'choice_label' => 'label',
				'choices' => $options['codes'],
				'choice_value' => 'id',
				'multiple' => false,
				'data' => $options['consignedOldCode'],
				'required' => false
		))
		
		->add('deliveryCode', ChoiceType::class, array(
				'mapped' => false,
				'choice_label' => 'label',
				'choices' => $options['codes'],
				'choice_value' => 'id',
				'multiple' => false,
				'required' => false,
				'data' => $options['deliveryOldCode']
		))
		
		->add('consignedAddressId', ChoiceType::class, array(
				'choice_label' => 'label',
				'choices' => $options['consignedAddresses'],
				'choice_value' => 'id',
				'multiple' => false,
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
		
		->add('deliveryAddressId', ChoiceType::class, array(
				'choice_label' => 'label',
				'choices' => $options['deliveryAddresses'],
				'choice_value' => 'id',
				'multiple' => false,
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('consignedContactId', ChoiceType::class, array(
				'choice_label' => 'completeInfos',
				'choices' => $options['contacts'],
				'choice_value' => 'id',
				'multiple' => false,
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('deliveryContactId', ChoiceType::class, array(
				'choice_label' => 'completeInfos',
				'choices' => $options['contacts'],
				'choice_value' => 'id',
				'multiple' => false,
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('serviceId', ChoiceType::class, array(
				'choice_label' => 'label',
				'choices' => $options['services'],
				'choice_value' => 'id',
				'multiple' => false,
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('contentId', ChoiceType::class, array(
				'choice_label' => 'label',
				'choices' => $options['contents'],
				'choice_value' => 'id',
				'multiple' => false,
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('priorityId', ChoiceType::class, array(
				'choice_label' => 'label',
				'choices' => $options['priorities'],
				'choice_value' => 'id',
				'multiple' => false,
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('shipperId', ChoiceType::class, array(
				'choice_label' => 'label',
				'choices' => $options['shippers'],
				'choice_value' => 'id',
				'multiple' => false,
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('yrOrder', TextType::class, array(
				'attr' => array('readonly' => $options['read_only']),
				'required' => false	
		))
				
		->add('dateIssue', TextType::class, array(
				'attr' => array('readonly' => $options['read_only']),
				'required' => false))
				
		->add('AWB', TextType::class, array(
				'attr' => array('readonly' => $options['read_only']),
				'required' => false
		))
				
		->add('collect', CheckboxType::class, array(
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('autority', TextType::class, array(
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('customStatusId', ChoiceType::class, array(
				'choice_label' => 'label',
				'choices' => $options['customStatuses'],
				'choice_value' => 'id',
				'multiple' => false,
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('incTypeId', ChoiceType::class, array(
				'choice_label' => 'label',
				'choices' => $options['incTypes'],
				'choice_value' => 'id',
				'multiple' => false,
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('incLocId', ChoiceType::class, array(
				'choice_label' => 'label',
				'choices' => $options['incLocs'],
				'choice_value' => 'id',
				'multiple' => false,
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('currencyId', ChoiceType::class, array(
				'choice_label' => 'label',
				'choices' => $options['currencies'],
				'choice_value' => 'id',
				'multiple' => false,
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('imputId', ChoiceType::class, array(
				'choice_label' => 'label',
				'choices' => $options['imputs'],
				'choice_value' => 'id',
				'multiple' => false,
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
				
		->add('nbrPieces', TextType::class, array(
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('weight', TextType::class, array(
				'attr' => array('readonly' => $options['read_only'])))
						
		->add('totalPrice', TextType::class, array(
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('signed', CheckboxType::class, array(
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
						
		->add('printed', CheckboxType::class, array(
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('memo', TextareaType::class, array(
				'required' => false,
				'attr' => array('readonly' => $options['read_only'])))
				
		->add('usualMemos', ChoiceType::class, array(
				'choice_label' => 'label',
				'choices' => $options['memos'],
				'choice_value' => 'id',
				'multiple' => false,
				'mapped' => false,
				'required' => false,
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
		
	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver
		->setDefaults(array('data_class' => 'PackingSheets\Domain\PackingSheet', 'parts' => null, 'packTypes' => null, 'read_only' => null, 'address' => null, 'status' => null,
				'codes' => null,'consignedAddresses' => null, 'deliveryAddresses' => null, 'contacts' => null, 'services' => null, 'contents' => null, 'priorities' => null, 'shippers' => null,
				'customStatuses' => null, 'incTypes' => null, 'incLocs' => null, 'currencies' => null, 'imputs' => null,
				'deliveryOldCode' =>  null, 'consignedOldCode' => null, 'availableGroups' => null, 'memos' => null
		))
		->setRequired('address')
		->setAllowedTypes('address', 'PackingSheets\DAO\AddressDAO')
		;
	}

	public function getName() {
		return 'packingSheet';
	}
}


