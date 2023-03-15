<?php

namespace App\Form;

use App\Filter\CompanyDataFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class CompanyFilterType extends AbstractType
{
    public function __construct(private readonly RouterInterface $router)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('symbol', TextType::class, [
                'label' => 'Company symbol',
                'required' => true,
            ])
            ->add('startDate', DateType::class, [
                'label' => 'Start date',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('endDate', DateType::class, [
                'label' => 'End date',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => CompanyDataFilter::class]);
    }

    public function getBlockPrefix(): string
    {
        return 'company_form';
    }
}
