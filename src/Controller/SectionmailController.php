<?php

namespace App\Controller;

use App\Entity\Sectionmail;

use App\Form\SectionmailType;
use App\Repository\SectionmailRepository;
use App\Repository\UserRepository;
use App\Service\Gomailsg;
use App\Service\TakeSg;
use App\Service\VerifTexte;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sectionmail")
 */
class SectionmailController extends AbstractController
{
    /**
     * @Route("/", name="sectionmail_index", methods={"GET"})
     */
    public function index(SectionmailRepository $sectionmailRepository): Response
    {
        return $this->render('sectionmail/index.html.twig', [
            'sectionmails' => $sectionmailRepository->findAll(),
        ]);
    }
    
/**
 * @Route("/testService", name="sectionmail_testService", methods={"GET"})
 */
public function testService(VerifTexte $verifTexte){
    $note='Je suis un divin Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'e';
    $reception = $verifTexte->isSpam($note);
    if(!$reception)
        {
        return $this->render('veriftexte/indexno.html.twig');
        }
    else{
        return $this->render('veriftexte/indexyes.html.twig');
        }
    }

/**
 * @Route("/selectsgLyon1", name="sectionmail_selectsgLyon1", methods={"GET","POST"})
 */
public function selectsgLyon1(TakeSg $takeSg, Request $request,UserRepository $userRepository, MailerInterface $mailer): Response
{
        return $this->redirectToRoute('sectionmail_pushSg',[
              'reception' => 'sgIdLyon1'
        ]); 
}

/**
 * @Route("/selectsgLyon2", name="sectionmail_selectsgLyon2", methods={"GET","POST"})
 */
public function selectsgLyon2(TakeSg $takeSg, Request $request,UserRepository $userRepository, MailerInterface $mailer): Response
{
        return $this->redirectToRoute('sectionmail_pushSg',[
              'reception' => 'sgIdLyon2'
        ]); 
}


    /**
     * 
     * @Route("/pushSg{reception}", name="sectionmail_pushSg", methods={"GET","POST"})
     */
    public function pushSg(Request $request,UserRepository $userRepository, MailerInterface $mailer,$reception): Response
    {
        $essaie=$reception;
        // chargement des donnée de service.yml
        $userIdSg = $this->getParameter($essaie);
        $fpiMail = $this->getParameter('fpiMail');

        // affectation des données du secrétaire général.
        $sgUser= $userRepository->findOneByAdhesion($userIdSg);
        $sgAdhesion = $sgUser->getAdhesion();
        $image = $sgAdhesion->getImage();
        $imageId=$sgAdhesion->getImage() ? $sgAdhesion->getImage()->getId() : null;
        if(!$imageId)
        {
            return $this->render('images/echec_vue_image.html.twig');
                
        }
        $imageimagename = $image->getImageName();
        $sgFirstName= $sgAdhesion->getFirstName();
        $sgLastName= $sgAdhesion->getLastName();
        $sgMail= $sgAdhesion->getEmail();

        // affectation des données de l'utilisateur.
        $user= $this->getUser();
        $adhesion=$user->getAdhesion();
       
           
        $userFirstName=$adhesion->getFirstName(); 
        $userLastName=$adhesion->getLastName(); 
        $userMail=$adhesion->getEmail(); 
        $userGender=$adhesion->getGender(); 

        $dateok=new \Datetime();

        $sectionmail = new Sectionmail();

        //insertion des données dans la bdd pour l'objet sectionmail
        $sectionmail->setUser1name($userFirstName);
        $sectionmail->setUser2name($userLastName);
        $sectionmail->setUser3mail($userMail);
        $sectionmail->setGender($userGender);
        $sectionmail->setSg1name($sgFirstName);
        $sectionmail->setSg2name($sgLastName);
        $sectionmail->setSg3mail($sgMail);
        $sectionmail->setDateMail(new \DateTime('now'));
        
        $form = $this->createForm(SectionmailType::class, $sectionmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('Annuler')->isClicked()) {
                return $this->redirectToRoute('home');
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sectionmail);
            $entityManager->flush();
          
            //Envoi du Mail
            $email = (new TemplatedEmail())
            ->from($fpiMail)
            ->to($sgMail)
            ->subject('Message fpiinscription')

            ->htmlTemplate('sectionmail/mailSg.html.twig')
            ->context([
            'sectionmail' => $sectionmail,
             ]);
             $mailer->send($email);

            return $this->redirectToRoute('home');
        }

        return $this->render('sectionmail/envoiMailSg.html.twig', [
            'sectionmail' => $sectionmail,
            'form' => $form->createView(),
            'im' => $imageimagename,
            
        ]);
        //  $reception = $request->query->get('reception');
        // $reception = 'qui';
        // return $this->render('veriftexte/indexyes.html.twig',[
        //     'reception' => 'on attend', 
        //     // 'reception' => $reception, 
        //          'num' => 123,
        // ]); 

    }


    /**
     * @Route("/new", name="sectionmail_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sectionmail = new Sectionmail();
        $sectionmail->setDateMail(new \DateTime('now'));
        $form = $this->createForm(SectionmailType::class, $sectionmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sectionmail);
            $entityManager->flush();

            return $this->redirectToRoute('sectionmail_index');
        }

        return $this->render('sectionmail/new.html.twig', [
            'sectionmail' => $sectionmail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @ParamConverter()
     * @Route("/{id}", name="sectionmail_show", methods={"GET"})
     */
    public function show(Sectionmail $sectionmail): Response
    {
        return $this->render('sectionmail/show.html.twig', [
            'sectionmail' => $sectionmail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sectionmail_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sectionmail $sectionmail): Response
    {
        $form = $this->createForm(SectionmailType::class, $sectionmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sectionmail_index');
        }

        return $this->render('sectionmail/edit.html.twig', [
            'sectionmail' => $sectionmail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sectionmail_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sectionmail $sectionmail): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sectionmail->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sectionmail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sectionmail_index');
    }
}
