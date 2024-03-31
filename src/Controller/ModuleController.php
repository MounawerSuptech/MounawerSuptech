<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    #[Route('/module', name: 'app_module')]
    public function index(): Response
    {
        return $this->render('module/index.html.twig', [
            'controller_name' => 'ModuleController',
        ]);
    }
    //listModule
    #[Route('/listModule', name: 'listModule')]
    public function listModule( ManagerRegistry $registry,Request $request,PaginatorInterface $paginator): Response
    {
       // $modules=$registry->getRepository(Module::class)->findAll();
        $modules=$paginator->paginate(
            $registry->getRepository(Module::class)->findAll(),
            $request->query->getInt('page',1),
            10
        );
        return $this->render('module/listModule.html.twig',array("tabModule"=>$modules));
    }
    // addModule
    #[Route('/addModule', name: 'addModule')]
    public  function addModule(Request $request,ManagerRegistry $doctrine):Response{
        $module=new Module();
        $form=$this->createForm(ModuleType::class,$module);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //$em=$this->getDoctrine()->getManager();
            $em=$doctrine->getManager();
            $em->persist($module);
            $em->flush();
            return $this->redirectToRoute("listModule");

        }
        return $this->render("module/addModule.html.twig",array('addModule'=>$form->createView()));
    }
    // updateModule
    #[Route('/updateModule/{id}', name: 'updateModule')]
    public function updateModule($id,ManagerRegistry $registry,Request $request):Response{
        $module=$registry->getRepository(Module::class)->find($id);
        $form=$this->createForm(ModuleType::class,$module);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$registry->getManager();
            $em->flush();
            return $this->redirectToRoute("listModule");
        }
        return $this->render("module/updateModule.html.twig",array("updateModule"=>$form->createView()));
    }
    // deleteModule
    #[Route('/deleteModule/{id}', name: 'deleteModule')]
    public function deleteModule($id,ManagerRegistry $registry):Response{
        $module=$registry->getRepository(Module::class)->find($id);
        $em=$registry->getManager();
        $em->remove($module);
        $em->flush();
        return $this->redirectToRoute("listModule");
    }
}
