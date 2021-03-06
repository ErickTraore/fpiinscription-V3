<?php

namespace App\Controller;
// Danger: activation sms ligne 98 Empêche le deployement.

use App\Controller\AdhesionController;
use App\Controller\FpicountController;
use App\Controller\ImageController;
use App\Controller\UserController;
use App\Entity\Adhesion;
use App\Entity\Fpicount;
use App\Entity\Image;
use App\Entity\Upload;
use App\Entity\User;
use App\Form\AdhesionType;
use App\Form\FpicountType;
use App\Form\ImageType;
use App\Form\UploadType;
use App\Repository\AdhesionRepository;
use App\Repository\FpicountRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface ;
use Symfony\Component\Filesystem\Filesystem ;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\UploadedImage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @Route("/adhesion")
 */
class AdhesionController extends AbstractController
{
    /**
     * @var AdhesionRepository
     */
    private $repository;
    
    /** 
     * @var EntityManagerInterface $em 
    */
    private $em;
    
    public function __construct(AdhesionRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    /**
     * @Route("/", name="adhesion_index", methods={"GET"})
     */
    public function index(AdhesionRepository $adhesionRepository): Response
    {
        return $this->render('adhesion/index.html.twig', [
            'adhesions' => $adhesionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="adhesion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user=$this->getUser();
        $adhesion = $user->getAdhesion();
        $userName = $user->getUsername();
        // $adhesionId = $adhesion->getId();
        $adhesionId = $user->getAdhesion() ? $user->getAdhesion()->getId() : null;
        
        if($adhesionId){
            return $this->render('adhesion/stopDemande.html.twig');
         }
        // $adhesionId = $user->getAdhesion()->getId(); 
       
        $adhesion = new Adhesion();
        $form = $this->createForm(AdhesionType::class, $adhesion);
        $form->handleRequest($request);

        if ($form->isSubmitted() 
        // && $form->isValid()
        ) {
            if ($form->get('Annuler')->isClicked()) {
                return $this->redirectToRoute('home');
            }
            
                if ($user->getUsername() == '0033778351871') {
                    // $user->setRoles(array('ROLE_ADMIN'));
                    $user->setRoles(array('ROLE_SUPER_ADMIN'));
                    // $user->setRoles(array('ROLE_MANAGER_LYON'));
                    // $user->setRoles(array('ROLE_TECHNIQUE'));
                }
                else {
                    $user->setRoles(array('ROLE_ADHERENT'));
                }   
            // $user->setRoles(array('ROLE_MANAGER_LYON'));
            $user->setAdhesion($adhesion);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($adhesion);
            $entityManager->persist($user);
            $entityManager->flush();
            
         //   $smsok = false;
            $smsok = true;
            if ($smsok) {
                // return $this->render('adhesion/bravoAdherent.html.twig');
                $message_inscription=" Votre statut change. Maintenant vous etes un ADHERENT. votre n° est: FPIAD-" .$user->getAdhesion()->getId(). " Le Pr,  K.L. Gbagbo vous remercie de votre confiance. ";
            
                return $this->redirectToRoute('envoiesms_adherent', [
                'number_phone'  => $userName,
                'message_phone' => $message_inscription,
                'Controller_name' => 'EnvoiesmsController',
            ]);
            }
            return $this->redirectToRoute('home');
            }
            return $this->render('adhesion/new.html.twig', [
            'adhesion' => $adhesion,
            'form' => $form->createView(),
        ]);
       
        }

    /**
     * @Route("/edituser",name="adhesion_edituser", methods={"GET","POST"})
     * @param Request            $request
     * @param AdhesionRepository $repository
     * @return Response
     */
    public function form(Request $request, AdhesionRepository $adhesionRepository)
    {
        $user=$this->getUser();
        $adhesionId=$user->getAdhesion() ? $user->getAdhesion()->getId() : null;
        if (!$adhesionId) {
            return $this->render('adhesion/echecmajAdherent.html.twig');
        }
        $adhesion = $user->getAdhesion();
        $form = $this->createForm(AdhesionType::class, $adhesion);
        $form->handleRequest($request);
        // $adhesions = $adhesionRepository->findAll();
       
        if ($form->isSubmitted()
        // && $form->isValid()
        ) {
            if ($form->get('Annuler')->isClicked()) {
                return $this->redirectToRoute('home');
            }
            $user->setAdhesion($adhesion);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->render('adhesion/majOkAdherent.html.twig');
        }
        return $this->render(
            'adhesion/edituser.html.twig',
            [
                'user' => $user,
                'adhesion' => $adhesion,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="adhesion_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Adhesion $adhesion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adhesion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adhesion);
            $entityManager->flush();
        }
        return $this->redirectToRoute('adhesion_index');
    }
    
    /**
       *
       * @Route("/maj/{adhesionId}/{nbremois}/{amountdeux}", name="adhesion_maj")
       * @param Request            $request
       * @param AdhesionRepository $repository
       * @return Response
       */
      public function maj(Request $request, $adhesionId, $nbremois, $amountdeux):Response 
      {
        $user = $this->getUser();
        $description = 'paiement en ligne';
        $ref = 'abonnement';
        $duree = $nbremois;
        
        $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository(Adhesion::class);
        $adhesion = $this->repository->find($adhesionId);
        $echeance = $adhesion->getDateecheancebis();
        $dateDepart = $echeance;
        $dateDepart->modify('+'.$duree.'months');
        $adhesion->setDateecheancebis(new \DateTime($dateDepart->format('Y-m-d H:i:s.u')));
        $fpicount = new Fpicount();
        $fpicount->setAdhesion($adhesion);
        $fpicount->setUser($user);
            $fpicount->setRef($ref);
            $fpicount->setDescription($description);
            $fpicount->setTotalTtc($amountdeux);
            $fpicount->setDate_Echeance(new \DateTime($dateDepart->format('Y-m-d H:i:s.u')));

        $em = $this->getDoctrine()->getManager();
        $em->persist($fpicount);
        $em->flush();
        if (! $adhesion) 
        {
            return new Response('cette opération d\'ajout a réussie mais echec des données');
        } 
            // return new Response('cette maj échéance a bien réussie');
            return $this->redirectToRoute('home');
            
      }

      /**
       *
       * @Route("/maj_abonnement/{adhesionId}/{amountdeux}", name="adhesion_maj_abonnement")
       * @param Request            $request
       * @param AdhesionRepository $repository
       * @return Response
       */
      public function maj_abonnement(Request $request, $adhesionId, $amountdeux):Response 
      {
        $description = 'paiement en ligne';
        $ref = 'don';
            $user = $this->getUser();
            $adhesion = $user->getAdhesion();
        $fpicount = new Fpicount();
            $fpicount->setAdhesion($adhesion);
        //    $form_fpicount = $this->createForm(FpicountType::class, $fpicount);
            $fpicount->setRef($ref);
            $fpicount->setDescription($description);
        //   $form_fpicount->handleRequest($request);
            $fpicount->setTotalTtc($amountdeux);
        //  $fpicount->setDate_Echeance(new \DateTime($dateDepart->format('Y-m-d H:i:s.u')));

        $em = $this->getDoctrine()->getManager();
        $em->persist($fpicount);
        $em->flush();
        if (! $adhesion) 
        {
            return new Response('cette opération de paiement a réussie mais echec des données');
        } 
           // return new Response('cette maj don échéance a bien réussie');
            return $this->redirectToRoute('home');
      }

            /**
       *
       * @Route("/maj_inondation/{adhesionId}/{amountdeux}", name="adhesion_maj_inondation")
       * @param Request            $request
       * @param AdhesionRepository $repository
       * @return Response
       */
      public function maj_inondation(Request $request, $adhesionId, $amountdeux):Response 
      {
        $description = 'paiement en ligne';
        $ref = 'inondation';
            $user = $this->getUser();
            $adhesion = $user->getAdhesion();
        $fpicount = new Fpicount();
            $fpicount->setAdhesion($adhesion);
        //    $form_fpicount = $this->createForm(FpicountType::class, $fpicount);
            $fpicount->setRef($ref);
            $fpicount->setDescription($description);
        //   $form_fpicount->handleRequest($request);
            $fpicount->setTotalTtc($amountdeux);
        //  $fpicount->setDate_Echeance(new \DateTime($dateDepart->format('Y-m-d H:i:s.u')));

        $em = $this->getDoctrine()->getManager();
        $em->persist($count);
        $em->flush();
        if (! $adhesion) 
        {
            return new Response('cette opération de paiement a réussie mais echec des données');
        } 
           // return new Response('cette maj don échéance a bien réussie');
            return $this->redirectToRoute('home');
      }

       /**
       *
       * @Route("/maj_carte/{adhesionId}/{amountdeux}/{ref}", name="adhesion_maj_carte")
       * @param Request            $request
       * @param AdhesionRepository $repository
       * @return Response
       */
      public function maj_carte(Request $request, $adhesionId, $amountdeux, $ref):Response 
      {
        $user = $this->getUser();
        $description = 'paiement en ligne';
        $ref = 'carte_2020';
        $adhesion = $user->getAdhesion();
        $fpicount = new Fpicount();
        $fpicount->setAdhesion($adhesion);
        $fpicount->setUser($user);
        $fpicount->setRef($ref);
        $fpicount->setDescription($description);
        $fpicount->setTotalTtc($amountdeux);
        

        $em = $this->getDoctrine()->getManager();
        $em->persist($fpicount);
        $em->flush();
        if (! $adhesion) 
        {
            return new Response('cette opération de paiement a réussie mais echec des données');
        } 
            return $this->redirectToRoute('home');
      }

      /**
       * @Route("/viewUpload", name="adhesion_viewUpload", methods={"GET","POST"})
       */
      public function viewUpload(Request $request, ImageRepository $repository)
      {
            $user = $this->getUser();
            $adhesion = $user->getAdhesion();
            $image = $adhesion->getImage();
            $imageId=$adhesion->getImage() ? $adhesion->getImage()->getId() : null;
            if(!$imageId)
            {
            return $this->render('images/echec_vue_image.html.twig');
                
            }
            $imageimagename = $image->getImageName();
           // $data = base64_encode($imageFile);

            return $this->render('images/testimage.html.twig',[
                'im' => $imageimagename,
            ]);
      }

      /**
       * @Route("/impression", name="adhesion_impression", methods={"GET","POST"})
       */
      public function impression(Request $request, ImageRepository $repository)
      {
            $user = $this->getUser();
            $adhesion = $user->getAdhesion();
            $image = $adhesion->getImage();
            $imageId=$adhesion->getImage() ? $adhesion->getImage()->getId() : null;
            if(!$imageId)
            {
            return $this->render('images/echec_vue_image.html.twig');
                
            }
            $imageimagename = $image->getImageName();
           // $data = base64_encode($imageFile);

            return $this->render('images/impression.html.twig',[
                'im' => $imageimagename,
                'user' => $this->getUser(),
                'adhesion' => $adhesion,
            ]);
      }

      /**
       * @Route("/newUpload", name="adhesion_newUpload", methods={"GET","POST"})
       */
      public function newUpload(Request $request, ImageRepository $repository)
      {
        $user=$this->getUser();
        $adhesion = $user->getAdhesion();
        if (!$adhesion) {
            return $this->render('adhesion/echecmajAdherent.html.twig');
        }
        $adhesionId = $user->getAdhesion() ? $user->getAdhesion()->getId() : null;
        $image = $adhesion->getImage();
        $imageName = $adhesion->getImage() ? $adhesion->getImage()->getImageName() : null;
       // $imageName = $image->getImageName();
      
      
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
          
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            if($imageName){
                $image->setImageName(''); //supression nom du fichier dans bdd
                unlink($this->getParameter('image_directory').'/'. $imageName); // suppression fichier 
                $this->getDoctrine()->getManager()->flush();  
               }
            
                $imageId=$adhesion->getImage() ? $adhesion->getImage()->getId() : null;
                
            /**
             *@var UploadedFile $imageFile
             */
            $imageFile = $form['imageName']->getData();
            $data = base64_encode($imageFile);

            if ($imageFile) {
                $imageName = md5(uniqid()).".".$imageFile->guessExtension();
                $imageFile->move($this->getParameter("image_directory"), $imageName);
                $image->setImageName($imageName);
            }

          
            
            $adhesion->setImage($image);
          
            $this->em->flush();
            return $this->redirectToRoute('adhesion_viewUpload');
        }
        return $this->render('images/index.html.twig', [
                            'form' => $form->createView(),
                        ]);
    }
     
     /**
       * @Route("/retour", name="adhesion_retour", methods={"GET","POST"})
       */
      public function retour()
      {
          return $this->redirectToRoute('home');
      }
  
}