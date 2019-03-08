<?php
require_once ('header.php');

$notes = $Note->get_my_note_items();

echo '<table>';
$schet = 1;
echo '<div  >	<h1 align="center" style="color: white; padding-top: 30px;">List of got tasks</h1>
<table style="overflow: auto;overflow: auto;    margin-bottom: 50px;" width="100%" bordercolor="black" frame="void" cellspacing="0" cellpadding="4" border="1">
';
echo '<tr style="color: white; font-size: 25px; text-align: center;"><td width="5%"><b>№</b></td><td width="25%"><b>Title</b></td><td width="70%"><b>Description</b></td></tr>';
foreach ($notes as $note) {
    echo '<tr><td align="center">'.$schet.'</td><td>'.$note['title'].'</td><td><div style="width: 100%;
		height: auto; text-align: center;">'.$note['description'].'</div></td></tr>';
    $schet += 1;
}

echo '</table>';


require_once ('footer.php');
?>
