<?php

$colors_ln=array(
0=>'Red',
1=>'Black',
2=>'Yellow',
3=>'Cyan',
);//use Cyan, avoid Blue = same initials as Black

$colors_sn=array(
0=>'R',
1=>'B',
2=>'Y',
3=>'C',
);

assert(count($colors_ln)===count($colors_sn)) or die('incorrect colors array');

$pieces=array(
1,2,3,4,5,6,7,8,9,10,11,12,13,
);

$nbcolors=count($colors_ln);

$nbpieces=count($pieces);

$nbex=2;

$nbjokers=2;

$nbtiles=$nbex*$nbcolors*$nbpieces+$nbjokers;

$tiles=range(1, $nbtiles, 1);

function tile_to_string($tile) { //surjection
	global $colors_sn,$nbcolors,$nbpieces,$nbex,$nbjokers,$nbtiles;
	assert($tile>=0 && $tile<$nbtiles) or die('tile not in range');
	$str='';
	$c=(int)($tile/$nbpieces);
	$p=(int)($tile%$nbpieces);
	if($c>$nbex*$nbcolors*$nbpieces) {
		$c2=$p%$nbcolors;
		$str.=$colors_sn[$c2].'J';
	}
	else {
		$c2=$c%$nbcolors;
		$str.=$colors_sn[$c2];
		++$p;
		$str.=str_pad($p, 2, '0', STR_PAD_LEFT);
	}
	return $str;
}

function string_to_tile($string) { //injection
	global $colors_sn,$nbcolors,$nbpieces,$nbex,$nbjokers,$nbtiles;
	$s=strlen($string);
	assert($s>=2 && $s<=3) or die('invalid string size');
	$t=0;
	assert(in_array($string[0], $colors_sn)) or die('invalid string color');
	$c=array_search($string[0], $colors_sn);
	if($c===false) $t=$nbex*$nbcolors*$nbpieces;
	else $t=$c*$nbpieces;
	$p2=(int)substr($string, 1);
	assert($p2>=1 && $p2<=$nbpieces) or die('invalid string piece');
	--$p2;
	return ($t+$p2);
}

function alternate_tile($tile) { //specific case
	global $colors_sn,$nbcolors,$nbpieces,$nbex,$nbjokers,$nbtiles;
	if($nbex>=2) {
		$e=(int)($tile/$nbpieces/$nbcolors);
		if($e>=$nbtiles-$nbjokers) {
			return $tile;
		}
		$e2=($e+1)%$nbex;
		$tile+=($e2-$e)*$nbcolors*$nbpieces;
	}
	return $tile;
}

function my_assert($arg1, $arg2) {
	$r=@assert($arg1 === $arg2);
	if(!$r) {
		var_dump($arg1, $arg2);
		echo '<br/>'."\r\n";
	}
}

my_assert( tile_to_string(  0), 'R01' );
my_assert( tile_to_string( 12), 'R13' );
my_assert( tile_to_string( 13), 'B01' );
my_assert( tile_to_string( 25), 'B13' );
my_assert( tile_to_string( 26), 'Y01' );
my_assert( tile_to_string( 38), 'Y13' );
my_assert( tile_to_string( 39), 'C01' );
my_assert( tile_to_string( 51), 'C13' );

my_assert(   0, string_to_tile('R01') );
my_assert(  12, string_to_tile('R13') );
my_assert(  13, string_to_tile('B01') );
my_assert(  25, string_to_tile('B13') );
my_assert(  26, string_to_tile('Y01') );
my_assert(  38, string_to_tile('Y13') );
my_assert(  39, string_to_tile('C01') );
my_assert(  51, string_to_tile('C13') );

