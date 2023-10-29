<?php
namespace Drupal\tcpdf_module\Service;

use TCPDF;

class CustomTCPDF extends TCPDF {

  private $headerContent;
  private $footerContent;

  public function setHeaderContent($content) {
    $this->headerContent = $content;
  }

  public function setFooterContent($content) {
    $this->footerContent = $content;
  }

  public function Header() {
    $this->writeHTML($this->headerContent, true, 0, true, 0);
  }

  public function Footer() {
    $this->SetY(-20);
    $this->SetFont('helvetica', 'I', 8);
    $this->Cell(0, 20, $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C');
    $this->writeHTML($this->footerContent, true, 0, true, 0);
  }
}
