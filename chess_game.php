<!DOCTYPE html>
<html>
<head>
<title>Chess</title>
<meta charset="UTF-8"/>
<style>
TABLE TR {
	height: 20px;
}
TABLE TD {
	width: 20px;
}
</style>
</head>
<body>

<?php
require('chess.php');
$board=new board(8,8);
//var_dump($board->grid);
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
?><table border="1"><?php
for($y=0;$y<8;++$y) {
?>
	<tr>
<?php
	for($x=0;$x<8;++$x) {
?>		<td><?php echo $board->get_piece($x, $y); ?></td>
<?php
	}
?>	</tr><?php
}
?>
</table>



</body>
</html>