<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Form\JeuxType;
use App\Repository\JeuxRepository;
use App\Repository\JeuxUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/jeux")
 */
class JeuxController extends AbstractController
{
    /**
     * @Route("/", name="jeux_index", methods={"GET"})
     */
    public function index(JeuxRepository $jeuxRepository): Response
    {
        return $this->render('jeux/index.html.twig', [
            'jeuxes' => $jeuxRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="jeux_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $jeux = new Jeux();
        $form = $this->createForm(JeuxType::class, $jeux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jeux);
            $entityManager->flush();

            return $this->redirectToRoute('jeux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('jeux/new.html.twig', [
            'jeux' => $jeux,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="jeux_show", methods={"GET"})
     */
    public function show(Jeux $jeux, JeuxUserRepository $jeuxUserRepository): Response
    {
        $jeuxUser = $jeuxUserRepository->findBy(['id_jeux' => $jeux->getId()]);
        if($jeuxUser){
            $sommeNote = 0;
            $nbNote = 0;
            foreach ( $jeuxUser as $unJeux){
                if(!is_null($unJeux->getNote())){
                    $sommeNote += (int)$unJeux->getNote();
                    $nbNote++;
                }
            }
        }
        $moyenne = $nbNote =! 0 ? $sommeNote / $nbNote : 0;

        return $this->render('jeux/show.html.twig', [
            'jeux' => $jeux,
            'note' => $moyenne ?? "non noté"
        ]);
    }

    /**
     * @Route("/{id}/edit", name="jeux_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Jeux $jeux
     * @return Response
     */
    public function edit(Request $request, Jeux $jeux): Response
    {
        $form = $this->createForm(JeuxType::class, $jeux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jeux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('jeux/edit.html.twig', [
            'jeux' => $jeux,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="jeux_delete", methods={"POST"})
     */
    public function delete(Request $request, Jeux $jeux): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jeux->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jeux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('jeux_index', [], Response::HTTP_SEE_OTHER);
    }
}
