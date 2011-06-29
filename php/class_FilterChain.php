<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class FilterChain {
    private $filters = array();

    public function addFilter(filter $filter) {
        $this->filters[] = $filter;
    }

    public function processFilters(Request $request, Response $response) {
        foreach($this->filters as $filter){
            $filter->execute($request, $response);
        }
        
    }
}
?>
