<?php
function is_black($c) {
	return ($c==='B'||$c==='Black');
}
function is_white($c) {
	return ($c==='W'||$c==='White');
}
$initials_en=array(
'Pawn'=>'',
'Rook'=>'R',
'Bishop'=>'B',
'Knight'=>'N',
'King'=>'K',
'Queen'=>'Q',
);
$initials_fr=array(
'Pawn'=>'',
'Rook'=>'T',
'Bishop'=>'F',
'Knight'=>'C',
'King'=>'R',
'Queen'=>'D',
);
abstract class Piece {
	public $x;
	public $y;
	public $color;
	public $parent;
	public function __construct(&$parent=NULL) {
		$this->parent=$parent;
	}
	public function get_possible_moves() { return array(); }
	public function can_move($diff_x, $diff_y, $multiplier=1) { return false; }
	public function can_eat($diff_x, $diff_y) { return $this->can_move($diff_x, $diff_y); }
}
class Pawn extends Piece {
	public function get_possible_moves() {
		$ar=array(array('diff_x'=>0,'diff_y'=>-1,'multiplier'=>1));
		if($this->y===6) $ar[]=array('diff_x'=>0,'diff_y'=>-2);
		return $ar;
	}
	public function can_move($diff_x, $diff_y, $multiplier=1) {
		if($this->y===6) return ($diff_x==0 && $diff_y<=-1 && $diff_y>=-2);
		else return ($diff_x==0 && $diff_y==-1);
	}
	public function can_eat($diff_x, $diff_y) {
		return (abs($diff_x)==1 && $diff_y==-1);
	}
	public function __toString() {
		return 'Pawn';
	}
}
class Rook extends Piece {
	public function get_possible_moves() {
		$ar=array(
			array('diff_x'=>0,'diff_y'=>-1,'multiplier'=>7),
			array('diff_x'=>1,'diff_y'=>0,'multiplier'=>7),
			array('diff_x'=>0,'diff_y'=>1,'multiplier'=>7),
			array('diff_x'=>-1,'diff_y'=>0,'multiplier'=>7),
		);
		return $ar;
	}
	public function can_move($diff_x, $diff_y, $multiplier=1) {
		return (
			( ($diff_x==0 && abs($diff_y)>0) || ($diff_y==0 && abs($diff_x)>0) ) &&
			$this->parent->is_free($this->x, $this->y, $this->x+$diff_x, $this->y+$diff_y)
		);
		//return ($diff_x^$diff_y>0);
	}
	public function __toString() {
		return 'Rook';
	}
}
class Knight extends Piece {
	public function get_possible_moves() {
		$ar=array(
			array('diff_x'=>1,'diff_y'=>-2),
			array('diff_x'=>2,'diff_y'=>-1),
			array('diff_x'=>2,'diff_y'=>1),
			array('diff_x'=>1,'diff_y'=>2),
			array('diff_x'=>-1,'diff_y'=>2),
			array('diff_x'=>-2,'diff_y'=>1),
			array('diff_x'=>-2,'diff_y'=>-1),
			array('diff_x'=>-1,'diff_y'=>-2),
		);
		return $ar;
	}
	public function can_move($diff_x, $diff_y, $multiplier=1) {
		return ( ( abs($diff_x)>=1 && abs($diff_x)<=2 ) && ( abs($diff_y)>=1 && abs($diff_y)<=2) && ( abs($diff_x)+abs($diff_y)==3 ) );
	}
	public function __toString() {
		return 'Knight';
	}
}
class Bishop extends Piece {
	public function get_possible_moves() {
		$ar=array(
			array('diff_x'=>-1,'diff_y'=>-1,'multiplier'=>7),
			array('diff_x'=>1,'diff_y'=>-1,'multiplier'=>7),
			array('diff_x'=>1,'diff_y'=>1,'multiplier'=>7),
			array('diff_x'=>-1,'diff_y'=>1,'multiplier'=>7),
		);
		return $ar;
	}
	public function can_move($diff_x, $diff_y, $multiplier=1) {
		return (
			( abs($diff_x)==abs($diff_y) ) && abs($diff_x)>0 &&
			$this->parent->is_free($this->x, $this->y, $this->x+$diff_x, $this->y+$diff_y)
		);
	}
	public function __toString() {
		return 'Bishop';
	}
}
class King extends Piece {
	public function get_possible_moves() {
		$ar=array(
			array('diff_x'=>-1,'diff_y'=>-1),
			array('diff_x'=>0,'diff_y'=>-1),
			array('diff_x'=>1,'diff_y'=>-1),
			array('diff_x'=>-1,'diff_y'=>0),
			array('diff_x'=>1,'diff_y'=>0),
			array('diff_x'=>-1,'diff_y'=>1),
			array('diff_x'=>0,'diff_y'=>1),
			array('diff_x'=>1,'diff_y'=>1),
		);
		return $ar;
	}
	public function can_move($diff_x, $diff_y, $multiplier=1) {
		return ( abs($diff_x)<=1 && abs($diff_y)<=1 && (abs($diff_x)+abs($diff_y)>=1) );
	}
	public function __toString() {
		return 'King';
	}
}
class Queen extends Piece {
	public function get_possible_moves() {
		$ar=array(
			array('diff_x'=>-1,'diff_y'=>-1,'multiplier'=>7),
			array('diff_x'=>0,'diff_y'=>-1,'multiplier'=>7),
			array('diff_x'=>1,'diff_y'=>-1,'multiplier'=>7),
			array('diff_x'=>-1,'diff_y'=>0,'multiplier'=>7),
			array('diff_x'=>1,'diff_y'=>0,'multiplier'=>7),
			array('diff_x'=>-1,'diff_y'=>1,'multiplier'=>7),
			array('diff_x'=>0,'diff_y'=>1,'multiplier'=>7),
			array('diff_x'=>1,'diff_y'=>1,'multiplier'=>7),
		);
		return $ar;
	}
	public function can_move($diff_x, $diff_y, $multiplier=1) {
		return (
			(abs($diff_x)==abs($diff_y)) || ($diff_x==0 && abs($diff_y)>0) || ($diff_y==0 && abs($diff_x)>0) &&
			$this->parent->is_free($this->x, $this->y, $this->x+$diff_x, $this->y+$diff_y)
		);
	}
	public function __toString() {
		return 'Queen';
	}
}
//black up (y=0), white down (y=7)
class board {
	public $grid;
	public $width;
	public $height;
	public $cur_color;
	public function __construct($width, $height) {
		$this->grid=array();
		$this->width=$width;
		$this->height=$height;
		for($i=0;$i<$this->height;++$i) {
			$this->grid[$i]=array();
			for($j=0;$j<$this->width;++$j) {
				$this->grid[$i][$j]='&nbsp;';
			}
		}
	}
	public function is_empty($x, $y) {
		return ( ! ($this->grid[$y][$x] instanceof Piece) );
	}
	public function is_free($src_x, $src_y, $dst_x, $dst_y) {
		assert( $src_x==$dst_x || $src_y==$dst_y || (abs($src_x-$dst_x)==abs($src_y-$dst_y)) );
		$diff_x=$dst_x-$src_x;
		$diff_y=$dst_y-$src_y;
		$px=$diff_x;
		if(abs($diff_x)!=0) $px/=abs($diff_x);
		$py=$diff_y;
		if(abs($diff_y)!=0) $py/=abs($diff_y);
		for($i=1; $i<max(abs($diff_x),abs($diff_y)); ++$i) {
			if(! $this->is_empty($src_x+$px*$i, $src_y+$py*$i)) return false;
		}
		return true;
	}
	public function pos_exists($x, $y) {
		return ($x>=0 && $x<$this->width && $y>=0 && $y<=$this->height);
	}
	public function get_piece($x, $y) {
		return $this->grid[$y][$x];
	}
	public function add_piece($x, $y, $piece, $c=NULL) {
		$p=new $piece($this);
		$p->x=$x;
		$p->y=$y;
		if($c!==NULL) $p->color=$c;
		else $p->color=$this->cur_color;
		$this->grid[$y][$x]=$p;
		return $p;
	}
};
?>