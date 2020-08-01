<?php
namespace App\Controller;

use App\Controller\EnvoiesmsController;
use App\Controller\SecurityController;
use App\Entity\Adhesion;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\StubAuthenticator;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Argument\ServiceLocator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse ;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{   
     /**
     * @Route("/users", name="users_list", methods={"GET"})
     */
    public function getUsers(Request $request, UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        /* @var $places Place[] */

        $formatted = [];
        foreach ($users as $user) {
                    $formatted[] = [
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'date_crea' => $user->getDateCrea(),
                    'nom' => $user->getAdhesion()-> getFirstName(),
                    'prenom' => $user->getAdhesion()-> getLastName(),
                    
                    // 'adhesion' => $user->getAdhesion(),
                    ];
                    }

        return new JsonResponse($formatted);
    }
    
    /**
     * @Route("mdpupdate", name="mdpupdate", methods={"GET"})
     */
    public function mdpupdate(): Response
    {
        $user = $this->getUser();
        
        return $this->redirectToRoute('updatePassword',[
            'id' => $user->getId(),
        ]);  
    }
    
    /**
     * @Route("updatePassword/{id}", name="updatePassword")
     * 
     */
    public function updatePassword($id,User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            // encode the plain password
            
            $password = $passwordEncoder->encodePassword(
                $user,
                $user->getPlainPassword()
              );
            $user->setPassword($password);

            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->render('updatePassword.html.twig',[
                'user' => $user,
            ]);
        }
        return $this->render('form.html.twig', [
            'form' => $form->createView(),
        ]);


    }
 
    /**
     * @Route("register", name="app_register", methods={"GET","POST"})
     * 
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
            if ($form->isSubmitted()) {
                // encode the plain password
            
                $password = $passwordEncoder->encodePassword(
                    $user,
                    $user->getPlainPassword()
                );
                $user->setPassword($password);

            
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $datanum = $user->getId();
                // $username = $user->getUsername();
                $request->getSession()->getFlashBag()->add('notice', 'Inscription bien enregistrée.');
                $message_inscription = " Bravo, vous etes maintenant inscrit au FPI sous le statut de SYMPATHISANT,ref: FPI-INS" . $datanum ." La direction du FPI vous remercie de votre confiance. ";
                //vérouillage ou dévérouillage des envois sms grace à $insertisok
                // $smsok = false;
                $smsok = true;
                if ($smsok) {
                    return $this->redirectToRoute('envoiesms_sympathisant', [
                    'number_phone'  => $user->getUsername(),
                    'message_phone' => $message_inscription,
                    'Controller_name' => 'EnvoiesmsController'
                ]);
                    $insertisok = false;
                }
            
                $this->addFlash(
                    'success',
                    'Votre compte a bien été créé.'
                );
            
                return $this->redirectToRoute('login');
            }
            return $this->render('security1/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name = "login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('security1/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));

        
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        // controller can be blank: it will never be executed!
     //   throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    /**
     * @Route("/sayid", name="sayid")
     */
    public function sayid()
    {
        $user1 = $this->getUser();
        if ($user1) {
        return $this->render('sayid.html.twig', ['user' => $user1,]);
        }
        return $this->redirectToRoute('login', ['Controller'=>'SecurityController']); 
    }
   
  
  
    
 
    
}