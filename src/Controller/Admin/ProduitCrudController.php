<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
           TextField::new('reference'),
           TextField::new('categorie'),
           TextField::new('titre'),
           TextareaField::new('description'),
           TextField::new('prix'),
           Field::new('stock'),
           ImageField::new('photo')
           ->setUploadDir('public/images')
           ->setBasePath('/images')
           ->setFormType(FileUploadType::class) 
        ];
    }
    
}
