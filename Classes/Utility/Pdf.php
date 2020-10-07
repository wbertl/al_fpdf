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
 * $pdf->Write( 'Beispieltext', 4);
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
    
    function __construct( $class = false, $params = false) {
        #require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('al_fpdf').'Classes/Lib/Fpdf/fpdf.php'); 
        
        if (!$class) {
            $this->pdf = new Fpdi();     
        } else {
            $this->pdf = new $class( $params );
        }
       
        $this->pdf->AliasNbPages();
       
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
    
    function render( $filename = '', $type = 'I', $skipPages = []) {
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
        $this->getPage ( $this->pageCount, $skipPages );
            
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
     * @param bool $skip ... if set, Pages before are skipped
     * @return unknown
     */
    function getPage ( $pageNo, $skipPages = [] ) {
        
        if ($pageNo > $this->pageCount) {
            error_log( $pageNo . ' is out of Range 1 - ' . $this->pageCount);
            return;
        }
        
        if ($pageNo == $this->currentPageNo) {
            error_log( $pageNo . ' is already rendered');
            return;
        }
        
        $this->currentPageNo++;
        
        if (($pageNo > $this->currentPageNo) && ($skip == false)) {
            $page = $this->currentPageNo;
            
            // add Pages before this page in multisite document
            for ($page; $page < $pageNo; $page++ ) {
                if( in_array($page,$skipPages) ) {
                    continue;
                }
                $this->addPage ( $page );
            } 
        }               
        
        if (!in_array($pageNo, $skipPages)) {
            $this->addPage( $pageNo );
        }

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
    
    function getPageWidth() {
        return $this->pdf->GetPageWidth();
    }
    
    function getStringWidth( $text ) {
        return $this->pdf->GetStringWidth($text);
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
        $this->pdf->setXY( $x, $y );
    }
    
    function setX( $x ) {
        $this->pdf->SetX( $x );
    }
    
    function setY( $Y ) {
        $this->pdf->SetY( $y );
    }
    
    
    function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='') {
        $this->pdf->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
    }
    
    function MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false) {
        $this->pdf->MultiCell($w, $h, $txt, $border, $align, $fill);
    }
    
    function Ln() {
        $this->pdf->Ln();
    }
    
    function write ( $text, $height = 4 ) {
        $this->pdf->Write( (int)$height, $text);
    }  
    
    function  Text($x, $y, $txt) {
        $this->pdf-> Text($x, $y, $txt);
    }
}