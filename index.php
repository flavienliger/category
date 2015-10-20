<?php
include('config.php');
include('modele.php');
$cate = new Cate(null, "example");
$root = $cate->getRoot();
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" media="screen" type="text/css" title="CSS" href="design_admin.css" />
<title>Admin Cate</title>
</head>
<body>
<div id="corps">

<!-- script js -->
<script type="text/javascript" src="script.js"></script>

<table width="680">
<!-- première ligne -->
<tr>
<td>Catégorie lv0</td>
<td>Catégorie lv1</td>
<td>Catégorie lv2</td>
<td>Catégorie lv3</td>
</tr>

<tr>
<td><select id="cate0" onchange="request(this, 0), effacer()" size="6">
<?php for($i=0, $c=count($root); $i<$c; $i++){
	echo '<option value="'.$root[$i]['id'].'">'.$root[$i]['name'].'</option>';
}?>
</select>
</td>
<!-- catégorie lv n+1 -->
<td><select id="cate1" onchange="request(this, 1), effacer()" size="6"></select></td>
<td><select id="cate2" onchange="request(this, 2), effacer()" size="6"></select></td>
<td><select id="cate3" size="6" ></select></td>
</tr>

<!-- boucle les images add / edit / del -->
<tr>
<?php for($i=0; $i<4; $i++){?>
<td>
<img src="admin/add.png" width="16" height="16" onclick="add(<?php echo $i; ?>)" />
<input type="image" alt="Envoyer" width="16" height="16" src="admin/delete.png" onclick="del(<?php echo $i; ?>)" />
<img src="admin/edit.png" width="16" height="16" onclick="edit(<?php echo $i; ?>)" />
</td>
<?php }?>
</tr>

</table>

<!-- loader ajax -->
<img id="loader" style="display:none" src="loading.gif" alt="Chargement" />

<form id="formulaire" action="index.php" method="post">
<!-- champ caché -->
<input type="hidden" id="delete" name="delete" value="" /><!-- true / false -->
<input type="hidden" id="idCate" name="idCate" value="" /><!-- id catégorie sélec -->
<input type="hidden" id="typeCate" name="typeCate" value="" /><!-- catégorie lv n -->

<!-- champ d'ajout / d'edit / submit -->
<p class="cache" id="add">Ajouter : <input type="text" name="add" value="" /></p>
<p class="cache" id="edit">Editer : 
<input type="text" name="edit" value="" /></p>
<p class="cache" id="submit"><input type="submit" value="Modifier/Ajouter" /></p>
</form>


<?php 

/* TRAITEMENT */
/* ---------- */

if(isset($_POST['idCate'], $_POST['typeCate'])){
	if(!empty($_POST['add'])){
		$cate->add($_POST['typeCate'], $_POST['add'], $_POST['idCate']);
	}
	if(!empty($_POST['edit'])){
		$cate->edit($_POST['idCate'], $_POST['edit']);
	}
	if(!empty($_POST['delete'])){
		$cate->remove($_POST['idCate']);
	}
	?><script type="text/javascript">window.location='index.php';</script><?php
}


?>			
</div>
</body>
</html>