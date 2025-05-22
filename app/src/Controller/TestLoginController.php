<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestLoginController extends AbstractController
{
    #[\Symfony\Component\Routing\Attribute\Route('/test-login', name: 'test_login')]
    public function testLogin(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
    ): Response {
        $message = null;

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $plainPassword = $request->request->get('password');

            $user = $userRepository->findOneBy(['email' => $email]);

            if ($user === null) {
                $message = 'User not found.';
            } elseif ($passwordHasher->isPasswordValid($user, $plainPassword)) {
                $message = 'Login successful! User is authenticated.';
            } else {
                $message = 'Invalid credentials.';
            }
        }

        return $this->render('test_login.html.twig', [
            'message' => $message,
        ]);
    }
}
