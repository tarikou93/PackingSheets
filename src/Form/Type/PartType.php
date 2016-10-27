<?php

namespace PackingSheets\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('pn', TextType::class)
                ->add('serial', TextType::class)
                ->add('desc', TextType::class)
                ->add('price', TextType::class)
                ->add('hscode', TextType::class);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PackingSheets\Domain\Part'
        ));
    }
    
    public function getName()
    {
        return 'part';
    }
}

