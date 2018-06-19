<?php
declare(strict_types=1);


namespace App\Services;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/**
 * Class Flashes
 * @package App\Service
 */
class FlashesService
{

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var Environment
     */
    private $environment;

    private $flashes;

    /**
     * Flashes constructor.
     * @param SessionInterface $session
     * @param Environment $environment
     */
    public function __construct(SessionInterface $session, Environment $environment)
    {
        $this->session      = $session;
        $this->environment  = $environment;
    }

    public function setFlashes($flashes)
    {
        foreach ($flashes as $flash){
            $this->session->getFlashBag()->add(key($flash),$flash[key($flash)]);
        }
        $this->flashes = $flashes;
    }
    
    /**
     * @param $req
     * @return array|object
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function getFlashes($req)
    {
        $flashs = [];
        if(!empty($req)){
            $template = $this->environment->render('flashMessage.html.twig');
            foreach ($req->getSession()->getFlashBag()->all() as $flashesK => $flashesV) {
                foreach ($flashesV as $flashK => $flashV) {
                    $fM = $template;
                    $flashs[] = str_replace(['__type__', '__message__'], [$flashesK, $flashV], $fM);
                }
            }
        }
        return $flashs;
    }

}