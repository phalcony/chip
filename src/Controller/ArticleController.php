<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ArticleController
 * @package App\Controller
 */
class ArticleController extends AbstractController
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ArticleController constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/articles", name="articles")
     * @param ArticlesRepository $articlesRepository
     *
     * @return Response
     */
    public function index(ArticlesRepository $articlesRepository)
    {
        $articles = [];
        try {
            $articles = $articlesRepository->findAll();

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * Article details
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
        $article = [];
        try {
            $article = $articlesRepository->find($id);

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $this->render('article/articleDetails.html.twig', [
            'article' => $article,
        ]);
    }
}