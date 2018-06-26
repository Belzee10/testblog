<?php

namespace TestBlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'ej: Lorem Ipsum Dolor')))
            ->add('image', FileType::class, array('data_class' => null, 'attr' => array('class' => 'imagenFile')))
            ->add('categories', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Category 1, Category 2')))
            ->add('content', TextareaType::class, array('attr' => array('class' => 'form-control', 'rows' => 10)))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TestBlogBundle\Entity\Article'
        ));
    }
}
