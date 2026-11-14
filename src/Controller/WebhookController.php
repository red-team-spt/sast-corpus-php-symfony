<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WebhookController extends AbstractController
{
    public function __construct(private string $webhookSecret)
    {
    }

    #[Route('/webhook/publish', name: 'webhook_publish', methods: ['POST'])]
    public function publish(Request $request): Response
    {
        $expected = hash_hmac('sha256', $request->getContent(), $this->webhookSecret);
        if (!hash_equals($expected, (string) $request->headers->get('X-Signature'))) {
            return new Response('invalid signature', 401);
        }

        return new Response('', 204);
    }
}
