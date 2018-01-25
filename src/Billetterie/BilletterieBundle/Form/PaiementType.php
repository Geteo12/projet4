<?php

namespace Billetterie\BilletterieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PaiementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numCarte', TextType::class, array(
            'label'  => 'Numéro de carte bleue',
            'attr'=> array('class'=>'card-number input-lg')))

            ->add('moisExp', IntegerType::class, array(
                'label'  => 'Date d\'expiration (MM)',
                'attr'=> array('class'=>'card-expiry-month input-lg')))

            ->add('anneeExp', IntegerType::class, array(
                'label'  => 'Année d\'expiration (AA)',
                'attr'=> array('class'=>'card-expiry-year input-lg')))

            ->add('cvc', IntegerType::class, array(
                'label'  => 'CVC',
                'attr'=> array('class'=>'card-cvc input-lg')))

            ->add('token', HiddenType::class, array(
                'attr'=> array('name'=>'token')))

            ->add('payer', SubmitType::class, array(
                'label' => 'Paiement'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Billetterie\BilletterieBundle\Entity\Paiement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'billetterie_billetteriebundle_paiement';
    }


}
