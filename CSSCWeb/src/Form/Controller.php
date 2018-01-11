<?php

namespace Form;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Model;


/* Start Server:
php -S 127.0.0.1:4321 -t public
http://localhost:4321/
*/


class Controller
{
    protected $dbConnection;
    protected $twig;
    protected $model;

    function __construct($container)
    {
        $this->dbConnection = $container['dbConnection'];
        $this->twig = $container['twig'];
        $this->model = new Model($this->dbConnection);
    }





//// TODO !! (Form error anzeige?)
////Show Login Site
//    function showLoginAction(Request $request)
//    {
//        $formError = [];
//        $valid = false;
//
//        if ($request->getMethod() !== 'POST') {
//            $formData = $this->getFormDefaults();
//        } else {
//            $formData = $request->get('form');
//            list($valid, $formError) =
//                $this->checkLogIn($request, $formData);
//        }// Handle valid post
//        if ($request->getMethod() == 'POST' && $valid) {
//            // $this->saveFormData($request, $formData);
//            // Redirect to list
//            return new RedirectResponse('/casesUser');
//        }
//
//
//        // Render form
//        $html = $this->twig->render('login.html.twig',
//            ['form' => $formData, 'error' => $formError]);
//        return new Response($html);
//    }


////Show Register Site
//    function showRegisterAction(Request $request)
//    {
//        $formError = [];
//        $valid = false;
//        if ($request->getMethod() !== 'POST') {
//            $formData = $this->getFormDefaults();
//        } else {
//            $formData = $request->get('form');
//            list($valid, $formError) =
//                $this->checkRegister($request, $formData);
//        }// Handle valid post
//        if ($request->getMethod() == 'POST' && $valid) {
//            $this->saveUserData($request, $formData);
//            // Redirect to list
//            return new RedirectResponse('/cases');
//        }
//
//        // Render form
//        $html = $this->twig->render('register.html.twig',
//            ['form' => $formData, 'error' => $formError]);
//        return new Response($html);
//    }

////Account Site
//    function showAccountAction(Request $request)
//    {
//        $formError = [];
//        $valid = false;
//
//        if ($request->getMethod() !== 'POST') {
//            $formData = $this->getFormDefaults();
//        } else {
//            $formData = $request->get('form');
//            list($valid, $formError) =
//
//                $this->checkCreditEntry($request, $formData);
//        }// Handle valid post
//        if ($request->getMethod() == 'POST' && $valid) {
//
//            //TODO betreffender account kann noch nicht erfasst werden .. id ? cookie?
//            // Add Credit
//          //  $this->model->addCredit($formData['username'],$formData['credit']);
//
//            // Redirect to list
//            return new RedirectResponse('/account');
//        }
//
//        // Render form
//        $html = $this->twig->render('account.html.twig',
//            ['form' => $formData, 'error' => $formError]);
//        return new Response($html);
//    }


////Help Methods
////Get Form Defaults
//    protected function getFormDefaults()
//    {
//        // Set defaults
//        $date = new \DateTime('today');
//        $formData['publishDate'] = $date->format('Y-m-d');
//        return $formData;
//    }
//
////Check Form Data
//    protected function isFormDataValid($formData)
//    {
//        $valid = true;
//        $formError = [];
//        // Check data
//        if ((!isset($formData['title'])) ||
//            (strlen($formData['title']) < 3)) {
//            $valid = false;
//            $formError['title'] =
//                "Der Nutzername muss mindestens 3 Zeichen lang sein.";
//        }
//        return [$valid, $formError];
//    }
//
////Check User Data
//    protected function isUserDataValid($formData)
//    {
//        $valid = true;
//        $formError = [];
//        // Check data
//        if ((!isset($formData['title'])) ||
//            (strlen($formData['title']) < 3)) {
//            $valid = false;
//            $formError['title'] =
//                "Der Nutzername muss mindestens 3 Zeichen lang sein.";
//        }
//        return [$valid, $formError];
//    }
//
////Save Form Data
//    protected function saveFormData($request, $formData)
//    {
//        // Prepare data
//        $task['title'] = $formData['title'];
//        $task['blogText'] = $formData['blogText'];
//        $task['publishDate'] = $formData['publishDate'];
//        $task['imageID'] = $formData['imageID'];
//
//        // Save data
//        $this->model->addItem($task);
//    }
//
//    //Save User Data
//    protected function saveUserData($request, $formData)
//    {
//        // Prepare data
//        $task['username'] = $formData['username'];
//        $task['password'] = $formData['password'];
//
//        // Save data
//        $this->model->addUser($task);
//
//    }

//    //Check LogIn Data
//    function checkLogIn($request, $formData)
//    {
//        $valid = false;
//        $formError = [];
//
//        $result = $this->dbConnection->query(
//            'SELECT * FROM users');
//        $data = [];
//        foreach ($result as $row) {
//            $data[] = $row;
//
//            if($row['username'] == $formData['username']){
//                if($row['password'] == $formData['password']){
//                    error_log(print_r("valid account", TRUE));
//                    $valid = true;
//                }
//            }
//        }
//        if($valid == false){
//            error_log(print_r("Account not found", TRUE));
//            $formError['password'] =
//                "Account not found or Wrong Password";
//        }
//
//        return [$valid, $formError];
//    }
//
//    //Check Register Data
//    function checkRegister($request, $formData)
//    {
//        $valid = true;
//        $formError = [];
//
//        $result = $this->dbConnection->query(
//            'SELECT * FROM users');
//        $data = [];
//        foreach ($result as $row) {
//            $data[] = $row;
//
//            if($row['username'] == $formData['username']){
//                    error_log(print_r("Username already taken", TRUE));
//                $formError['username'] = "Username already taken";
//                    $valid = false;
//                }
//            }
//        if($valid == true){
//            error_log(print_r("Username available", TRUE));
//        }
//
//        return [$valid, $formError];
//    }

    //Check Credit Entry
//    function checkCreditEntry($request, $formData)
//    {
//        $valid = true;
//        $formError = [];
//
//        if($formData['credit'] < 0){
//
//            $valid = false;
//
//            error_log(print_r("Cannot add negative values", TRUE));
//            $formError['username'] = "Cannot add negative values";
//        }
//
//        return [$valid, $formError];
//    }
}