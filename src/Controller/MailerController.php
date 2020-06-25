<?php
// src/Controller/MailerController.php
namespace App\Controller;

use App\Controller\AdhesionController;
use App\Controller\CountController;
use App\Controller\ObjectManager;
use App\Entity\Adhesion;
use App\Form\CountType;
use App\Repository\CountRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/sendmail")
     */
class MailerController extends AbstractController
{
    /**
     * @Route("/email", name="sendmail_email")
     */
    public function email(MailerInterface $mailer)
    {
        $email = (new TemplatedEmail())
            ->from('fpiinscription@gmail.com')
            ->to('traoreerick@gmail.com')
            ->subject('Site fpiinscription')
           
   // path of the Twig template to render
   ->htmlTemplate('emails/signup.html.twig')
    
   // pass variables (name => value) to the template
   ->context([
       'expiration_date' => new \DateTime('+7 days'),
       'username' => 'foo',
   ]);
        $mailer->send($email);
 //return $email;
        return new Response("phase une ok 4");
    }

     /**
     * @Route("/sendattestation", name="sendmail_sendattestation")
     */
    public function sendattestation(MailerInterface $mailer, CountRepository $countRepository):Response
    {
        $user = $this->getUser();
        $adhesion = $user->getAdhesion();
        $adhesionId = $adhesion->getId();
        $adhesionfirstname = $adhesion->getFirstName();
        $adhesionemail = $adhesion->getEmail();
        $counts = $countRepository->findBy(
            array('adhesion' => $adhesionId) // Critere 
        );
       
        $email = (new TemplatedEmail())
            ->from('fpiinscription@gmail.com')
            ->to($adhesionemail)
            ->subject('Justificatif délivré par fpiinscription.com')
            
           
   // path of the Twig template to render
        ->htmlTemplate('count/attestationMail.html.twig')
        ->context([
            'counts' => $counts,
            'adhesionId' => $adhesionId,
            'adhesionfirstname' => $adhesionfirstname
        ]);
        $mailer->send($email);
        return $this->redirectToRoute('count_attestation');
    }
    //    /**
    //  * @Route("/sgemail/{sgmessage}", name="sendmail_sgemail")
    //  */
    // public function sgemail(MailerInterface $mailer, $sgmessage)
    // {
    //     $email = (new TemplatedEmail())
    //         ->from('fpiinscription@gmail.com')
    //         ->to('traoreerick@gmail.com')
    //         ->subject('SMS délivré par fpiinscription.com')
           
    //         // path of the Twig template to render
    //         ->htmlTemplate('emails/sgemail.html.twig')
                
    //         // pass variables (name => value) to the template
    //         ->context([
    //             'sgmessage' => $sgmessage
                
    //         ]);
    //                 $mailer->send($email);
    //         //return $email;
    //                 return new Response("phase une ok 4");
    // }
}