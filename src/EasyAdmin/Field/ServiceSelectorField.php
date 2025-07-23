<?php

namespace App\EasyAdmin\Field;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

abstract class ServiceSelectorField implements FieldInterface {

    public static function new(string $propertyName, ?string $label = null) : Field {
        return Field::new($propertyName, $label)
            ->setFormType(EntityType::class)
            ->setFormTypeOptions([
                'class' => Service::class,
                'multiple' => true,
                'choice_label' => 'nom'
            ])
            ->onlyOnForms();

    }
}