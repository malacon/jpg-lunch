<?php

namespace JPG\LunchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FamilyType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('schoolID')
            ->add('name')
            ->add('username')
            ->add('password')
            ->add('emails')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JPG\LunchBundle\Entity\Family'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jpg_lunchbundle_family';
    }
}
