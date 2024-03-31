<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClasseController extends AbstractController
{



    #[Route('/classe', name: 'app_classe')]
    public function index(): Response
    {
        return $this->render('classe/index.html.twig', [
            'controller_name' => 'ClasseController',
        ]);
    }
    //listClasse
    #[Route('/listClasse', name: 'listClasse')]
    public function listClasse(ManagerRegistry $registry,Request $request,PaginatorInterface $paginator): Response
    {
        //$classes=$registry->getRepository(Classe::class)->findAll();
        $classes=$paginator->paginate(
            $registry->getRepository(Classe::class)->findAll(),
            $request->query->getInt('page',1),
            10
        );

        return $this->render('classe/listClasse.html.twig',array("tabClasse"=>$classes));
    }
    // addClasse
    #[Route('/addClasse', name: 'addClasse')]
    public function addClasse(Request $request,ManagerRegistry $registry): Response
    {
        $classe=new Classe();
        $form=$this->createForm(ClasseType::class,$classe);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$registry->getManager();
            $em->persist($classe);
            $em->flush();
            return $this->redirectToRoute("listClasse");
        }
        return $this->render("classe/addClasse.html.twig",array('addClasse'=>$form->createView()));

    }
    // updateClasse
    #[Route('/updateClasse/{id}', name: 'updateClasse')]
    public function updateClasse(Request $request,ManagerRegistry $registry,$id): Response
    {
        $classe=$registry->getRepository(Classe::class)->find($id);
        $form=$this->createForm(ClasseType::class,$classe);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$registry->getManager();
            $em->persist($classe);
            $em->flush();
            return $this->redirectToRoute("listClasse");
        }
        return $this->render("classe/updateClasse.html.twig",array('updateClasse'=>$form->createView()));

    }
    // deleteClasse
    #[Route('/deleteClasse/{id}', name: 'deleteClasse')]
    public function deleteClasse(ManagerRegistry $registry,$id): Response
    {
        $classe=$registry->getRepository(Classe::class)->find($id);
        $em=$registry->getManager();
        $em->remove($classe);
        $em->flush();
        return $this->redirectToRoute("listClasse");
    }


}
