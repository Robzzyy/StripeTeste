<?php

namespace App\Controller\Admin;

use App\Entity\Apropos;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AproposCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Apropos::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [

            TextareaField::new('description'),
            DateField::new('date_enregistrement'),
            TextField::new('titre'),
            ArrayField::new('files')
            

            
        ];
    }
    
}
