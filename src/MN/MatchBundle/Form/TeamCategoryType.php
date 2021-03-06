<?php

namespace MN\MatchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use MN\UsefulBundle\Form\ImageType;

class TeamCategoryType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('image', new ImageType(), array(
                'required' => false,
                'label' => 'Overwrite Image?'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MN\MatchBundle\Entity\TeamCategory'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mn_matchbundle_teamcategory';
    }
}
