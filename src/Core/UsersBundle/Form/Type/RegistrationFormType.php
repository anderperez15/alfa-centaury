<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\UsersBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName')
                ->add('lastName')
                ->add('tipoDoc','choice', array(
                      'choices'  => array(
                      'Seleccione' => null,
                      'C.C' => 'C.C',
                      'PAS' => 'PAS'
                      ),                   
                      'choices_as_values' => true,
                  ))
                ->add('documento')
                ->add('edad')
                ->add('genero','choice', array(
                      'choices'  => array(
                      'MASCULINO' => 'MASCULINO',
                      'FEMENINO' => 'FEMENINO',
                      ),
                   // *this line is important*
                      'choices_as_values' => true,
                  ))
                ->add('poblacion')
                ->add('telefono')
                ->add('pais','choice', array(
                      'choices'  => array(
                      'COLOMBIA' => 'COLOMBIA',                      
                      ),
                   // *this line is important*
                      'choices_as_values' => true,
                  ))
                ->add('departamento','choice', array(
                      'choices'  => array(
                      'BOYACA' => 'BOYACA',
                      ),
                   // *this line is important*
                      'choices_as_values' => true,
                  ))
                ->add('ciudad')
                ->add('tipoA','choice', array(
                      'choices'  => array(
                      'MASCULINO' => 'Apoderado',
                      'FEMENINO' => 'Representante',
                      ),
                   // *this line is important*
                      'choices_as_values' => true,
                  ))
                 ->add('cedula')
                 ->add('nombreR')
                ->remove('username')
                ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'core_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
