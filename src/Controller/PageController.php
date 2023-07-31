<?php


namespace App\Controller;

use App\Entity\Page;
use App\Entity\User;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use App\Repository\EbookRepository;
use App\Repository\ImageRepository;
use App\Repository\PostsRepository;
use App\Repository\VideoRepository;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class PageController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }
    
    #[Route("/{slug}", name :"page_show")]
    public function index(string $slug, EntityManagerInterface $entityManager,AuthenticationUtils $authenticationUtils,
    Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator,EbookRepository $ebookRepository, VideoRepository $videoRepository, ImageRepository $imageRepository, PostsRepository $postRepository, PaginatorInterface $paginator): Response
    {
        $page = $entityManager->getRepository(Page::class)->findOneBy(['slug' => $slug]);

        if ($slug === 'search') {
            $query = $request->get('q');

            $ebooks = $ebookRepository->findByQuery($query);
            $images = $imageRepository->findByQuery($query);
            $posts = $postRepository->findByQuery($query);

            // Fetch video results with video page URLs
            $videoResults = $videoRepository->findByQuery($query);

            // Generate the video page URLs for each video result
            $videoPageUrls = [];
            foreach ($videoResults as $videoResult) {
                $category = str_replace('/', '_', $videoResult->getCategory());
                $url = $videoResult->getId();
                // Obtenez la locale actuelle
                $locale = $request->getLocale();
                $videoPageUrls[] = 'http://127.0.0.1:8000' . $locale . 'actions/' . $category . '/' . $url;        }

            // Concatenate the results in a single array
            $results = array_merge($ebooks, $videoResults, $images, $posts);

            // Paginer les résultats
            $pagination = $paginator->paginate(
                $results, // Requete donnée pour paginer
                $request->query->getInt('page', 1), // Page par défault
                10 // Nombre items par page
            );

            return $this->render('search/search_results.html.twig', [
                'query' => $query,
                'pagination' => $pagination,
                'videoPageUrls' => $videoPageUrls,
            ]);
            return $this->render('search/search_results.html.twig');
            }elseif ($slug === 'login') {
                
                if ($this->getUser()) {
                    return $this->redirectToRoute('app_home_page');
                }
        
                // get the login error if there is one
                $error = $authenticationUtils->getLastAuthenticationError();
        
                // last username entered by the user
                $lastUsername = $authenticationUtils->getLastUsername();
        
                $user = null; // Initialize the $user variable outside the conditional block
        
                if ($request->isMethod('POST')) {
                    $email = $request->request->get('email');
        
                    $user = $entityManager->getRepository(User::class)->findOneBy([
                        'email' => $email,
                    ]);
        
                    if (!$user) {
                        $this->addFlash('danger', 'Utilisateur non trouvé');
                    }
                }
                return $this->render('security/login.html.twig', [
                    'last_username' => $lastUsername,
                    'error' => $error,
                    'user' => $user, // Pass the user variable to the template
                ]);

            }elseif ($slug === 'new-account'){


                $user = new User();

                $form = $this->createForm(RegistrationFormType::class, $user);
                $form->handleRequest($request);
                $errorMessage = '';
        
                if ($form->isSubmitted() && $form->isValid()) {
                    // Check if email already exists
                    $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
                    if ($existingUser) {
                        $errorMessage = 'L\'adresse email existe déjà.';
                        return $this->render('registration/register.html.twig', [
                            'form' => $form->createView(),
                            'errorMessage' => $errorMessage,
                        ]);
                    }
        
                    $user->setPassword(
                        $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('password')->getData()
                        )
                    );
        
                    $user->setRoles(['ROLE_SUPER_ADMIN']);
        
                    $entityManager->persist($user);
                    $entityManager->flush();
        
                    $this->emailVerifier->sendEmailConfirmation(
                        'app_verify_email',
                        $user,
                        (new TemplatedEmail())
                            ->from(new Address('raniderradj2@gmail.com', 'MeltingPhot'))
                            ->to($user->getEmail())
                            ->subject('Please Confirm your Email')
                            ->htmlTemplate('registration/confirmation_email.html.twig')
                    );
        
                    return $userAuthenticator->authenticateUser(
                        $user,
                        $authenticator,
                        $request
                    );
                }
                return $this->render('registration/register.html.twig', [
                    'form' => $form->createView(),
                    'errorMessage' => $errorMessage,
                ]);

            }
        else {

            if (!$page) {
                // Return a 404 Not Found response if the page with the given slug is not found
                return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
            }

        }
        // Render the template for the page with the corresponding content
        return $this->render('page/index.html.twig', [
            'page' => $page,
        ]);
    }
}
