<!DOCTYPE html>
<html>
<head>
<title>Rummikub</title>
<meta charset="UTF-8"/>
</head>
<body>

<div><?php
$ex=array(
1,2
);
$colors=array(
'R','B','Y','C',
);
$pieces=array(
1,2,3,4,5,6,7,8,9,10,11,12,13,
);
$add=array(
'RJ','BJ'
);

$c0=count($ex);
$c1=count($colors);
$c2=count($pieces);
$c3=count($add);

$pieces_sn=array();
$pieces_ln=array();
foreach($ex as $k0=>$v0) {
	foreach($colors as $k1=>$v1) {
		foreach($pieces as $k2=>$v2) {
			$pieces_sn[]=$k0*$c1*$c2+$k1*$c2+$k2;
			$pieces_ln[]=$v0.$v1.str_pad($v2, 2, '0', STR_PAD_LEFT);
		}
	}
}
$m=max($pieces_sn);
foreach($add as $k=>$v) {
	$pieces_sn[]=$m+1+$k;
	$pieces_ln[]=$v;
}

?></div>

<table border="1">
	<tr>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>R01</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>

</body>
</html>