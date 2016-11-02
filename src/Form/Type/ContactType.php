<?php

namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('code_id', ChoiceType::class, array(
        'constraints' => array(new Assert\NotBlank()),
        'mapped' => false,
        'choice_label' => 'label',
        'choices' => $options['codes'],
        'choice_value' => 'id'))
                
                ->add('address_id', ChoiceType::class, array(
        'constraints' => array(new Assert\NotBlank())))
                
                ->add('name', TextType::class, array(
        'constraints' => array(new Assert\NotBlank())))
                
                ->add('mail', EmailType::class, array(
        'constraints' => array(new Assert\NotBlank())))
                
                ->add('phoneNr', TextType::class, array(
        'constraints' => array(new Assert\NotBlank())))
                
                ->add('faxNr', TextType::class, array(
                    'required' => false))
                ->get('address_id')->resetViewTransformers();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            //->setDefault('codes', null)
            ->setDefaults(array('data_class' => 'PackingSheets\Domain\Contact'))
            ->setRequired('codes')
            ->setAllowedTypes('codes', array('array'))
        ;
    }
    
    public function getName()
    {
        return 'contact';
    }
    
}

