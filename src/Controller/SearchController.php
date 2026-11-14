<?php

namespace App\Controller;

use App\Service\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'search', methods: ['GET'])]
    public function search(Request $request, ArticleRepository $articles): Response
    {
        $query = (string) $request->query->get('q', '');

        return $this->render('search/results.html.twig', [
            'query' => $query,
            'results' => $articles->searchByTitle($query),
        ]);
    }

    #[Route('/articles', name: 'articles', methods: ['GET'])]
    public function list(Request $request, ArticleRepository $articles): Response
    {
        return $this->render('search/list.html.twig', [
            'articles' => $articles->findPublished(max(1, $request->query->getInt('page', 1))),
        ]);
    }
}
