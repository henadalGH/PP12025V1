<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(private RouterInterface $router) {}

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $roles = $token->getRoleNames();

        if (in_array('ROLE_ADMIN', $roles)) {
            return new RedirectResponse($this->router->generate('administrador'));
        } elseif (in_array('ROLE_CLIENTE', $roles)) {
            return new RedirectResponse($this->router->generate('cliente'));
        } elseif (in_array('ROLE_PELUQUERO', $roles)) {
            return new RedirectResponse($this->router->generate('peluquero_confirmada'));
        }

        return new RedirectResponse($this->router->generate('pagina_principal'));
    }
}
