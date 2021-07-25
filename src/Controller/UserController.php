<?php

namespace App\Controller;

use App\Entity\JeuxUser;
use App\Entity\User;
use App\Form\UserJeuxType;
use App\Form\UserType;
use App\Repository\JeuxRepository;
use App\Repository\JeuxUserRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{

    /**
     * @Route("/user/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/utilisateur/jeux", name="user_jeux")
     */
    public function getJeux(JeuxUserRepository $jeuxUserRepository): Response
    {
        $listeJeux = $jeuxUserRepository->findJeuxByIdUser($this->getUser()->getId());

        return $this->render('jeux_user/liste_jeux.html.twig', [
            'jeux' => $listeJeux
        ]);
    }

    /**
     * @Route("/jeux/add/{id}", name="user_add_jeux", methods={"GET","POST"})
     */
    public function addJeux(Request $request,  JeuxRepository $jeuxRepository): Response
    {

        $jeux = $jeuxRepository->find((int)$request->attributes->all()['id']);
        $userJeux = new JeuxUser();
        $userJeux->setIdJeux($jeux);
        $userJeux->setIdUser($this->getUser());

        $form = $this->createForm(UserJeuxType::class, $userJeux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $userJeux->setNote((int)$form->get('note')->getViewData());
            $entityManager->persist($userJeux);
            $entityManager->flush();

            return $this->redirectToRoute('user_jeux', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jeux_user/add_jeux.html.twig', [
            'form' => $form->createView(),
            'jeu' => $jeux
        ]);
    }

    /**
     * @Route("user/jeux/addliste", name="user_add_liste_jeux", methods={"POST"})
     */
    public function addListeJeux(Request $request,JeuxRepository $jeuxRepository ): Response{
        $jeu = $jeuxRepository->find($request->get('id'));
        $userJeux = new JeuxUser();
        $userJeux->setIdUser($this->getUser());
        $userJeux->setIdJeux($jeu);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($userJeux);
        $entityManager->flush();

        return new Response('ok');
    }
}
