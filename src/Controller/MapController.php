<?php

namespace App\Controller;


use App\Entity\Observation;
use App\Repository\ObservationRepository;
use App\Repository\TaxrefRepository;
use App\Repository\UserRepository;
use App\Services\FlashesService;
use App\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MapController
 * @package App\Controller
 * @Route("/carte")
 */
class MapController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var FlashesService
     */
    private $flashesService;

    public function __construct(UserService $userService, FlashesService $flashesService)
    {
        $this->userService = $userService;
        $this->flashesService = $flashesService;
    }

    /**
     * @Route("/index", name="observation")
     */
    public function observation(TaxrefRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $q = $request->query->get('q');
        $queryBuilder = $repository->getSpeciesObsWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('views/map/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/{id}", name="find")
     */
    public function find(EntityManagerInterface $em, UserRepository $userRepository, Request $request, $id)
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $repository = $em->getRepository(Observation::class);
        $obs = $repository->findBy([
            'species' => $id
        ]);

        if ($request->getSession()->get('user')){
            $user = $userRepository->find($request->getSession()->get('user'));
            $userRole = $user->getRole();
        }else{
            $userRole = null;
        }

        return $this->render('views/map/find.html.twig', [
            'obs' => $obs,
            'user' => $userRole
        ]);
    }

}