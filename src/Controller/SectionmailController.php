<?php

namespace App\Controller;

use App\Entity\Sectionmail;
use App\Form\SectionmailType;
use App\Repository\SectionmailRepository;
use App\Repository\UserRepository;
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
     * @Route("/mailsg", name="sectionmail_mailsg", methods={"GET","POST"})
     */
    public function mailsg(Request $request,UserRepository $userRepository, MailerInterface $mailer): Response
    {
        // chargement des donnée de service.yml
        $userIdSg = $this->getParameter('sgId');
        $fpiMail = $this->getParameter('fpiMail');

        // affectation des données du secrétaire général.
        $sgUser= $userRepository->findOneByAdhesion($userIdSg);
        $sgAdhesion = $sgUser->getAdhesion();
        $sgFirstName= $sgAdhesion->getFirstName();
        $sgLastName= $sgAdhesion->getLastName();
        $sgMail= $sgAdhesion->getEmail();

        // affectation des données de l'utilisateur.
        $user= $this->getUser();
        $adhesion=$user->getAdhesion();
        $userFirstName=$adhesion->getFirstName(); 
        $userLastName=$adhesion->getLastName(); 
        $userMail=$adhesion->getEmail(); 
        $userGenre=$adhesion->getGender(); 

        $dateok=new \Datetime();

        // test des resultats recherchés
// var_dump($sgFirstName,$sgLastName,$sgMail);
// var_dump($userFirstName,$userLastName,$userMail);

        $sectionmail = new Sectionmail();

        //insertion des données dans la bdd pour l'objet sectionmail
        $sectionmail->setUser1name($userFirstName);
        $sectionmail->setUser2name($userLastName);
        $sectionmail->setUser3mail($userMail);
        $sectionmail->setGenre($userGenre);
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
            ->subject('Test envoi mail aus SG fpi')
            

        ->htmlTemplate('sectionmail/mailSg.html.twig')
        ->context([
            'sectionmail' => $sectionmail,
            // 'adhesionId' => $adhesionId,
            // 'adhesionfirstname' => $adhesionfirstname
        ]);
        $mailer->send($email);

            return $this->redirectToRoute('home');
        }

        return $this->render('sectionmail/envoiMailSg.html.twig', [
            'sectionmail' => $sectionmail,
            'form' => $form->createView(),
        ]);
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
