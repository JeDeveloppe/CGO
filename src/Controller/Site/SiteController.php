<?php

namespace App\Controller\Site;

use App\Form\SearchToCalculateType;
use App\Repository\ShopRepository;
use App\Repository\VilleRepository;
use App\Service\CgoService;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/on-line")
 */
class SiteController extends AbstractController
{
     /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function dashboard(Security $security): Response
    {
        $cgo = $security->getUser();

        return $this->render('site/dashboard.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

    /**
     * @Route("/calcul-distance/", name="app_site_calcul_distance")
     */
    public function index(Security $security, Request $request, CgoService $cgoService, ShopRepository $shopRepository): Response
    {
        $cgo = $security->getUser();

        $form = $this->createForm(SearchToCalculateType::class, null, ['cgo' => $cgo]);
        $form->handleRequest($request);

        $datas = [];
        $shops = [];

        if ($form->isSubmitted() && $form->isValid()) {

            $shops = $shopRepository->findBy(['cgo' => $cgo], ['name' => 'ASC']);

            $depannage = $form->get('search')->getData();

            foreach($shops as $shop){

                array_push($datas, $cgoService->getDistancesBeetweenDepannageAndShop($depannage,$shop));

            }

            //on tri le tableau en fonction de la distance la plus courte
            array_multisort(array_column($datas, 'distance'), SORT_ASC, $datas);
        
        }

        return $this->render('site/calcul_distance.html.twig', [
            'controller_name' => 'SiteController',
            'form' => $form->createView(),
            'datas' => $datas,
            'shops' => $shops
        ]);
    }

}
