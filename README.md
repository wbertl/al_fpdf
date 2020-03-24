# al_fpdf
Typo3 Extension to include Fpdf and Fpdi2 Libraries

Usage :

Just install Extension and use like this:

$pdf = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Almitra\\AlFpdf\\Utility\\Pdf');
$pdf->setTemplate ( 'Example.pdf' );
$pdf->getPage (1); // write to Page 1
$pdf->setXY( 100, 100 );
$pdf->Write( 4, 'Exampletext');
$pdf->Render();
