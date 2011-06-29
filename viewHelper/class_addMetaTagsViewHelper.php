
<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class addMetaTagsViewHelper implements ViewHelper {
    public function execute($args=array()) {
        $reg = registry::getInstance();
        $metaTags = $reg->getMetaTag();
        if(!$metaTags || !is_array($metaTags)) {
            return '';
        }
        else {
            $returnTagString = '';
            foreach($metaTags as $metaTag) {
                $returnTagString .= "<meta property=\"{$metaTag['property']}\" content=\"{$metaTag['content']}\" />";
            }
        }
        return $returnTagString;
    }
}
?>

