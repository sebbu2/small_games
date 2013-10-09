<?php
require('chess.php');
session_start();

unset($_SESSION['game']);

//init start
if(!array_key_exists('game',$_SESSION)||strlen($_SESSION['game'])<=2) {
	$board=new board(8,8);
	
	$board->add_piece(0, 7, 'Rook', 'W');
	$board->add_piece(1, 7, 'Knight', 'W');
	$board->add_piece(2, 7, 'Bishop', 'W');
	$board->add_piece(3, 7, 'Queen', 'W');
	$board->add_piece(4, 7, 'King', 'W');
	$board->add_piece(5, 7, 'Bishop', 'W');
	$board->add_piece(6, 7, 'Knight', 'W');
	$board->add_piece(7, 7, 'Rook', 'W');
	for($i=0;$i<8;++$i) {
		$board->add_piece($i, 6, 'Pawn', 'W');
	}
	$board->add_piece(0, 0, 'Rook', 'B');
	$board->add_piece(1, 0, 'Knight', 'B');
	$board->add_piece(2, 0, 'Bishop', 'B');
	$board->add_piece(3, 0, 'Queen', 'B');
	$board->add_piece(4, 0, 'King', 'B');
	$board->add_piece(5, 0, 'Bishop', 'B');
	$board->add_piece(6, 0, 'Knight', 'B');
	$board->add_piece(7, 0, 'Rook', 'B');
	for($i=0;$i<8;++$i) {
		$board->add_piece($i, 1, 'Pawn', 'B');
	}
	
	//$board->add_piece(5, 5, 'Queen', 'W'); //help demonstration
	
	$_SESSION['game']=$board->serialize();
}
assert($board instanceof board) or die('session/serializable error.');
//init end
print('<a href="javascript:history.go(-1);">done</a>');
?>