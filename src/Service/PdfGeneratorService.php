<?php

namespace Drupal\tcpdf_module\Service;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\tcpdf_module\Service\CustomTCPDF;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\Template\Loader\ThemeRegistryLoader;
use Drupal\Core\Theme\ThemeManagerInterface;
use Drupal\Core\Theme\ThemeInitialization;

class PdfGeneratorService {

  const HEADER_HEIGHT = 50;

  protected RequestStack $requestStack;
  protected ThemeManagerInterface $themeManager;
  protected ThemeInitialization $themeInitialization;
  protected ModuleHandlerInterface $moduleHandler; // Ajoutez cette ligne
  protected RendererInterface $renderer;

  public function __construct(
    RequestStack $requestStack,
    ThemeManagerInterface $themeManager,
    ThemeInitialization $themeInitialization,
    ModuleHandlerInterface $moduleHandler,
    RendererInterface $renderer
  ) {
    $this->requestStack = $requestStack;
    $this->themeManager = $themeManager;
    $this->themeInitialization = $themeInitialization;
    $this->moduleHandler = $moduleHandler;
    $this->renderer = $renderer;
  }

  public function generatePdf() {

    $products = [
      ['name' => 'Produit 1', 'price' => '10€', 'description' => 'Description du produit 1', 'quantity' => 2],
      ['name' => 'Produit 2', 'price' => '20€', 'description' => 'Description du produit 2', 'quantity' => 5],
      ['name' => 'Produit 3', 'price' => '15€', 'description' => 'Description du produit 3', 'quantity' => 3],
      ['name' => 'Produit 4', 'price' => '25€', 'description' => 'Description du produit 4', 'quantity' => 1],
      ['name' => 'Produit 5', 'price' => '30€', 'description' => 'Description du produit 5', 'quantity' => 4],
      ['name' => 'Produit 6', 'price' => '35€', 'description' => 'Description du produit 6', 'quantity' => 2],
      ['name' => 'Produit 7', 'price' => '28€', 'description' => 'Description du produit 7', 'quantity' => 3],
      ['name' => 'Produit 8', 'price' => '40€', 'description' => 'Description du produit 8', 'quantity' => 1],
      ['name' => 'Produit 9', 'price' => '12€', 'description' => 'Description du produit 9', 'quantity' => 5],
      ['name' => 'Produit 10', 'price' => '22€', 'description' => 'Description du produit 10', 'quantity' => 2],
      ['name' => 'Produit 11', 'price' => '10€', 'description' => 'Description du produit 1', 'quantity' => 2],
      ['name' => 'Produit 12', 'price' => '20€', 'description' => 'Description du produit 2', 'quantity' => 5],
      ['name' => 'Produit 13', 'price' => '15€', 'description' => 'Description du produit 3', 'quantity' => 3],
      ['name' => 'Produit 14', 'price' => '25€', 'description' => 'Description du produit 4', 'quantity' => 1],
      ['name' => 'Produit 15', 'price' => '30€', 'description' => 'Description du produit 5', 'quantity' => 4],
      ['name' => 'Produit 16', 'price' => '35€', 'description' => 'Description du produit 6', 'quantity' => 2],
      ['name' => 'Produit 17', 'price' => '28€', 'description' => 'Description du produit 7', 'quantity' => 3],
      ['name' => 'Produit 18', 'price' => '40€', 'description' => 'Description du produit 8', 'quantity' => 1],
      ['name' => 'Produit 19', 'price' => '12€', 'description' => 'Description du produit 9', 'quantity' => 5],
      ['name' => 'Produit 20', 'price' => '22€', 'description' => 'Description du produit 10', 'quantity' => 2],
      ['name' => 'Produit 21', 'price' => '10€', 'description' => 'Description du produit 1', 'quantity' => 2],
      ['name' => 'Produit 22', 'price' => '20€', 'description' => 'Description du produit 2', 'quantity' => 5],
      ['name' => 'Produit 23', 'price' => '15€', 'description' => 'Description du produit 3', 'quantity' => 3],
      ['name' => 'Produit 24', 'price' => '25€', 'description' => 'Description du produit 4', 'quantity' => 1],
      ['name' => 'Produit 25', 'price' => '30€', 'description' => 'Description du produit 5', 'quantity' => 4],
      ['name' => 'Produit 26', 'price' => '35€', 'description' => 'Description du produit 6', 'quantity' => 2],
      ['name' => 'Produit 27', 'price' => '28€', 'description' => 'Description du produit 7', 'quantity' => 3],
      ['name' => 'Produit 28', 'price' => '40€', 'description' => 'Description du produit 8', 'quantity' => 1],
      ['name' => 'Produit 29', 'price' => '12€', 'description' => 'Description du produit 9', 'quantity' => 5],
      ['name' => 'Produit 30', 'price' => '22€', 'description' => 'Description du produit 10', 'quantity' => 2],
      ['name' => 'Produit 31', 'price' => '10€', 'description' => 'Description du produit 1', 'quantity' => 2],
      ['name' => 'Produit 32', 'price' => '20€', 'description' => 'Description du produit 2', 'quantity' => 5],
      ['name' => 'Produit 33', 'price' => '15€', 'description' => 'Description du produit 3', 'quantity' => 3],
      ['name' => 'Produit 34', 'price' => '25€', 'description' => 'Description du produit 4', 'quantity' => 1],
      ['name' => 'Produit 35', 'price' => '30€', 'description' => 'Description du produit 5', 'quantity' => 4],
      ['name' => 'Produit 36', 'price' => '35€', 'description' => 'Description du produit 6', 'quantity' => 2],
      ['name' => 'Produit 37', 'price' => '28€', 'description' => 'Description du produit 7', 'quantity' => 3],
      ['name' => 'Produit 38', 'price' => '40€', 'description' => 'Description du produit 8', 'quantity' => 1],
      ['name' => 'Produit 39', 'price' => '12€', 'description' => 'Description du produit 9', 'quantity' => 5],
      ['name' => 'Produit 40', 'price' => '22€', 'description' => 'Description du produit 10', 'quantity' => 2]
    ];



    // Créez une nouvelle instance de TCPDF
    $pdf = $this->createCustomPdfInstance();

    // Informations du document
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Votre nom');
    $pdf->SetTitle('Bon de commande');
    // Utilisez les modèles twig pour générer le contenu de l'en-tête, du corps et du pied de page
    $header = $this->renderTemplate('header.twig', ['client_name' => 'Nom du client', 'shipping_address' => 'Adresse d\'expédition', 'delivery_address' => 'Adresse de livraison']);
    $footer = $this->renderTemplate('footer.twig', []);
    $body = $this->renderTemplate('body.twig', ['products' => $products]);
    // Définissez le contenu de l'en-tête et du pied de page pour TCPDF
    $pdf->setHeaderContent($header);
    $pdf->setFooterContent($footer);
    // Définissez les marges. Ajustez ces valeurs selon la hauteur de votre header et footer.
    $pdf->SetMargins(PDF_MARGIN_LEFT, self::HEADER_HEIGHT, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(0); // Ajustez cette valeur selon la hauteur de votre en-tête.
    $pdf->SetFooterMargin(15); // Ajustez cette valeur selon la hauteur de votre pied de page.

    $pdf->SetAutoPageBreak(true, 70); // 40 est la marge inférieure en mm. Ajustez selon vos besoins.
    // Ajoutez une première page vide pour que TCPDF calcule la hauteur du header
//    $pdf->AddPage();
//    $pdf->SetY(50);
//    $pdf->Cell(0, 0, '', 0, 1, 'C');

    // Ajoutez ensuite la vraie première page
    $pdf->AddPage();
    $pdf->SetY(self::HEADER_HEIGHT);
    $pdf->writeHTMLCell(0, 0, '', '', $body, 0, 1, 0, true, '', true);

    // Sortie du PDF
    $pdf->deletePage(1);
    $pdf->Output('bon_de_commande.pdf', 'I');
  }

  protected function createCustomPdfInstance(): CustomTCPDF {
    // D'autres configurations initiales peuvent être ajoutées ici si nécessaire
    return new CustomTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  }

  protected function renderTemplate($templateName, $variables): string {
    $modulePath = $this->moduleHandler->getModule('tcpdf_module')->getPath();
    $templatePath = $modulePath . '/templates/' . $templateName;
    $templateContent = file_get_contents($templatePath); // Stockez le contenu dans une variable
    $renderArray = [
      '#type' => 'inline_template',
      '#template' => $templateContent,  // Utilisez cette variable
      '#context' => $variables,
    ];
    return (string) $this->renderer->renderPlain($renderArray);
  }
}
