<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     * @param ArticlesRepository $articlesRepository
     *
     * @return Response
     */
    public function index(ArticlesRepository $articlesRepository)
    {
        $articles = $articlesRepository->findAll();
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * Artikel-Seite.
     *
     * @Route(
     *     "article/{slug}-{id}.html",
     *     defaults={"slug": "", "id": ""},
     *     requirements={
     *          "slug": "[a-z0-9\-]*",
     *          "id": "\d+",
     *      },
     *     name = "article_details"
     * )
     * @param                    $id
     * @param ArticlesRepository $articlesRepository
     *
     * @return Response
     */
    public function indexAction($id, ArticlesRepository $articlesRepository, TranslatorInterface $translator)
    {
        try {
            $test = $translator->trans('given_name_required');
            $article = $articlesRepository->find($id);

        } catch (\HttpResponseException $e) {
//            if (404 == $e->getCode()) {
//                throw new NotFoundHttpException(null, null, 1486716273);
//            } else {
//                throw $e;
//            }
        }

        return $this->render('article/articleDetails.html.twig', [
            'article' => $article,
            'test' => $test,
        ]);
    }
}