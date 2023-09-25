<?php
namespace App\Controller\Admin;

//J'appelle les entity pour les liens
use App\Entity\Ebook;
use App\Entity\Image;
use App\Entity\Posts;
use App\Entity\Video;

use App\Entity\Category;
use App\Controller\Admin\UserCrudController;
use App\Entity\Newsletter;
use App\Entity\Page;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

    // private RequestStack $rs;
    // private string $current_role;

    // public function __construct(RequestStack $requestStack, Security $security)
    // {
    //     $this->rs = $requestStack;
    //     $first_role = $security->getUser()->getRoles();
    //     if($this->rs->getSession()->get('_role')==null)
    //         $this->rs->getSession()->set('_role', $first_role);

    //     $this->current_role = $this->rs->getSession()->get('_role');
    // }



    #[Route('/admin', name: 'admin_')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function __invoke(): Response
    {


        if (!$this->isGranted('ROLE_SUPER_ADMIN') && !$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have the required roles to access this page.');
        }


        // // Option 1. You can make your dashboard redirect to some common page of your backend
        // //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('raniderradj2@gmail.com' === $this->getUser()->getRoles()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        $dashboard = Dashboard::new()
            ->setTitle('Ma page Admin');

        // if ($this->current_role === 'ROLE_SUPER_ADMIN') {
        //     $dashboard
        //     ->setTitle('Ma page Super Admin');
        //     // ->setFaviconClass('fa fa-crown'); // Remplacez la classe par une classe CSS pour agrandir le texte
        // }

        return $dashboard;
    }


    public function configureMenuItems(): iterable
    {
        // if ( $this->current_role == 'ROLE_SUPER_ADMIN')
        // {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::section('Activité');
        // yield MenuItem::linkToCrud('Ajouter une photo', 'fas fa-plus', ImageCrudController::class)
        // ->setAction(Crud::PAGE_NEW);

      

        yield MenuItem::section('Livres');
        yield MenuItem::subMenu('Livres Numériques', 'fa-solid fa-book')->setSubItems([
            MenuItem::linkToCrud('Ajouter un Livre ', 'fa fa-pencil-alt',Ebook::class)
            ->setAction(Crud::PAGE_NEW),

            MenuItem::linkToCrud('Mes Livres Numériques', 'fas fa-eye',Ebook::class)
           


           ]);
        //     // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        //     yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section("J'ajoute des éléments");

        yield MenuItem::subMenu('Post', 'fa fa-pencil-alt')->setSubItems([

            MenuItem::linkToCrud('Créer un post', 'fa fa-pencil-alt', Posts::class)
            ->setPermission('ROLE_SUPER_ADMIN'),
            MenuItem::linkToCrud('Mes Posts', 'fas fa-eye', Posts::class)
            ->setPermission('ROLE_SUPER_ADMIN'),

        ]);

        yield MenuItem::subMenu('Page','fa-solid fa-sheet-plastic')->setSubItems([
            MenuItem::linkToCrud('Ajouter une page', 'fas fa-plus', Page::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Mes Pages Configuré', 'fas fa-eye', Page::class),

        ]);

        yield MenuItem::subMenu('Categorie','fa-solid fa-list')->setSubItems([
            MenuItem::linkToCrud('Créer une catégorie', 'fas fa-plus', Category::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Mes catégories', 'fas fa-eye', Category::class),

        ]);

        yield MenuItem::subMenu('Image','fa-regular fa-image')->setSubItems([
            MenuItem::linkToCrud('Ajouter une image', 'fas fa-plus', Image::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Mes Images', 'fas fa-eye', Image::class),

        ]);

        yield MenuItem::subMenu('Vidéos','fa-regular fa-circle-play')->setSubItems([
            MenuItem::linkToCrud('Ajouter une vidéo', 'fas fa-play', Video::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Mes Vidéos', 'fas fa-video', Video::class),

        ]);

        yield MenuItem::subMenu('Newsletter','fa-solid fa-sheet-plastic')->setSubItems([
            MenuItem::linkToCrud('Ajouter une newsletter', 'fas fa-plus', Newsletter::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Mes newsletter', 'fas fa-eye', Newsletter::class),

        ]);



        // yield MenuItem::section('Statistiques');
        // yield MenuItem::linkToUrl('Mes Stats', 'fa fa-chart-bar', '/business');
        //     yield MenuItem::linkToCrud('Blog Posts', 'fa fa-file-text', PostsCrudController::class);

        //     yield MenuItem::section('Users');

        //     yield MenuItem::linkToCrud('Users', 'fa fa-user', UserCrudController::class);
        yield MenuItem::section('Site MeltingPhot');
        yield MenuItem::linkToUrl('MeltingPhot', 'fas fa-home', $this->generateUrl('app_home_page'));
        // }
        // else 
        // {
        // yield MenuItem::section("J'ajoute des éléments");
        // yield MenuItem::linkToCrud('Image', 'fa-regular fa-image', Image::class);
        // yield MenuItem::linkToCrud('Vidéo', 'fa-light fa-video', Video::class);
        // yield MenuItem::linkToCrud('Post', 'fa fa-pencil-alt', Posts::class);

        // yield MenuItem::section('Site MeltingPhot');
        // yield MenuItem::linkToUrl('MeltingPhot', 'fas fa-home', $this->generateUrl('app_home_page'));
    }
}

// }

    // public function configureAssets(): Assets
    // {
    //     return Assets::new()
    //         ->addCssFile('css/custom.css');
    // } -->
