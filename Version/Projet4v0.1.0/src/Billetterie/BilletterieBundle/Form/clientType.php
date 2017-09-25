<?php

namespace Billetterie\BilletterieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class clientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom' ,TextType::class ,array('label'  => 'Nom'))
                ->add('prenom' ,TextType::class ,array('label'  => 'Prénom'))
                ->add('pays' , CountryType::class)
                ->add('dateNaissance', BirthdayType::class, array(
                    'widget' => 'single_text'))
                ->add('tarifReduit', CheckboxType::class, array('label' => 'Tarif réduit (sur présentation d\'un justificatif*)', 'required' => false))
                ->add('enregistrer', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Billetterie\BilletterieBundle\Entity\client'
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
