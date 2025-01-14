<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

use Symfony\Component\HttpFoundation\RedirectResponse;//for RedirectResponse

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        #redirect already logged in user
        $securityContext = $this->container->get('security.context');
        $router = $this->container->get('router');

        if ($securityContext->isGranted('ROLE_ADMIN')) {
            //does not come flashbag message here

            return new RedirectResponse($router->generate('age'), 307);
        } 

        /*if ($securityContext->isGranted('ROLE_USER')) {
            return new RedirectResponse($router->generate('user_home'), 307);
        }*/
        #redirect ends

        
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        if (class_exists('\Symfony\Component\Security\Core\Security')) {
            $authErrorKey = Security::AUTHENTICATION_ERROR;
            $lastUsernameKey = Security::LAST_USERNAME;
        } else {
            // BC for SF < 2.6
            $authErrorKey = SecurityContextInterface::AUTHENTICATION_ERROR;
            $lastUsernameKey = SecurityContextInterface::LAST_USERNAME;
        }

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
            //message

            //Flash Bag doesn't come
            
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);

            //Flash Bag if username and password didn't match
            $this->get('session')->getFlashBag()->add('error', 'Username and password did not match. Please try again.');
        } else {
            $error = null;

            //Flashbag comes each time you visit /login page
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.

            //flashbag message comes each time you visit /login page
        } else {
            //Flashbag doesnot work here
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        if ($this->has('security.csrf.token_manager')) {
            $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
        } else {
            // BC for SF < 2.4
            $csrfToken = $this->has('form.csrf_provider')
                ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate')
                : null;
        }

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ));
    }

    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderLogin(array $data)
    {
        //log out: disabled log out message for the person visiting login page for the first time
        //using php cookie
        //since session is not set at the first time and as well as after log out
        if(!isset($_COOKIE['firstvisit'])) {
            setcookie('firstvisit', time()); //set a cookie containing the timestamp of when this user first visited the page
        }
        else {
            //it's not their first visit because the cookie already exists            
            if(!isset($_SESSION["login_success"])) {//session get destroy after log out
                $this->get('session')->getFlashBag()->add('success', 'You have successfully log out!');
                $_SESSION["login_success"] = "3";//for already shown logout message
            }
        }

        return $this->render('FOSUserBundle:Security:login.html.twig', $data);
    }

    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    public function logoutAction()
    {
        $_SESSION["login_success"] = "0";
        //exit(0);
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}
