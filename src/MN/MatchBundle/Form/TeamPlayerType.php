<?php

namespace MN\MatchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TeamPlayerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('team')
            ->add('player', 'entity', array(
                'class' => 'MNPlayerBundle:Player',
                'multiple' => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MN\MatchBundle\Entity\TeamPlayer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mn_matchbundle_teamplayer';
    }
}
