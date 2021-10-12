<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app")
     */
    public function index(SerializerInterface $serializer): Response
    {
        return $this->render('base.html.twig', [
            'user' => $serializer->serialize($this->getUser(), 'jsonld'),
        ]);
    }
}
