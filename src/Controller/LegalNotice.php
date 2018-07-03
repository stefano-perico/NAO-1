<?php
/**
 * Created by PhpStorm.
 * User: stefano
 * Date: 03/07/18
 * Time: 21:29
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class LegalNotice extends Controller
{
    /**
     * @Route("/legal_notice", name="legalNotice")
     */
    public function legalNotice(){
        return $this->render('views/legalNotice/mentionsLegales.html.twig');
    }

}