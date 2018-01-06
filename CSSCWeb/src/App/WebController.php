<?php
/**
 * Created by PhpStorm.
 * User: aaje7965
 * Date: 14.11.17
 * Time: 18:10
 */

namespace App;

use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

class WebController
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

    function showCasesAction(Request $request)
    {
        $list = $this->model->getBlogPosts();
        $html = $this->twig->render('cases.html.twig',
            ['form' => $list]);
        return new Response($html);
    }

    function showCasesUserAction(Request $request)
    {
        $list = $this->model->getBlogPosts();
        $html = $this->twig->render('casesUser.html.twig',
            ['form' => $list]);
        return new Response($html);
    }

    function ImpressumAction(){
        $html = $this->twig->render('Impressum.html.twig');
        return new Response($html);
    }

    function TimelineAction(){
        $html = $this->twig->render('timeline.html.twig');
        return new Response($html);
    }


}