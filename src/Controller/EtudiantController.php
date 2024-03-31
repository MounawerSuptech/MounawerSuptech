<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'app_etudiant')]
    public function index(): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
        ]);
    }
    //listEtudiant
    #[Route('/listEtudiant', name: 'listEtudiant')]
    public function listEtudiant(ManagerRegistry $registry,Request $request,PaginatorInterface $paginator): Response
    {
        //$etudiants=$registry->getRepository(Etudiant::class)->findAll();
        $etudiants=$paginator->paginate(
            $registry->getRepository(Etudiant::class)->findAll(),
            $request->query->getInt('page',1),
            10
        );
        return $this->render('etudiant/listEtudiant.html.twig',array("tabEtudiant"=>$etudiants));
    }
    // addEtudiant
    #[Route('/addEtudiant', name: 'addEtudiant')]
    public  function addEtudiant(Request $request,ManagerRegistry $doctrine):Response{
        $etudiant=new Etudiant();
        $form=$this->createForm(EtudiantType::class,$etudiant);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //$em=$this->getDoctrine()->getManager();
            $em=$doctrine->getManager();
            $em->persist($etudiant);
            $em->flush();
            return $this->redirectToRoute("listEtudiant");

        }
        return $this->render("etudiant/addEtudiant.html.twig",array('addEtudiant'=>$form->createView()));
    }
    // updateEtudiant
    #[Route('/updateEtudiant/{id}', name: 'updateEtudiant')]
    public function updateEtudiant($id,ManagerRegistry $registry,Request $request):Response{
        $etudiant=$registry->getRepository(Etudiant::class)->find($id);
        $form=$this->createForm(EtudiantType::class,$etudiant);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$registry->getManager();
            $em->flush();
            return $this->redirectToRoute("listEtudiant");
        }
        return $this->render("etudiant/updateEtudiant.html.twig",array("updateEtudiant"=>$form->createView()));
    }
    // deleteEtudiant
    #[Route('/deleteEtudiant/{id}', name: 'deleteEtudiant')]
    public function deleteEtudiant($id,ManagerRegistry $registry):Response{
        $etudiant=$registry->getRepository(Etudiant::class)->find($id);
        $em=$registry->getManager();
        $em->remove($etudiant);
        $em->flush();
        return $this->redirectToRoute("listEtudiant");
    }
}
