<?php

namespace App\Controller\Admin;

use App\Entity\Ebook;
use App\Entity\EbookImage;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use FileField;

// use App\Service\PdfImageExtractor;
class EbookCrudController extends AbstractCrudController
{


    public static function getEntityFqcn(): string
    {
        return Ebook::class;
    }




    public function configureFields(string $pageName): iterable
    {
        // yield IdField::new('id')
        //     ->onlyOnIndex();
        yield TextField::new('author', 'Auteur');
        yield TextField::new('title', 'Titre');
        yield TextField::new('description', 'Description');
        yield ImageField::new('imageApercu')
            ->setUploadDir('public/uploads/ebook/apercu')
            ->setBasePath('uploads/ebook/apercu');
        yield ImageField::new('pdf')
            ->setUploadDir('public/uploads/ebook/pdf')
            ->setBasePath('uploads/ebook/pdf');
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {

        $builder = parent::createEditFormBuilder($entityDto, $formOptions, $context);

        $builder
            // ->add("imagesRaw", FileType::class, [
            //     "multiple" => true,
            //     "mapped" => false,
            // ])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                // Your event handling logic here
                // $form = $event->getForm();
                // /**
                //  * @var Ebook
                //  */
                // $entity = $form->getData();
                // $imagesRaw = $form->get("imagesRaw")->getData();

                // $old_images = $entity->getEbookImages();
                // foreach ($old_images as $old_image) {
                //     $entity->removeImage($old_image);
                // }
                // foreach ($imagesRaw as $image) {
                //     $entity->addImage((new EbookImage)->setImageFile($image));
                // }
                // Ajouter un message flash
                $this->addFlash(
                    'success', // Le type du message flash (par exemple, 'success' pour un message de succès)
                    'Les modifications ont été enregistrées avec succès!' // Le message à afficher
                );
            });

        return $builder;
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {

        $builder = parent::createNewFormBuilder($entityDto, $formOptions, $context);

        $builder
            // ->add("imagesRaw", FileType::class, [
            //     "multiple" => true,
            //     "mapped" => false,
            // ])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                // Your event handling logic here
                // $form = $event->getForm();
                // /**
                //  * @var Ebook
                //  */
                // $entity = $form->getData();
                // $imagesRaw = $form->get("imagesRaw")->getData();

                // $old_images = $entity->getEbookImages();
                // foreach ($old_images as $old_image) {
                //     $entity->removeImage($old_image);
                // }
                // foreach ($imagesRaw as $image) {
                //     $entity->addImage((new EbookImage)->setImageFile($image));
                // }
                // Ajouter un message flash
                $this->addFlash(
                    'success', // Le type du message flash (par exemple, 'success' pour un message de succès)
                    'Les modifications ont été enregistrées avec succès!' // Le message à afficher
                );
            });

        return $builder;
    }
}

// solution custom :
// ajoute les img une par une avec ajax et enlever le vichupolader et les 
