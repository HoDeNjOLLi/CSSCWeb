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




//    function artistAction(Request $request)
//    {
//        if ($request->attributes->get('id') != null) {
//            return new Response($html = $this->twig->render('artists.html.twig',
//                ['artists' => $this->model->getArtist($request->get('id'))]));
//        } else {
//            return new Response($this->twig->render('artists.html.twig',
//                ['artists' => $this->model->getArtists()]));
//        }
//    }
//
//    function albumAction(Request $request)
//    {
//        if ($request->attributes->get('id') != null) {
//            return new Response($html = $this->twig->render('albums.html.twig',
//                ['albums' => $this->model->getAlbum($request->get('id'))]));
//        } else {
//            return new Response($this->twig->render('albums.html.twig',
//                ['albums' => $this->model->getAlbums()]));
//        }
//
//
//    }
//
//    function genreAction(Request $request)
//    {
//        if ($request->attributes->get('id') != null) {
//            return new Response($html = $this->twig->render('genres.html.twig',
//                ['genres' => $this->model->getGenre($request->get('id'))]));
//        } else {
//            return new Response($this->twig->render('genres.html.twig',
//                ['genres' => $this->model->getGenres()]));
//        }
//
//    }
//
//    function listAction(Request $request)
//    {
//        $html = $this->twig->render('list.html.twig',
//            ['list' => $this->model->getList()]);
//        return new Response($html);
//    }

    /*    function artistsAction() {
            $html = $this->twig->render('artists.html.twig', ['artists' => $this->model->getArtists()]);

            return new Response($html);

        }*/

    /*    function albumsAction() {
            $html = $this->twig->render('albums.html.twig',['albums' => $this->model->getAlbums()]);
            return new Response($html);
        }*/

    /*    function genresAction() {
            $html = $this->twig->render('genres.html.twig', ['genres' => $this->model->getGenres()]);
            return new Response($html);
        }*/

}