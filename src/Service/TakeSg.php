<?php
// src/Service/verifTexte.php
namespace App\Service;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\SectionmailController;



class TakeSg
{
  
  public function numSg($thing)
  {

    $numberSg = "$thing";
    return $numberSg;

}
}