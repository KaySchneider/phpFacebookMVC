<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


?>
<?php
    if(is_array($this->vars['likes'])) {
?>
<div class="fb">
    <a href="?mode=likes">Ich möchte neue Likes! Starte den LikeOMator nochmals</a>
</div>
<table>
   <?php
    foreach($this->vars['likes'] as $like) {
        ?>
    <tr class="fb">
        <td >
            <img src="<?php print $like['picture'] ?>"
        </td>
        <td>
            <div class="fb6">
            <h3><?php print $like['name']?></h3>
            </div>
        </td>

    <td>
        Beschreibung:<br/>
    <p >
        <?php
            print $like['description'];
        ?>
    </p>
    <p>
        <a target="_blank" href="<?php print $like['link']?>">Zur Seite</a>
    </p>
    </td>
    </tr>
    <tr>
        <td colspan="3">
            <fb:like href="<?php print $like['link'] ?>" show_faces="true" width="200" font="tahoma"></fb:like>
        </td>
    </tr>
    <tr style="height:25px">
        <td colspan="3"><h3/></td>
    </tr>
        <?php
    }
   ?>
   
</table>

<?php
    }
else {
    print "<b>uuuups irgendwie konnte der likeOMator dir kein like erzeugen.... WTF!!! FUCK !!! SHIT...! Der likeOMator wird sich in kürze selbstzerstören!</b>";
}
?>