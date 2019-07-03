<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index(ArticlesRepository $articlesRepository)
    {
        $art = $articlesRepository->findAll();
//        dd($art);
        return $this->render('article/index.html.twig', [
            'articles' => $art,
        ]);
    }
}