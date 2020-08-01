<?php

namespace App\Controller;

use App\Controller\FpicountController;
use App\Controller\ObjectManager;
use App\Entity\Adhesion;
use App\Entity\Fpicount;
use App\Form\FpicountType;
use App\Repository\FpicountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fpicount")
 */
class FpicountController extends AbstractController
{
    /**
     * @Route("/", name="fpicount_index", methods={"GET"})
     */
    public function index(FpicountRepository $fpicountRepository): Response
    {
        return $this->render('fpicount/index.html.twig', [
            'fpicounts' => $fpicountRepository->findAll(),
        ]);
    }

    /**
     * @Route("/abonnement", name="fpicount_abonnement", methods={"GET","POST"})
     */
    public function createAbonnement(Request $request) 
    {
        $user = $this->getUser();
        $adhesion = $user->getAdhesion();
        $fpicount = new Fpicount();
        $fpicount ->setRef('abonnement')
                  ->setDescription('paiement en ligne')
                  ->setRemise('0')
                  ->setPUnHt('5')
                  ->setTva(0);
     
        $form= $this->createFormBuilder($fpicount)
        ->add('qte')
        ->getForm();
  
        $form->handleRequest($request);
        $fpicount->setPUnHtRem($fpicount->getPUnHt() - (($fpicount->getPUnHt() / 100) * ($fpicount->getRemise())));
        $fpicount->setPrixTotHt(($fpicount->getPUnHtRem()) * ($fpicount->getQte()));
        $fpicount->setTotalTtc(($fpicount->getPrixTotHt()) + (($fpicount->getPrixTotHt() / 100) * ($fpicount->getTva())));

        $fpicount->setAdhesion($adhesion);
        if($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($fpicount);
                $entityManager->flush();
                return $this->redirectToRoute('Fpicount_show',[
                'id'=>$fpicount->getId()
            ]);
        }
        return $this->render('Fpicount/create.html.twig', [
            'formFpicount' => $form->createView()
        ]);
    }

    /**
     * @Route("/article", name="Fpicount_article", methods={"GET","POST"})
     */
    public function createArticle(Request $request) 
    {
        $fpicount = new Fpicount();
        $form= $this->createFormBuilder($fpicount)
        ->add('ref')
        ->add('pUnHt')
        ->add('qte')
        ->getForm();
  
        $form->handleRequest($request);
        return $this->render('fpicount/create.html.twig', [
            'formFpicount' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/attestation", name="fpicount_attestation")
     */
    public function attestation(FpicountRepository $fpicountRepository):Response
    {
 
        
        $user = $this->getUser();
        $adhesion = $user->getAdhesion();
        $adhesionId = $adhesion->getId();
        $adhesionfirstname = $adhesion->getFirstName();
        $adhesiondateecheancebis = $adhesion->getDateecheancebis();
        $adhesionemail = $adhesion->getEmail();
        $fpicounts = $fpicountRepository->findBy(array(
            'adhesion' => $adhesionId
            ));
        return $this->render('fpicount/attestation.html.twig',[
            'fpicounts' => $fpicounts,
            'adhesionId' => $adhesionId,
            'adhesiondateecheancebis'=>$adhesiondateecheancebis,
            'adhesionfirstname' => $adhesionfirstname,
            'adhesionemail' => $adhesionemail
        ]);
    }

    /**
     * @Route("/new", name="fpicount_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $adhesion = $user->getAdhesion();
        $adhesionId = $user->getAdhesion()->getId();
        
        $fpicount = new Fpicount();
        $fpicount->setAdhesion($adhesion);
        $fpicount->setUser($user);
        $form_fpicount = $this->createForm(FpicountType::class, $fpicount);
        $fpicount->setRef('abonnement');
        
        $form_fpicount->handleRequest($request);
        // on lie la facturette à l'adherent
        $fpicount->setAdhesion($adhesion);

        if ($form_fpicount->isSubmitted() && $form_fpicount->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fpicount);
            $entityManager->flush();
            return $this->redirectToRoute('fpicount_index');
        }

        return $this->render('fpicount/new.html.twig', [
            'adhesion' => $adhesion,
            'fpicount' => $fpicount,
            'form_fpicount' => $form_fpicount->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fpicount_show", methods={"GET"})
     */
    public function show(Fpicount $fpicount): Response
    {
        return $this->render('fpicount/show.html.twig', [
            'fpicount' => $fpicount,
        ]);
    }
    
    /**
     * @Route("/{id}/edit", name="fpicount_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Fpicount $fpicount): Response
    {
        $form = $this->createForm(FpicountType::class, $fpicount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fpicount_index');
        }

        return $this->render('fpicount/edit.html.twig', [
            'fpicount' => $fpicount,
            'form_fpicount' => $form->createView(),

        ]);
    }

    /**
     * @Route("/{id}", name="fpicount_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Fpicount $fpicount): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fpicount->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fpicount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fpicount_index');
    }
    
    public function __toString()
    {
        return (string) $this->getTicket();
    }  
}
