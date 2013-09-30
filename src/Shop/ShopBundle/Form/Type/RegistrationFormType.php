<?php

// src/Shop/ShopBundle/Form/Type/RegistrationFormType.php

namespace Shop\ShopBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('firstName');
        $builder->add('lastName');
        $builder->add('mobile');
        $builder->add('gender', 'choice', array(
            'choices' => array("Male", "Female"),
            'expanded' => true,
            'multiple' => false,
            'required' => true,
            'data' => '0'
        ));
    }

    public function getName() {
        return 'shop_user_registration';
    }

}

