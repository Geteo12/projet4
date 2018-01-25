<?php

namespace Billetterie\BilletterieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class ClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom' ,TextType::class ,array('label'  => 'Nom', 'attr' => array('class'=>'input-lg')))
                ->add('prenom' ,TextType::class ,array('label'  => 'Prénom', 'attr' => array('class'=>'input-lg')))
                ->add('pays' , CountryType::class, array('attr' => array('class'=>'input-lg')))
                ->add('dateNaissance', DateType::class, array(
                    'widget' => 'single_text',
                    'label'  => 'date de naissance jj/mm/aaaa', 'attr' => array('class'=>'input-lg')
                    ))
                ->add('tarifReduit', CheckboxType::class, array('label' => 'Tarif réduit (sur présentation d\'un justificatif*)', 'required' => false))
                ->add('enregistrer', SubmitType::class, array ('attr' => array('value' => 'submit', 'label' =>'submit')));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Billetterie\BilletterieBundle\Entity\Client'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'billetterie_billetteriebundle_client';
    }


}
