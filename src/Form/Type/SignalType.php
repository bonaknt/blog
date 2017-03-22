<?php

namespace AlaskaBlog\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SignalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('signalement', TextType::class,array('data' => $_GET['signalement']));
    }

    public function getName()
    {
        return 'signalement';
    }
}
