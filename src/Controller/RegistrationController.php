<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Symfony\Component\Mime\Address;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private TranslatorInterface $translator;

    public function __construct(EmailVerifier $emailVerifier, TranslatorInterface $translator)    {
        $this->emailVerifier = $emailVerifier;
        $this->translator = $translator;
    }

       #[Route('/new-account', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        AppAuthenticator $authenticator,
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator,
        ValidatorInterface $validator
    ): Response {
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Validate the user entity separately
            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
            if ($existingUser) {
                $errorMessage = $this->translator->trans('This email adress already exists !', [], 'register');
                $form->get('email')->addError(new FormError($errorMessage));
                // Return the form with the error message
                return $this->render('registration/register.html.twig', [
                    'form' => $form->createView(),
                    'errors' => null, // Set errors to null when rendering the form initially
                ]);
            }
            $errors = $validator->validate($user);

            if (count($errors) > 0) {
                // Display validation errors
                foreach ($errors as $error) {
                    $form->addError(new FormError($error->getMessage()));
                }

                return $this->render('registration/register.html.twig', [
                    'form' => $form->createView(),
                    'errors' => $errors,
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
            'errors' => null, // Set errors to null when rendering the form initially
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_home_page');
        }

        $this->addFlash('success', 'Votre Email a bien été vérifiée.');

        return $this->redirectToRoute('app_home_page');
    }



    /**
     * Get the value of translator
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * Set the value of translator
     *
     * @return  self
     */
    public function setTranslator($translator)
    {
        $this->translator = $translator;

        return $this;
    }
}

   // foreach ($form->getErrors(true) as $error) {
            //     dump($error->getMessage());
            // }
            // Check if email already exists
            // $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
            // if ($existingUser) {
            //     $errorMessage = 'L\'adresse email existe déjà.';
            //     return $this->render('registration/register.html.twig', [
            //         'form' => $form->createView(),
            //         'errorMessage' => $errorMessage,
            //     ]);
            // }
