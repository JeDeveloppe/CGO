<?php

namespace App\Controller\Site;

use App\Entity\Cgo;
use App\Form\CgoDepartementType;
use App\Repository\CgoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/on-line/cgo")
 */
class CgoController extends AbstractController
{
    /**
     * @Route("/", name="app_cgo_index", methods={"GET"})
     */
    public function index(CgoRepository $cgoRepository): Response
    {
        return $this->render('site/cgo/index.html.twig', [
            'cgos' => $cgoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/edit", name="app_cgo_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CgoRepository $cgoRepository, Security $security): Response
    {
        $cgo = $security->getUser();
        
        $form = $this->createForm(CgoDepartementType::class, $cgo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cgoRepository->add($cgo, true);

            return $this->redirectToRoute('app_dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('site/cgo/edit.html.twig', [
            'cgo' => $cgo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_cgo_delete", methods={"POST"})
     */
    public function delete(Request $request, Cgo $cgo, CgoRepository $cgoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cgo->getId(), $request->request->get('_token'))) {
            $cgoRepository->remove($cgo, true);
        }

        return $this->redirectToRoute('app_cgo_index', [], Response::HTTP_SEE_OTHER);
    }
}
