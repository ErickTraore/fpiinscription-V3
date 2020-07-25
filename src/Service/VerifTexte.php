<?php
// src/Service/verifTexte.php

namespace App\Service;

class VerifTexte
{
  /**
   * Vérifie si le texte est un spam ou non
   *
   * @param string $text
   * @return bool
   */
  public function isSpam($text)
  {
    return strlen($text) < 50;
  }
}