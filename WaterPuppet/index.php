<?php
require_once( "sparqllib.php" );
 
$db = sparql_connect( "http://localhost:3030/dsPuppet/sparql" );
if( !$db ) { print $db->errno() . ": " . $db->error(). "\n"; exit; }

$ten_item = isset($_GET['ten_item']) ? $_GET['ten_item'] : '';
$PREFIX= 'PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX owl: <http://www.w3.org/2002/07/owl#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
PREFIX data: <http://www.semanticweb.org/ontologies/2020/Water_puppet#>';

$fetch_data =$PREFIX.'SELECT DISTINCT  *
	WHERE { 
  	FILTER regex(?item_name, "'.$ten_item.'", "i")
  	?a ?b ?item_name.
  	{
    {?a data:ten_vo_roi ?item_name.}
    union
    {?a data:ten_roi ?item_name.}
    union
    {?a data:ten_nhac_cu ?item_name.}
  	}

  	
  
}';
$sparql = $fetch_data;
$result = $db->query( $sparql ); 
if( !$result ) { print $db->errno() . ": " . $db->error(). "\n"; exit; }
 
$fields = $result->field_array( $result );
/*
print "<p>Number of rows: ".$result->num_rows( $result )." results.</p>";
print "<table class='example_table'>";
print "<tr>";
foreach( $fields as $field )
{
	print "<th>$field</th>";
}
print "</tr>";
while( $row = $result->fetch_array() )
{
	print "<tr>";
	foreach( $fields as $field )
	{
		print "<td>$row[$field]</td>";
	}
	print "</tr>";
}
print "</table>";
*/


?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>
<body>
<form style="width: 100%;">
	<h2 style="width: 260px;margin: auto;">Searching things</h2>
	<div style="margin: auto;width: 400px;margin-top: 50px;margin-bottom: 50px;">
		<input 	style=" height: 35px;width: 285px;position: relative;top: 3px; border-radius: 2px;" type="text" name="ten_item"  placeholder="<?php echo $ten_item ?>">
		<button type="submit" class="btn btn-success">Search</button>
	</div>
</form>
<div>
	<?php  
	if($ten_item!=''){
	echo "<ul class='list-group'>";
	while( $row = $result->fetch_array() )
    {
    	echo '<li class="list-group-item"><a href="./itemDetail.php?item_name='.$row['item_name'].'" target="_blank">';
    	echo $row['item_name'];
    	echo '</a></li>';
    	

	}
	echo "</ul>";
	
}
	?>
</div>
</body>
</html>
<?php

    function after ($that, $inthat)
    {
        if (!is_bool(strpos($inthat, $that)))
        return substr($inthat, strpos($inthat,$that)+strlen($that));
    };

    

// use strrevpos function in case your php version does not include it
function strrevpos($instr, $needle)
{
    $rev_pos = strpos (strrev($instr), strrev($needle));
    if ($rev_pos===false) return false;
    else return strlen($instr) - $rev_pos - strlen($needle);
};
?>