<?php
// ajax file

header("Content-Type: text/xml");
// xml - refresh
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
echo "<list>";

// si on récupère bien l'id à afficher et le level
if (isset($_POST["id"], $_POST['level'])) {
	include('config.php');
	include('modele.php');
	$cate = new Cate(null, "example");
	$data = $cate->getByLevel($_POST['id'], $_POST['level']);

	// les stock dans des items pour l'affichage
	for($i=0, $c=count($data); $i<$c; $i++){
		echo '<item id="'.$data[$i]['id'].'" name="'.$data[$i]["name"].'" />';
	}
}

echo "</list>";

?>