<?php

namespace Billetterie\BilletterieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PanierType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('date', DateType::class, array(
            'widget' => 'single_text', 'label'  => 'date jj/mm/aaaa', 'attr' => array('class'=>'input-lg')))
                 ->add('Type',ChoiceType::class,
                    array('choices' => array(
                        '1'=>'Journée',
                        '2'=>'Demi-journée',
                    'multiple'=>false),
                        'attr' => array('class'=> 'input-lg')))
                 ->add('mail', TextType::class ,array('label'  => 'mail', 'attr' => array('class'=>'input-lg')))
                 ->add('Suivant', SubmitType::class, array('attr' => array('value' => 'submit', 'label' =>'submit')));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Billetterie\BilletterieBundle\Entity\Panier'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'billetterie_billetteriebundle_panier';
    }


}
