<?php

namespace App\Controller;

use App\Entity\Cgo;
use App\Form\CgoType;
use App\Repository\CgoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/cgo")
 */
class CgoController extends AbstractController
{
    /**
     * @Route("/", name="app_cgo_index", methods={"GET"})
     */
    public function index(CgoRepository $cgoRepository): Response
    {
        return $this->render('cgo/index.html.twig', [
            'cgos' => $cgoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_cgo_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CgoRepository $cgoRepository): Response
    {
        $cgo = new Cgo();
        $form = $this->createForm(CgoType::class, $cgo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cgoRepository->add($cgo, true);

            return $this->redirectToRoute('app_cgo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cgo/new.html.twig', [
            'cgo' => $cgo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/edit", name="app_cgo_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CgoRepository $cgoRepository, Security $security): Response
    {
        $cgo = $security->getUser();
        
        $form = $this->createForm(CgoType::class, $cgo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cgoRepository->add($cgo, true);

            return $this->redirectToRoute('app_cgo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cgo/edit.html.twig', [
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
