<?php
include('config.php');
include('modele.php');
$cate = new Cate(null, "example");
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" media="screen" type="text/css" title="CSS" href="design_admin.css" />
<title>Admin Cate</title>
</head>
<body>
<div id="corps">
<?php
$cate->arb();
?>
</div>
</body>
</html>