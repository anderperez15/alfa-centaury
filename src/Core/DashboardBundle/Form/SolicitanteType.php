<?php

namespace Core\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;

class SolicitanteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoDoc','entity', array('label'=>'Tipo Documento *','class' => 'CoreDashboardBundle:TipoDoc',
                'choice_label' => 'descripcion',
                'attr'=>array('class'=>'form-control')
            ))
            ->add('documento',null,array('label'=>'Número Documento *','attr'=>array('class'=>'form-control'),'required'=>true))
            ->add('primerNombre',null,array('label'=>'Primer Nombre *','attr'=>array('class'=>'form-control'),'required'=>true))
            ->add('segundoNombre',null,array('attr'=>array('class'=>'form-control'),'required'=>FALSE))
            ->add('primerApellido',null,array('label'=>'Primer Apellido *','attr'=>array('class'=>'form-control'),'required'=>true))
            ->add('segundoApellido',null,array('attr'=>array('class'=>'form-control'),'required'=>FALSE))
            ->add('pais', 'choice', array('label'=>'Pais *',    
           'choices'  => array('c' =>'Colombia'),    
           'choices_as_values' => false,
           'mapped'=>false, 'attr'=>array('class'=>'form-control')
            ))
            ->add('departamento','entity', array('label'=>'Departamento *','class' => 'CoreDashboardBundle:Departamento',
                'choice_label' => 'depNom',
                'attr'=>array('class'=>'form-control'),
                'mapped'=>false
            ))
            ->add('ciudad','entity', array('label'=>'Ciudad *','class' => 'CoreDashboardBundle:Ciudades',
                'choice_label' => 'descripcion',
                'attr'=>array('class'=>'form-control')
            ))
            ->add('direccion',null,array('label'=>'Direccion *','attr'=>array('class'=>'form-control'),'required'=>true))
            ->add('correo','email',array('label'=>'Correo Electronico *','attr'=>array('class'=>'form-control'),'required'=>true))
            ->add('genero','entity', array('label'=>'Genero *','class' => 'CoreDashboardBundle:Genero',
                'choice_label' => 'descripcion',
                'attr'=>array('class'=>'form-control')
            ))
            ->add('edad',null,array('label'=>'Edad *','attr'=>array('class'=>'form-control'),'required'=>true))
//            ->add('poblacion','entity',array('class' => 'CoreDashboardBundle:Poblacion',
//                'choice_label' => 'descripcion',
//                'attr'=>array('class'=>'form-control')))
            ->add('telefono',null,array('label'=>'Telefono *','attr'=>array('class'=>'form-control')))
        ;
	$builder->add('recaptcha', 'ewz_recaptcha', array('label'=>'Verificacion',
        'attr'        => array(
            'options' => array(
                'theme' => 'light',
                'type'  => 'image',
		'language'=>'es'
            )
        ),
        'mapped'      => false,
        'constraints' => array(
            new RecaptchaTrue()
        )
    ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Core\DashboardBundle\Entity\Solicitante'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Core_DashboardBundle_solicitante';
    }
}
