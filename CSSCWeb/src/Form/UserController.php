<?php
/**
 * Created by PhpStorm.
 * User: hojoe
 * Date: 10.01.2018
 * Time: 13:04
 */

namespace Form;

use App\Model;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing;

/*
 * php -S 127.0.0.1:4321 -t public
 * http://localhost:4321/
 */

class UserController
{
    protected $container;
    protected $dbConnection;
    protected $model;
    /* @var $twig \Twig_Environment */
    protected $twig;

    function __construct($container)
    {
        $this->twig = $container['twig'];
        $this->dbConnection = $container['dbConnection'];
        $this->model = new Model($this->dbConnection);
    }


    function logoutAction(Request $request)
    {
        $user = $request->attributes->get('user');
        $user->logout($request);
        return new RedirectResponse('/cases');
    }


    //Show Login Site
    function showLoginAction(Request $request)
    {
        $formData = [];
        $formError = [];
        $valid = false;

        if ($request->getMethod() !== 'POST') {
            $formData = $this->getFormDefaults($request);
            $session = $request->getSession();
            if (!empty($session->get('user'))) {
                $formData['user'] = $session->get('user');
            }
        } else {
            $formData = $request->get('form');
            list($valid, $formError) = $this->isLoginDataValid($request,
                $formData);
        }


        // Handle valid post
        if ($request->getMethod() == 'POST' && $valid && $this->saveFormData($request, $formData)) {

            // Redirect to list
            return new RedirectResponse('/cases');
        }
        // Render form
        $html = $this->twig->render('login.html.twig',
            ['form' => $formData, 'error' => $formError]);

        return new Response($html);
    }



    //Show Register Site
    function showRegisterAction(Request $request)
    {
        $formError = [];
        $valid = false;

        if ($request->getMethod() !== 'POST') {
            $formData = $this->getFormDefaults($request);
            $session = $request->getSession();

            if (!empty($session->get('user'))) {
                $formData['user'] = $session->get('user');
            }
        } else {
            $formData = $request->get('form');
            list($valid, $formError) = $this->isRegisterDataValid($request,
                $formData);
        }// Handle valid post
        if ($request->getMethod() == 'POST' && $valid) {
            $this->saveUserData($request, $formData);
            // Redirect to list
            return new RedirectResponse('/cases');
        }

        // Render form
        $html = $this->twig->render('register.html.twig',
            ['form' => $formData, 'error' => $formError]);
        return new Response($html);
    }



    // Show Account Site
    function showAccountAction(Request $request)
    {
        $formError = [];
        $valid = false;

        if ($request->getMethod() !== 'POST') {
            $formData = $this->getFormDefaults();
        } else {
            $formData = $request->get('form');
            list($valid, $formError) = $this->checkCreditEntry($request,
                $formData);
        }// Handle valid post
        if ($request->getMethod() == 'POST' && $valid) {

            //TODO betreffender account kann noch nicht erfasst werden .. id ? cookie?
            // Add Credit
            //  $this->model->addCredit($formData['username'],$formData['credit']);

            // Redirect to list
            return new RedirectResponse('/account');
        }

        // Render form
        $html = $this->twig->render('account.html.twig',
            ['form' => $formData, 'error' => $formError]);
        return new Response($html);
    }


    function checkCreditEntry($request, $formData)
    {
        $valid = true;
        $formError = [];

        if ($formData['credit'] < 0) {

            $valid = false;

            error_log(print_r("Cannot add negative values", true));
            $formError['username'] = "Cannot add negative values";
        }

        return [$valid, $formError];
    }



    protected function getFormDefaults(Request $request)
    {
        $formData = [];
        $formData['token'] = $this->getToken($request);
        return $formData;
    }


    function createToken()
    {
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes(32));
        } else {
            return bin2hex(openssl_random_pseudo_bytes(32));
        }
    }


    function getToken(Request $request)
    {
        $session = $request->getSession();
        if (empty($session->get('token'))) {
            $session->set('token', $this->createToken());
        }
        $token = $session->get('token');
        return ($token);
    }



    protected function isLoginDataValid(Request $request, $formData)
    {
        $valid = true;
        $formError = [];
        // Check token
        $token = $this->getToken($request);
        if ((!isset($formData['token']))
            || (!hash_equals($token,
                $formData['token']))
        ) {
            $valid = false;
            $formError['token'] = 'Bad token';
            throw new \Exception('Bad CSRF token.');
        }
        // Check data
        if ((!isset($formData['username']))
            || (strlen($formData['username']) == 0)
        ) {
            $valid = false;
            $formError['username']
                = "Bitte geben Sie einen Benutzername ein.";
        }
        if ((!isset($formData['username']))
            || (strlen($formData['username']) < 4)
        ) {
            $valid = false;
            $formError['username']
                = "Der Benutzername muss mindestens 4 Zeichen lang sein.";
        }
        if ((!isset($formData['password']))
            || (strlen($formData['password']) == 0)
        ) {
            $valid = false;
            $formError['username']
                = "Bitte geben Sie eine Passwort ein.";
        }
        if ((!isset($formData['password']))
            || (strlen($formData['password']) < 4)
        ) {
            $valid = false;
            $formError['password'] = "Das Passwort muss mindestens 4 Zeichen lang sein.";
        }
        return [$valid, $formError];
    }

    //Check Register Data
    function isRegisterDataValid($request, $formData)
    {
        $valid = true;
        $formError = [];
        // Check token
        $token = $this->getToken($request);
        if ((!isset($formData['token']))
            || (!hash_equals($token,
                $formData['token']))
        ) {
            $valid = false;
            $formError['token'] = 'Bad token';
            throw new \Exception('Bad CSRF token.');
        }

        // Check data
        if ((!isset($formData['username']))
            || (strlen($formData['username']) == 0)
        ) {
            $valid = false;
            $formError['username']
                = "Bitte geben Sie einen Benutzername ein.";
        }
        if ((!isset($formData['username']))
            || (strlen($formData['username']) < 4)
        ) {
            $valid = false;
            $formError['username']
                = "Der Benutzername muss mindestens 4 Zeichen lang sein.";
        }
        if ((!isset($formData['password']))
            || (strlen($formData['password']) == 0)
        ) {
            $valid = false;
            $formError['username']
                = "Bitte geben Sie eine Passwort ein.";
        }
        if ((!isset($formData['password']))
            || (strlen($formData['password']) < 4)
        ) {
            $valid = false;
            $formError['password'] = "Das Passwort muss mindestens 4 Zeichen lang sein.";
        }
        if ($this->model->isValidUsername($formData['username'])) {

            $valid = false;
            $formError['password'] = "Username is already existing.";
        }
        return [$valid, $formError];

//        $result = $this->dbConnection->query(
//            'SELECT * FROM users');
//        $data = [];
//        foreach ($result as $row) {
//            $data[] = $row;
//
//            if ($row['username'] == $formData['username']) {
//                error_log(print_r("Username already taken", true));
//                $formError['username'] = "Username already taken";
//                $valid = false;
//            }
//        }
//        if ($valid == true) {
//            error_log(print_r("Username available", true));
//        }
//
//        return [$valid, $formError];
    }


    protected function saveFormData(Request $request, $formData)
    {
        // log user in
        $session = $request->getSession();
        if ($this->model->isValidUser($formData['username'], $formData['password'])) {
            $session->set('username', $formData['username']);
            return true;
        } else {
            $session->remove('username');
            return false;
        }
    }


    //Save User Data
    protected function saveUserData($request, $formData)
    {
                   // Prepare data
            $task['username'] = $formData['username'];
            $task['password'] = password_hash($formData['password'], PASSWORD_DEFAULT);

            // Save data
            $this->model->addUser($task);
            }


}