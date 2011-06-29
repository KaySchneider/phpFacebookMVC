<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class FrontController {
    private $resolver;
    private $preFilters;
    private $postFilters;

    public function  __construct(commandResolver $resolver) {
        $this->resolver = $resolver;
        $this->preFilters = new FilterChain();
        $this->postFilters = new FilterChain();
    }

    public function handleRequest(Request $request, Response $response) {
        $reg = registry::getInstance();
        $reg->setRequest($request);
        $reg->setResponse($response);
        
        $this->preFilters->processFilters($request,$response);

        $command = $this->resolver->getCommand($request);
        $command->execute($request,$response);

        $this->postFilters->processFilters($request,$response);
        
        $response->flush();
    }

    public function addPreFilter(filter $filter) {
        $this->preFilters->addFilter($filter);
    }

    public function addPostFilter(filter $filter) {
        $this->postFilters->addFilter($filter);
    }
}
?>
