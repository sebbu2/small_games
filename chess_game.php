<!DOCTYPE html>
<html>
<head>
<title>Chess</title>
<meta charset="UTF-8"/>
<style>
BODY {
	font-size: 20pt;
}
TABLE TR {
	height: 35px;
}
TABLE TD {
	text-align: center;
	width: 35px;
}
A {
	color: inherit;
}
</style>
</head>
<body>

<?php
require('chess.php');
if(!array_key_exists('x',$_GET)) $_GET['x']=-1;
if(!array_key_exists('y',$_GET)) $_GET['y']=-1;
$board=new board(8,8);
//var_dump($board->grid);

//init start
$board->cur_color='W';
$h=7;
	$board->add_piece(0, $h, 'Rook');
	$board->add_piece(1, $h, 'Knight');
	$board->add_piece(2, $h, 'Bishop');
	$board->add_piece(3, $h, 'Queen');
	$board->add_piece(4, $h, 'King');
	$board->add_piece(5, $h, 'Bishop');
	$board->add_piece(6, $h, 'Knight');
	$board->add_piece(7, $h, 'Rook');
--$h;
	for($i=0;$i<8;++$i) {
		$board->add_piece($i, $h, 'Pawn');
	}
$board->cur_color='B';
$h=0;
	$board->add_piece(0, $h, 'Rook');
	$board->add_piece(1, $h, 'Knight');
	$board->add_piece(2, $h, 'Bishop');
	$board->add_piece(3, $h, 'Queen');
	$board->add_piece(4, $h, 'King');
	$board->add_piece(5, $h, 'Bishop');
	$board->add_piece(6, $h, 'Knight');
	$board->add_piece(7, $h, 'Rook');
++$h;
	for($i=0;$i<8;++$i) {
		$board->add_piece($i, $h, 'Pawn');
	}
//init end

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
		if($_GET['x']==$x && $_GET['y']==$y) {
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