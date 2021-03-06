<?php

namespace MN\PlayerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use MN\UsefulBundle\Form\ImageType;

class PlayerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('nickname')
            ->add('image', new ImageType(), array(
                'required' => false,
                'label' => 'Overwrite Image?'
            ))
            ->add('latitude', 'text', array(
                'required' => false,
                'label' => 'Longitude'
            ))
            ->add('longitude', 'text', array(
                'required' => false,
                'label' => 'Latitude'
            ))
            ->add('bio', 'genemu_tinymce')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MN\PlayerBundle\Entity\Player'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mn_playerbundle_player';
    }
}
