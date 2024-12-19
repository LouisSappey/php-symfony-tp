<?php 

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Mailer\MailerInterface;

class AuthController extends AbstractController
{
    #[Route(path: '/login', name: 'page_login')]
    public function login(): Response
    {
        return $this->render('auth/login.html.twig');
    }

    #[Route(path: '/register', name: 'page_register')]
    public function register(): Response
    {
        return $this->render('auth/register.html.twig');
    }

    #[Route(path: '/forgot-password', name: 'page_forgot_password')]
    public function forgotPassword(
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        $email = $request->get('_email');
        
        // Vérification si un email est soumis
        if ($request->isMethod('POST') && !$email) {
            $this->addFlash('error', 'Veuillez fournir une adresse email.');
            return $this->render('auth/forgot.html.twig');
        }
        
        if ($email) {
            $user = $userRepository->findOneBy(['email' => $email]);
            
            // dd($email, $user);
            if (!$user) {
                $this->addFlash('error', 'Aucun utilisateur trouvé avec cette adresse email.');
                return $this->render('auth/forgot.html.twig');
            }
    
            $resetToken = Uuid::v4()->toRfc4122();
            $user->setResetPasswordToken($resetToken);
            $entityManager->persist($user);
            $entityManager->flush();
    
            $emailMessage = (new \Symfony\Bridge\Twig\Mime\TemplatedEmail())
                ->from('contact@streemi.fr')
                ->to($user->getEmail())
                ->subject('Réinitialisation de votre mot de passe')
                ->htmlTemplate('email/reset.html.twig')
                ->context([
                    'resetToken' => $resetToken,
                    'userEmail' => $user->getEmail(),
                    'resetUrl' => $this->generateUrl('page_reset_password', [
                        'token' => $resetToken,
                    ], \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL),
                ]);
    
            try {
                $mailer->send($emailMessage);
                $this->addFlash('success', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
            } catch (\Exception $e) {
                dd($e);
                $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de l\'email.');
            }
    
            return $this->redirectToRoute('page_forgot_password');
        }
    
        // Affiche le formulaire de réinitialisation
        return $this->render('auth/forgot.html.twig');
    }
    
    

    #[Route(path: '/reset-password', name: 'page_reset_password')]
    public function resetPassword(): Response
    {
        return $this->render('auth/reset.html.twig');
    }
}
