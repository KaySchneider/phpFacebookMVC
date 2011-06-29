<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * bekommt einen String und erstellt daraus eine HTML DATEi auf dem
 * server!
 * Mittels unlink wird es gelöscht!
 */
class tempHtmlFile {
    private $htmlFile;
    private $tempDir;
    private $htmlString;

    public function  __construct($htmlString, $htmlFile, $tempDir) {
        $this->htmlString = $htmlString;
        $this->htmlFile = $htmlFile;
        $this->tempDir = $tempDir;
        $this->writeHtml();
    }

    private function writeHtml() {
        $file = fopen($this->tempDir . DIRECTORY_SEPARATOR . $this->htmlFile.'.html', 'a');
        fwrite($file, $this->htmlString);
        fclose($file);
        unset($file);
    }

    public function unlinkMe() {
        return unlink($this->tempDir . DIRECTORY_SEPARATOR . $this->htmlFile.'.html');
    }


}
?>
