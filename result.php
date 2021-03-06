<?php
require_once("HTMLtemplate.php");
require_once("connect.php");
require_once("queryProcessor.php");
$page = new HTML_Page("Winestore","winestore result",array("This","Is","The","Wine","Store"),"connect-style.css");

// setting up result table
$resultTable = new HTML_table();
$resultTable->class_name = "search_result";
$table_header_row = new HTML_table_row();
$table_fields = array("Wine name","Variety","Year","Winery name","Region","Price","Stock","Ordered","Revenue");
foreach($table_fields as $field)
{
		$cell = new HTML_table_header();
		$cell->addChild(HTML_label::innerText($field));
		$table_header_row->addChild($cell);
}
$resultTable->addChild($table_header_row);

// accessing the database		
/**/

/* query as a regular select query*/
$query = 
"SELECT * from wine_detail as wd
WHERE
('".$_GET["wineName"]."'='' OR wd.wine_name LIKE '%".$_GET["wineName"]."%') AND
('".$_GET["wineryName"]."'='' OR wd.winery_name LIKE '%".$_GET["wineryName"]."%') AND
('".$_GET["region"]."'='All' OR region_name LIKE '%".$_GET["region"]."%') AND
('".$_GET["grape"]."'='' OR variety LIKE '%".$_GET["grape"]."%') AND
year>=".$_GET["minYear"]." AND year<=".$_GET["maxYear"]." AND stock>=".($_GET["stock"]!=''?$_GET["stock"]:0)." AND sold>=".($_GET["ordered"]!=''?$_GET["ordered"]:0)."
AND cost>=".($_GET["minPrice"]!=''?$_GET["minPrice"]:0)." AND cost<=".($_GET["maxPrice"]!=''?$_GET["maxPrice"]:"9999")."
";

//processing query result
$searchQuery =  new SearchQuery($query,$resultTable, $dbconn);
$searchQuery->query();
$page->addChild($resultTable);
$page->display();
?>
