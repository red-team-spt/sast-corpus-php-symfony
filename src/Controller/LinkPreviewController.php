<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class LinkPreviewController extends AbstractController
{
    #[Route('/api/link-preview', name: 'link_preview', methods: ['GET'])]
    public function preview(Request $request): JsonResponse
    {
        $url = $request->query->get('url');
        $html = @file_get_contents($url);
        if ($html === false) {
            return new JsonResponse(['error' => 'unreachable'], 502);
        }
        preg_match('/<title>(.*?)<\/title>/is', $html, $m);

        return new JsonResponse(['title' => $m[1] ?? null]);
    }
}
