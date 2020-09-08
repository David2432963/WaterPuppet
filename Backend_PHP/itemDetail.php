<?php  
	require_once( "sparqllib.php" );
 
$db = sparql_connect( "http://localhost:3030/dsPuppet/sparql" );
if( !$db ) { print $db->errno() . ": " . $db->error(). "\n"; exit; }

$ten_item = isset($_GET['item_name']) ? $_GET['item_name'] : '';
$PREFIX= 'PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX owl: <http://www.w3.org/2002/07/owl#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
PREFIX data: <http://www.semanticweb.org/ontologies/2020/Water_puppet#>';

$fetch_data =$PREFIX.'SELECT DISTINCT *
	WHERE {
	FILTER regex(?item_name, "'.$ten_item.'", "i")
  	?item ?x ?y.
  	{
  	{?item data:ten_roi ?item_name.}
  	union
  	{?item data:ten_vo_roi ?item_name.}
    union
    {?item data:ten_nhac_cu ?item_name.}
  	}
  	?item ?x ?y.
}';
$sparql = $fetch_data;
$result = $db->query( $sparql ); 
if( !$result ) { print $db->errno() . ": " . $db->error(). "\n"; exit; }
 
$fields = $result->field_array( $result );





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
<?php

  echo '<div class="flex">';
while( $row = $result->fetch_array() )
{

  

    if($row['x']=="http://www.semanticweb.org/ontologies/2020/Water_puppet#ten_vo_roi"){
      echo '<div class="a">';
      echo "<h2>";
      echo $row['y'];
      echo "</h2>";
      echo '</div>';
    }
    if($row['x']=="http://www.semanticweb.org/ontologies/2020/Water_puppet#ten_nhac_cu"){
      echo '<div class="a">';
      echo "<h2>";
      echo $row['y'];
      echo "</h2>";
      echo '</div>';
    }
    if($row['x']=="http://www.semanticweb.org/ontologies/2020/Water_puppet#ten_roi"){
      echo '<div class="a">';
      echo "<h2>";
      echo $row['y'];
      echo "</h2>";
      echo '</div>';
    }
    if($row['x']=="http://www.semanticweb.org/ontologies/2020/Water_puppet#anh"){
      echo "<div class='b'>";
      echo '<img src="'.$row['y'].'"';
      echo "</div>";
      }    
    if($row['x']=="http://www.semanticweb.org/ontologies/2020/Water_puppet#mo_ta"){
      echo "<div class='c'>";
      echo '<b>Mô tả: </b>';
      echo $row['y'];
      echo "</div>";
      }
      if($row['x']=="http://www.semanticweb.org/ontologies/2020/Water_puppet#tham_gia_vao"){
      	$fetch_data =$PREFIX.'SELECT DISTINCT *
  		WHERE {
 		<'.$row['y'].'> data:ten_vo_roi ?ten_vo_roi.
		}';
		$sparql = $fetch_data;
		$tham_gia_vao = $db->query( $sparql ); 
		if( !$tham_gia_vao ) { print $db->errno() . ": " . $db->error(). "\n"; exit; }
      		echo "<div class='d'>";
      echo '<u>Tham gia vào vở   </u>';
      		while ($tens = $tham_gia_vao->fetch_array()) {
      			# code...
      			echo '<a href="/TestingRDF/itemDetail.php?item_name='.$tens['ten_vo_roi'].'" target="_blank">';
    			echo $tens['ten_vo_roi'];
    			echo '</a>';
      		}
      echo "</div>";
      }
      if($row['x']=="http://www.semanticweb.org/ontologies/2020/Water_puppet#bao_gom"){

      	$fetch_data =$PREFIX.'SELECT DISTINCT *
  		WHERE {
 		<'.$row['y'].'> data:ten_roi ?ten_roi.
		}';
		$sparql = $fetch_data;
		$tham_gia_vao = $db->query( $sparql ); 
		if( !$tham_gia_vao ) { print $db->errno() . ": " . $db->error(). "\n"; exit; }
      		
      		echo "<div class='d'>";
      		
      		echo '<u>bao gồm   </u>';
      		while ($tens = $tham_gia_vao->fetch_array()) {
      			# code...
      			echo '<a href="/TestingRDF/itemDetail.php?item_name='.$tens['ten_roi'].'" target="_blank">';
    			echo $tens['ten_roi'];
    			echo '</a>';
      		}
      		
      		echo "</div>";
      }	
  
}
  echo '</div>';


 ?>
</body>
</html>
