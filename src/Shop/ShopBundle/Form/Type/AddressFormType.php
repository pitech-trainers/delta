<?php
namespace Shop\ShopBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class AddressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address')
                ->add('city')
                ->add('country')
                ->add('firstname')
                ->add('lastname')
                ->add('email');
    }

    public function getName()
    {
        return 'address_form_type';
    }
}