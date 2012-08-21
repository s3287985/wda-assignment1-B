<?php

class SearchQuery
{
	var $query;
	var $resultTable;
	var $connection;
	function __construct($query,$resultTable,$connection)
	{
		$this->query = $query;
		$this->resultTable = $resultTable;
		$this->connection = $connection;
	}
	function query(){
		$result = mysql_query($this->query, $this->connection);
		$count = mysql_num_rows($result);
		if($count > 0)
		{
			 while($row = mysql_fetch_array($result,MYSQL_ASSOC))
			{
					$table_row = new HTML_table_row();
					$table_row->class_name="data_row";
					foreach($row as $field)
					{
						$cell = new HTML_table_cell();
						$cell->addChild(HTML_label::innerText($field));
						$table_row->addChild($cell);
					}
					$this->resultTable->addChild($table_row);
			}
		}
		else
		{
			$table_row = new HTML_table_row();
			$cell = new HTML_table_cell();
			$cell->addChild(HTML_label::innerText("No results found!"));
			$table_row->addChild($cell);
			$this->resultTable->clear();
			$this->resultTable->addChild($table_row);
		}
		
	}
}
?>