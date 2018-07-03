<?php
/**
 * Created by PhpStorm.
 * User: stefano
 * Date: 03/07/18
 * Time: 22:31
 */

namespace App\Controller;


use App\Entity\Contact;
use App\Form\ContactType;
use App\Services\FlashesService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, FlashesService $flashesService){
        $contact =  new Contact();
        $contactForm =   $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $request
                ->getSession()
                ->getFlashBag()
                ->add('info', 'Votre message à bien été envoyé, nous vous répondrons sous peu')
            ;
        }

        return $this->render('views/contact/contact.html.twig', [
            'contactForm' => $contactForm->createView(),
            'flashs'      => $flashesService->getFlashes($request)
        ]);
    }

}