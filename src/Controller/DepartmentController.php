<?php

namespace App\Controller;

use App\Entity\Department;
use App\Form\DepartmentType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends AbstractController
{




    #[Route('/addDepartment', name: 'addDepartment')]
    public  function addDepartment(Request $request,ManagerRegistry $doctrine):Response{
        $department=new Department();
        $form=$this->createForm(DepartmentType::class,$department);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //$em=$this->getDoctrine()->getManager();
            $em=$doctrine->getManager();
            $em->persist($department);
            $em->flush();
            return $this->redirectToRoute("listDepartment");

        }
        return $this->render("department/addDepartment.html.twig",array('addDepartment'=>$form->createView()));
    }

    // listDepartment
    #[Route('/listDepartment', name: 'listDepartment')]
    public function listDepartment(ManagerRegistry $registry,Request $request,PaginatorInterface $paginator):Response{

       // $departments=$registry->getRepository(Department::class)->findAll();
        $departments=$paginator->paginate(
            $registry->getRepository(Department::class)->findAll(),
            $request->query->getInt('page',1),
            10
        );
        return $this->render("department/listDepartment.html.twig",array("tabDepartment"=>$departments));
    }
    // deleteDepartment
    #[Route('/deleteDepartment/{id}', name: 'deleteDepartment')]
    public function deleteDepartment($id,ManagerRegistry $registry):Response{
        $department=$registry->getRepository(Department::class)->find($id);
        $em=$registry->getManager();
        $em->remove($department);
        $em->flush();
        return $this->redirectToRoute("listDepartment");
    }
    // updateDepartment
    #[Route('/updateDepartment/{id}', name: 'updateDepartment')]
    public function updateDepartment($id,ManagerRegistry $registry,Request $request):Response{
        $department=$registry->getRepository(Department::class)->find($id);
        $form=$this->createForm(DepartmentType::class,$department);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$registry->getManager();
            $em->flush();
            return $this->redirectToRoute("listDepartment");
        }
        return $this->render("department/updateDepartment.html.twig",array("updateDepartment"=>$form->createView()));
    }

}
