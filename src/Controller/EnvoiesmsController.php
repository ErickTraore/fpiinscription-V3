<?php

namespace App\Controller;

use App\Entity\SMSPartnerAPI;
use App\Entity\User;
use App\Repository\UserRepository;
use App\src\Fichiers\Departsms;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Debug\DebugClassLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/envoiesms")
 */
class EnvoiesmsController extends AbstractController
{
   /**
    * @var EntityManagerInterface $em 
    */
    private $em;
    
    /**
     * @Route("/sympathisant/{number_phone}/{message_phone}", name="envoiesms_sympathisant")
     */
    public function sympasms(Request $request, $number_phone, $message_phone): Response
    {
        if (isset($message_phone) && isset($number_phone)) {
            $gateway_url = "https://sms.lws.fr/sms/api";
            $action = "send-sms";
            $apiKey  = "ZGFvdWRhOiQyeSQxMCRneVdNTWhZT3dpYTdhb0NNLlI2blAuSkRMY2ZNSmRsbGZ4OS5yUHdGU1NOaC52Mk9OcURhUw==";
            $to =$number_phone/1;
            $senderID  = "FPI_GBAGBO";
            $message  = urlencode($message_phone);
            // Prepare le tableau de données pour la requête API
            $data = array('action' => $action,
                      'api_key' => $apiKey,
                      'to' => $to,
                      'from' => $senderID,
                      'sms' => $message,
                );
            // Envoie la requête API via cURL
            $ch = curl_init($gateway_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $get_data = json_decode($response, true);
            /* On traite le retour.
             * get_date['code'] récupére un code selon la réussite ou l'erreur de l'API
             * get_date['Message'] récupére le message Success ou explication de l'erreur.
             */
            if ($get_data['code'] === 'ok') {
                echo 'Le SMS a bien été envoyé';
            } else {
                echo 'Code test Erreur : '.$get_data['code'].' -- '.$get_data['message'];
            }
            return $this->render('adhesion/envoiesmsok.html.twig');
        }
    return $this->render('page_erreurr_sms.html.twig');
    }
    /**
     * @Route("/adherent/{number_phone}/{message_phone}", name="envoiesms_adherent")
     */
    public function adherentsms(Request $request, $number_phone, $message_phone): Response
    {
        if (isset($message_phone) && isset($number_phone)) {
            $gateway_url = "https://sms.lws.fr/sms/api";
            $action = "send-sms";
            $apiKey  = "ZGFvdWRhOiQyeSQxMCRneVdNTWhZT3dpYTdhb0NNLlI2blAuSkRMY2ZNSmRsbGZ4OS5yUHdGU1NOaC52Mk9OcURhUw==";
            $to =$number_phone/1;
            $senderID  = "FPI_GBAGBO";
            $message  = urlencode($message_phone);
            // Prepare le tableau de données pour la requête API
            $data = array('action' => $action,
                      'api_key' => $apiKey,
                      'to' => $to,
                      'from' => $senderID,
                      'sms' => $message,
                );
            // Envoie la requête API via cURL
            $ch = curl_init($gateway_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $get_data = json_decode($response, true);
            /* On traite le retour.
             * get_date['code'] récupére un code selon la réussite ou l'erreur de l'API
             * get_date['Message'] récupére le message Success ou explication de l'erreur.
             */
            if ($get_data['code'] === 'ok') {
                echo 'Le SMS a bien été envoyé';
            } else {
                echo 'Code test Erreur : '.$get_data['code'].' -- '.$get_data['message'];
            }
            return $this->render('adhesion/bravoAdherent.html.twig');
            }
        return $this->render('page_erreurr_sms.html.twig');
        }

    /**
     * @Route("/departsms/{number_phone}/{message_phone}", name="envoiesms_departsms")
     */
    public function departsms(Request $request, $number_phone, $message_phone): Response
    {
        if (isset($message_phone) && isset($number_phone)) {
            $gateway_url = "https://sms.lws.fr/sms/api";
            $action = "send-sms";
            $apiKey  = "ZGFvdWRhOiQyeSQxMCRneVdNTWhZT3dpYTdhb0NNLlI2blAuSkRMY2ZNSmRsbGZ4OS5yUHdGU1NOaC52Mk9OcURhUw==";
            $to =$number_phone/1;
            $senderID  = "FPI_GBAGBO";
            $message  = urlencode($message_phone);
            // Prepare le tableau de données pour la requête API
            $data = array('action' => $action,
                      'api_key' => $apiKey,
                      'to' => $to,
                      'from' => $senderID,
                      'sms' => $message,
                );
            // Envoie la requête API via cURL
            $ch = curl_init($gateway_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $get_data = json_decode($response, true);
            /* On traite le retour.
             * get_date['code'] récupére un code selon la réussite ou l'erreur de l'API
             * get_date['Message'] récupére le message Success ou explication de l'erreur.
             */
            if ($get_data['code'] === 'ok') {
                echo 'Le SMS a bien été envoyé';
            } else {
                echo 'Code test Erreur : '.$get_data['code'].' -- '.$get_data['message'];
            }
            return $this->render('security2/forgetpassafter.html.twig');
            }
        return $this->render('page_erreurr_sms.html.twig');   
        }     
          
    /**
     * @Route("/signaturesms/{number_phone}/{message_phone}/{pass}", name="envoiesms_signaturesms")
     */
    public function signaturesms(Request $request, $number_phone, $message_phone, $pass): Response
    {
        if (isset($message_phone) && isset($number_phone)) {
            $gateway_url = "https://sms.lws.fr/sms/api";
            $action = "send-sms";
            $apiKey  = "ZGFvdWRhOiQyeSQxMCRneVdNTWhZT3dpYTdhb0NNLlI2blAuSkRMY2ZNSmRsbGZ4OS5yUHdGU1NOaC52Mk9OcURhUw==";
            $to =$number_phone/1;
            $senderID  = "FPI_GBAGBO";
            $message  = urlencode($message_phone);
            // Prepare le tableau de données pour la requête API
            $data = array('action' => $action,
                      'api_key' => $apiKey,
                      'to' => $to,
                      'from' => $senderID,
                      'sms' => $message,
                );
            // Envoie la requête API via cURL
            $ch = curl_init($gateway_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $get_data = json_decode($response, true);
            /* On traite le retour.
             * get_date['code'] récupére un code selon la réussite ou l'erreur de l'API
             * get_date['Message'] récupére le message Success ou explication de l'erreur.
             */
            if ($get_data['code'] === 'ok') {
                echo 'Le SMS a bien été envoyé';
            } else {
                echo 'Code test Erreur : '.$get_data['code'].' -- '.$get_data['message'];
            }
            return $this->redirectToRoute('signaturetripleafter',[
            "pass"=>$pass,
            ]);
        }
     return $this->render('page_erreurr_sms.html.twig');   
     } 

    /**
     * @Route("/lwssmssignature", name="envoiesms_lwssmssignature")
     */
    public function lwssmssignature(Request $request): Response
    {
        $number_phone='0033778351871';
        $message_phone = 'Test réel de fonctionnement SMS-57078';

        return $this->render('security2/lwssmssignature.html.twig');   
        
        // 
    }
    /**
     * @Route("/smspartnersignature", name="envoiesms_smspartnersignature")
     */
    public function smspartnersignature(Request $request): Response
    {
        $smspartner = new SMSPartnerAPI();
        $fields = array(
            "apiKey"=>"3f94431ecf9a65af5d233d4072903ff8350025f6",
            "phoneNumbers"=>"0033778351871",
            "message"=>"Test réel de fonctionnement PARTNER",
            "sender" => "FPI Lyon",
        //     "scheduledDeliveryDate"=>"21/12/2014",
        //     "time"=>11,
        //     "minute"=>0
        );
        $result = $smspartner->sendSms($fields);
        
        return $this->render('security2/smspartnersignature.html.twig');
    }
    
}
