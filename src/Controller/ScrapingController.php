<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;

class ScrapingController extends AbstractController
{
    /**
     * @Route("/scraping", name="scraping")
     */
    public function index()
    {

        //Todo 1- Recupérer le content html d'une page : https://www.php.net/manual/fr/function.file-get-contents.php
        $html = ''; //TODO ici ton html sera dans cette variable

        //Todo 2- Découvrir le crawl avec Symfony : https://symfony.com/doc/current/components/dom_crawler.html

        $crawler = new Crawler($html);


        //Todo 3- algo de scraping


        //Todo 4- retourne un tableau de ce que tu souhaites garder

        dd("va dans : src/Controller/ScrapingController" , "ici c'est le controller où tu peux surfer sur le scrap");

    }
}
