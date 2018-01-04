<?php

namespace Form;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Model;

class Controller
{
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

    function showFormAction(Request $request)
    {
        $formError = [];
        $valid = false;
        if ($request->getMethod() !== 'POST') {
            $formData = $this->getFormDefaults();
        } else {
            $formData = $request->get('form');
            list($valid, $formError) =
                $this->isFormDataValid($request, $formData);
        }// Handle valid post
        if ($request->getMethod() == 'POST' && $valid) {
            $this->saveFormData($request, $formData);
            // Redirect to list
            return new RedirectResponse('/');
        }
        // Render form
        $html = $this->twig->render('form.html.twig',
            ['form' => $formData, 'error' => $formError]);
        return new Response($html);
    }

    protected function getFormDefaults()
    {
        // Set defaults
        $date = new \DateTime('today');
        $formData['publishDate'] = $date->format('Y-m-d');
        return $formData;
    }

    protected function isFormDataValid($request, $formData)
    {
        $valid = true;
        $formError = [];
        // Check data
        if ((!isset($formData['title'])) ||
            (strlen($formData['title']) < 3)) {
            $valid = false;
            $formError['title'] =
                "Der Titel muss mindestens 3 Zeichen lang sein.";
        }
        return [$valid, $formError];
    }

    protected function saveFormData($request, $formData)
    {
        // Prepare data
        $task['title'] = $formData['title'];
        $task['blogText'] = $formData['blogText'];
        $task['publishDate'] = $formData['publishDate'];
        $task['imageID'] = $formData['imageID'];

        // Save data
        $this->model->addItem($task);
    }
}