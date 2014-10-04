<?
function __fsearch_gen_query($search, $args, $table){
$s_mass = explode(" ", $search);
$args = explode(" ", $args);
$query = "select * from $table where ( ";
foreach($args as $key_a=>$val_a){
	$query.= " ( ";
	foreach($s_mass as $key=>$val){
		$query.= "$val_a like('%$val%') ";
		if($key<count($s_mass)-1) $query .= "  &&  ";
	}
	if($key_a<count($args)-1) $query .= ") || ";
	else $query.= ") ";
}
$query.= ") ";
$query .= " && folder=0 order by name asc ";
return $query;
}

?>