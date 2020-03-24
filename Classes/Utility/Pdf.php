<?php 

namespace Almitra\AlFpdf\Utility;

use setasign\Fpdi\Fpdi;

/***
 * Usage 
 * 
 * $pdf = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Almitra\\AlFpdf\\Utility\\Pdf');
 * $pdf->setTemplate ( 'Example.pdf' );
 * $pdf->getPage (1); // write to Page 1
 * $pdf->setXY( 100, 100 );
 * $pdf->Write( 4, 'Beispieltext');
 * $pdf->Render();
 * 
 * 
 * @author Wolfgang Bertl
 *
 */

class Pdf {  
    
    var $currentPageNo = 0;
    
    var $pageCount;  
    
    var $pages;
    
    var $pdf;  
    
    var $template;
    
    var $output;
    
    function __construct() {
        require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('al_fpdf').'Classes/Lib/Fpdf/fpdf.php'); 
        
        $this->pdf = new Fpdi();      
       
        // set Default Margin
        $this->setLeftMargin( 25 );
        $this->setRightMargin( 25 );
        
        // Set Default Font
        $this->SetFont('Helvetica', 'I', 10);
        $this->SetTextColor();
    }
    
    /**
     * 
     * @param string $filename ... Filename of File to write Export to
     * @param string $type ... Either S (return as String) od F (write File to location) or default I (output)
     */
    
    function render( $filename = '', $type = 'I') {
        /*$pageNo = 3;
        for ($pageNo = 1; $pageNo <= $this->pageCount; $pageNo++) {
            // import a page
            $templateId = $this->pdf->importPage($pageNo);
            
            $pages[] = $templateId;
            
            $this->pdf->AddPage();
            // use the imported page and adjust the page size
            $this->pdf->useTemplate($templateId, ['adjustPageSize' => true]);
        }*/
        
       
        /*
        if (!$type) $type = 'S';
        
        if (($type !== 'S') && ($type !== 'F')) return;
        
        if ($file) {
            $this->output = $this->pdf->Output($filename, $type);
        } else {
            $this->output = $this->pdf->Output('', $type);
        } */   
        
        /*if ($this->currentPageNo < $this->pageCount) {
            $page = $this->currentPageNo;
            for ($page; $page < $pageNo; $page++ ) {print $page;
                $this->addPage ( $page );
            }             
        }*/
        
        // fill the missing Pages       
        $this->getPage ( $this->pageCount );
            
        return $this->pdf->Output($filename, $type);
        //$this->pdf->Output();
    }
    
    function getTemplate () {
        return $template;
    }
    
    function setTemplate( $template ) {
        $this->template = $template;
        
        $this->pageCount = $this->pdf->setSourceFile( $this-> template );
    }
    
    /**
     * get Page
     * @param int $pageNo .. Number of Page
     * @return unknown
     */
    function getPage ( $pageNo ) {
        
        if ($pageNo > $this->pageCount) {
            error_log( $pageNo . ' is out of Range 1 - ' . $this->pageCount);
            return;
        }
        
        if ($pageNo == $this->currentPageNo) {
            error_log( $pageNo . ' is already rendered');
            return;
        }
        
        $this->currentPageNo++;
        
        if ($pageNo > $this->currentPageNo) {
            $page = $this->currentPageNo;
            
            // add Pages before this page in multisite document
            for ($page; $page < $pageNo; $page++ ) {
                $this->addPage ( $page );
            } 
        }               
        
        $this->addPage( $pageNo );

    }
    
    /**
     * add Page
     * @param unknown $pageNo
     */
    function addPage( $pageNo ) {
        
       $this->currentPageNo = $pageNo;
        
       $currentPage = $this->pdf->importPage( $pageNo );
        
       $this->pdf->AddPage();
        
       $this->pdf->useTemplate($currentPage, ['adjustPageSize' => true]);
    }
    
    function getOutput () {
        return $this->output;        
    }
    
    function setLeftMargin( $margin ) {
        $this->pdf->SetLeftMargin( $margin );
    }
    
    function setRightMargin( $margin ) {
        $this->pdf->SetLeftMargin( $margin );
    }
    
    function setFont( $family, $style = '', $size = 0) {
        $this->pdf->setFont($family, $style, (int)$size);
    }
    
    function setFontsize( $size ) {
        $this->pdf->setFontsize( (int)$size );
    }
    
    function setTextColor ( $r = 0, $g = 0, $b = 0 ) {
        $this->pdf->SetTextColor( (int)$r, (int)$g, (int)$p);
    }

    function setXY( $x, $y) {
        $this->pdf->setXY( (int)$x, (int)$y );
    }
    
    function Ln() {
        $this->pdf->Ln();
    }
    
    function write ( $text, $height = 4 ) {
        $this->pdf->Write( (int)$height, $text);
    }      
}