<?php

namespace App\Controller\backOffice;

use App\Entity\Newsletter;
use App\Form\Newsletter1Type;
use App\Repository\NewsletterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class NewsletterController extends Controller
{
    /**
     * @Route("/newsletter",name="newsletter_index", methods="GET")
     */
    public function newsletter_index(NewsletterRepository $newsletterRepository): Response
    {
        file_put_contents('emailsNewsLetter.txt', $this->renderView('views/newsletterRender.html.twig',[
            'mails' => $newsletterRepository->findAll()
        ]));
        return $this->render('back-office/newsletter/index.html.twig', [
            'newsletters' => $newsletterRepository->findAll()
        ]);
    }

}
