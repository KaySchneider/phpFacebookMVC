<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
class paginationViewHelper implements ViewHelper {
    public function execute($args=array()) {
        $allPages = $args[0]; $activePage = $args[1]; $url = $args[2];
            /*
         * Berechnung der ersten Hälfte
            */
        if($activePage===null) {
            $activePage = 1;
        }
        if($allPages === null)
            return null;
        $allPages = ceil($allPages['max']/PRODUCTS_PER_PAGE);
            
            if($activePage >= 1) {
                $startIndex = 1;
            }
            else {
                $startIndex = 1;
                $pagesEnd += 9;
            }
            if($pagesEnd <= $allPages ) {
                $stopIndex = $allPages;
            }
            else
                $stopIndex = $pagesEnd;

            $htmlNavi = '';
            //var_dump($startIndex, $stopIndex, $pagesStart, $pagesEnd);
            for($y=$startIndex; $y <= $stopIndex;$y++) {
                if($activePage == $y)
                    $htmlNavi .= "<a class='active'>[".$y."]</a> ";
                else
                    $htmlNavi .= "<a class='noActive' href='".$url."&p=".$y."'>[".$y."]</a> ";

            }
            return $htmlNavi;
        
    }
}
?>
