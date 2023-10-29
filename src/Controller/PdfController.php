<?php

namespace Drupal\tcpdf_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PdfController extends ControllerBase {

  protected $pdfGenerator;

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tcpdf_module.pdf_generator')
    );
  }

  public function __construct($pdfGenerator) {
    $this->pdfGenerator = $pdfGenerator;
  }

  public function downloadPdf() {
    $this->pdfGenerator->generatePdf();
    exit; // Important, car nous voulons stopper toute exécution supplémentaire et envoyer le PDF.
  }
}
