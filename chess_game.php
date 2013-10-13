<?php
require('chess.php');
session_start();
?><!DOCTYPE html>
<html>
<head>
<title>Chess</title>
<meta charset="UTF-8"/>
<style>
BODY {
	font-size: 20pt;
}
TABLE TR {
	height: 40px;
}
TABLE TD {
	text-align: center;
	width: 40px;
}
A {
	color: inherit;
}
</style>
</head>
<body>

<?php
if(!array_key_exists('x',$_GET)) $_GET['x']=-1;
if(!array_key_exists('y',$_GET)) $_GET['y']=-1;

if(array_key_exists('game',$_SESSION)) {
	$board=new board(0,0);
	$board->unserialize($_SESSION['game']);
}
else {
	die('You need to <a href="chess_init.php">init</a> the game first.');
}

if( array_key_exists('x',$_GET) && array_key_exists('y',$_GET) && array_key_exists('dx',$_GET) && array_key_exists('dy',$_GET) ) {
	$board->move($_GET['x'], $_GET['y'], $_GET['dx'], $_GET['dy']);
}

$_SESSION['game']=$board->serialize();

//display start
?><table border="1"><?php
for($y=0;$y<8;++$y) {
?>
	<tr>
<?php
	for($x=0;$x<8;++$x) {
		//echo '		<td>'.abbr((string)$board->get_piece($x, $y)).'</td>';
		$p=$board->get_piece($x, $y);
		//$m=$board->grid2[$y][$x];
		if($_GET['x']==$x && $_GET['y']==$y && !$board->is_empty($_GET['x'],$_GET['y'])) {
			$style=' style="background-color: lightblue;"';
			$link1='<a href="?">';
			$m='';
		}
		elseif($_GET['x']>=0 && $_GET['y']>=0 && $board->can_move($_GET['x'], $_GET['y'], $x, $y)) {
			$style=' style="background-color: lightgreen"';
			$link1='<a href="?x='.$_GET['x'].'&y='.$_GET['y'].'&dx='.$x.'&dy='.$y.'">';
			$m='X';
		}
		elseif($_GET['x']>=0 && $_GET['y']>=0 && $board->can_eat($_GET['x'], $_GET['y'], $x, $y)) {
			$style=' style="background-color: red"';
			$link1='<a href="?x='.$_GET['x'].'&y='.$_GET['y'].'&dx='.$x.'&dy='.$y.'">';
			$m='';
		}
		elseif($_GET['x']>=0 && $_GET['y']>=0 && $board->is_protecting($_GET['x'], $_GET['y'], $x, $y)) {
			$style=' style="background-color: yellow"';
			$link1='<a href="?x='.$x.'&y='.$y.'">';
			$m='';
		}
		else {
			$style='';
			$link1='<a href="?x='.$x.'&y='.$y.'">';
			$m='';
		}
		$link2='</a>';
		if($p instanceof Piece) {
			//echo '		<td>'.symb((string)$p).'</td>';
			echo '		<td'.$style.'>'.$link1.symb((string)$p).$link2.'</td>';
		}
		else {
			echo '		<td'.$style.'>'.$link1.((strlen((string)$p)>0)?$p:$m).$link2.'</td>';
		}
	}
?>	</tr><?php
}
?>
</table><?php 
//display end
?>

</body>
</html>