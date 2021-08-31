<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminChangePasswordFormType;
use App\Form\AdminResetPasswordRequestFormType;
use App\Repository\UserRepository;
use App\Service\MailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class AdminResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    private ResetPasswordHelperInterface $resetPasswordHelper;
    private UserPasswordHasherInterface $passwordHasher;
    private UserRepository $userRepository;
    private MailService $mailer;

    public function __construct(
        ResetPasswordHelperInterface $resetPasswordHelper,
        UserPasswordHasherInterface $passwordHasher,
        UserRepository $userRepository,
        MailService $mailer
    ) {
        $this->resetPasswordHelper = $resetPasswordHelper;
        $this->passwordHasher = $passwordHasher;
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }

    public function request(Request $request): Response
    {
        $form = $this->createForm(AdminResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->processSendingPasswordResetEmail($form->get('email')->getData());

            return $this->redirectToRoute('admin_check_email');
        }

        return $this->renderForm('sonata/security/reset_password/request.html.twig', [
            'requestForm' => $form,
        ]);
    }

    public function checkEmail(): Response
    {
        if (null === ($resetToken = $this->getTokenObjectFromSession())) {
            $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
        }

        return $this->render('sonata/security/reset_password/check_email.html.twig', [
            'resetToken' => $resetToken,
        ]);
    }

    public function reset(Request $request, ?string $token = null): Response
    {
        if (null !== $token) {
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('admin_reset_password');
        }

        $token = $this->getTokenFromSession();
        if (null === $token) {
            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
        }

        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
            \assert($user instanceof User);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('reset_password_error', sprintf(
                'There was a problem validating your reset request - %s',
                $e->getReason()
            ));

            return $this->redirectToRoute('admin_forgot_password_request');
        }

        $form = $this->createForm(AdminChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resetPasswordHelper->removeResetRequest($token);

            $this->userRepository->upgradePassword($user, $this->passwordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            ));

            $this->cleanSessionAfterReset();

            return $this->redirectToRoute('sonata_admin_dashboard');
        }

        return $this->render('sonata/security/reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }

    private function processSendingPasswordResetEmail(string $identifier): void
    {
        $user = $this->userRepository->loadUserByIdentifier($identifier);
        \assert(null === $user || $user instanceof User);

        if (null === $user) {
            return;
        }

        $email = $user->getEmail();

        if (null === $email) {
            return;
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $exception) {
            return;
        }

        $this->mailer->send($email, 'security.email.subject', 'sonata/security/email/reset', [
            'userEmail' => $email,
            'resetToken' => $resetToken,
        ]);

        $this->setTokenObjectInSession($resetToken);
    }
}
