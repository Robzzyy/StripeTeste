<?php

namespace App\Controller;

use App\Entity\Apropos;
use App\Form\AproposType;
use App\Repository\AproposRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/apropos')]
class AproposController extends AbstractController
{
    #[Route('/', name: 'app_apropos_index', methods: ['GET'])]
    public function index(AproposRepository $aproposRepository): Response
    {
        return $this->render('apropos/index.html.twig', [
            'apropos' => $aproposRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_apropos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AproposRepository $aproposRepository): Response
    {
        $apropo = new Apropos();
        $form = $this->createForm(AproposType::class, $apropo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aproposRepository->save($apropo, true);

            return $this->redirectToRoute('app_apropos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('apropos/new.html.twig', [
            'apropo' => $apropo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_apropos_show', methods: ['GET'])]
    public function show(Apropos $apropo): Response
    {
        return $this->render('apropos/show.html.twig', [
            'apropo' => $apropo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_apropos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Apropos $apropo, AproposRepository $aproposRepository): Response
    {
        $form = $this->createForm(AproposType::class, $apropo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aproposRepository->save($apropo, true);

            return $this->redirectToRoute('app_apropos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('apropos/edit.html.twig', [
            'apropo' => $apropo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_apropos_delete', methods: ['POST'])]
    public function delete(Request $request, Apropos $apropo, AproposRepository $aproposRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apropo->getId(), $request->request->get('_token'))) {
            $aproposRepository->remove($apropo, true);
        }

        return $this->redirectToRoute('app_apropos_index', [], Response::HTTP_SEE_OTHER);
    }
}
