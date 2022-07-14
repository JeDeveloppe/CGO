<?php

namespace App\Controller;

use App\Form\SearchToCalculateType;
use App\Repository\ShopRepository;
use App\Repository\VilleRepository;
use App\Service\CgoService;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends AbstractController
{
    /**
     * @Route("/calcul-distance/", name="app_site")
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

        }

        return $this->render('site/calcul_distance.html.twig', [
            'controller_name' => 'SiteController',
            'form' => $form->createView(),
            'datas' => $datas,
            'shops' => $shops
        ]);
    }
}
