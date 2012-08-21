<?php
	require_once("HTMLtemplate.php");
	require_once("validate.php");
	require_once("connect.php");
	$searchView = new HTML_Page("Search View","Winestore homepage",array("This","Is","The","Wine","Store"),"");
	
	$searchForm = new HTML_form();
	$searchForm->method="GET";
	$searchForm->destination="http://yallara.cs.rmit.edu.au/~s3287985/winestoreB/result.php";
	//$searchForm->action="";
	
	// setting up validator:
	
	$compareValidator1 = new ComparisonValidator("minYear","<=","maxYear");
	$searchForm->addValidator($compareValidator1);
	$numberValidator1 = new NumberValidator("stock");
	$searchForm->addValidator($numberValidator1);
	$numberValidator2 = new NumberValidator("ordered");
	$searchForm->addValidator($numberValidator2);
	
	$numberValidator3 = new NumberValidator("minPrice");
	$searchForm->addValidator($numberValidator3);
	$numberValidator4 = new NumberValidator("maxPrice");
	$searchForm->addValidator($numberValidator4);
	$comparisonValidator2 = new ComparisonValidator("minPrice","<=","maxPrice");
	$searchForm->addValidator($comparisonValidator2);
	// validate the page
	$searchForm->validate();
	
	
	
	// preparing the view components
	
	
	$wineName = new HTML_input_field();
	$wineName->type = "text";
	$wineName->name = "wineName";
	$wineName->label = HTML_label::innerText("Wine name:");
	$div1 = new HTML_div();
	$div1->class_name = "form field";
	$div1->addChild($wineName);
	$searchForm->addChild($div1);
	
	$wineryName = new HTML_input_field();
	$wineryName->type = "text";
	$wineryName->name = "wineryName";
	$wineryName->label = HTML_label::innerText("Winery name:");
	$div2 = new HTML_div();
	$div2->class_name = "form field";
	$div2->addChild($wineryName);
	$searchForm->addChild($div2);
	
	$result = mysql_query ("Select * from region", $dbconn);
	$regions = array();
	while($row = mysql_fetch_array($result,MYSQL_ASSOC))
	{
		$regions[$row["region_name"]] = $row["region_name"];
	}
	$regionList = new HTML_drop_list($regions);
	$regionList->name="region";
	$regionList->label = HTML_label::innerText("Region: ");
	$div3 = new HTML_div();
	$div3->class_name = "form field";
	$div3->addChild($regionList);
	$searchForm->addChild($div3);


	$result = mysql_query ("Select * from grape_variety", $dbconn);
	$grapes = array();
	while($row = mysql_fetch_array($result,MYSQL_ASSOC))
	{
		$grapes[$row["variety"]] = $row["variety"];
	}
	$grapeList = new HTML_drop_list($grapes);
	$grapeList->name="grape";
	$grapeList->label = HTML_label::innerText("Grape Variety: ");
	$div4 = new HTML_div();
	$div4->class_name = "form field";
	$div4->addChild($grapeList);
	$searchForm->addChild($div4);
	

	$result = mysql_query("Select min(year) as min,max(year) as max from wine", $dbconn);
	$years = array();
	$row = mysql_fetch_array($result,MYSQL_ASSOC);
	$min_year = $row["min"];
	$max_year = $row["max"];
	
	for($i=$max_year;$i>=$min_year;$i--)
	{
		$years[$i.''] = $i;
	}
	$minYearSelector = new HTML_drop_list($years);
	$minYearSelector->name="minYear";
	$minYearSelector->label = HTML_label::innerText("from ");
	$maxYearSelector = new HTML_drop_list($years);
	$maxYearSelector->name="maxYear";
	$maxYearSelector->label = HTML_label::innerText(" to ");
	
	
	$div5 = new HTML_div();
	$div5->class_name = "form field";
	$div5->addChild(HTML_label::innerText("Year: "));
	$div5->addChild($minYearSelector);
	$div5->addChild($maxYearSelector);
	$div5->addChild(HTML_label::innerText($compareValidator1->message));
	$searchForm->addChild($div5);
	
	$stock = new HTML_input_field();
	$stock->type = "text";
	$stock->name = "stock";
	$stock->label = HTML_label::innerText("Min stock: ");
	
	$div6 = new HTML_div();
	$div6->class_name = "form field";
	$div6->addChild($stock);
	$div6->addChild(HTML_label::innerText($numberValidator1->message));
	$searchForm->addChild($div6);
	
	$ordered = new HTML_input_field();
	$ordered->type = "text";
	$ordered->name = "ordered";
	$ordered->label = HTML_label::innerText("Min ordered: ");
	
	$div7 = new HTML_div();
	$div7->class_name = "form field";
	$div7->addChild($ordered);
	$div7->addChild(HTML_label::innerText($numberValidator2->message));
	$searchForm->addChild($div7);
	
	$minPrice = new HTML_input_field();
	$minPrice->type = "text";
	$minPrice->name = "minPrice";
	$minPrice->label = HTML_label::innerText("from ");
	
	$maxPrice = new HTML_input_field();
	$maxPrice->type = "text";
	$maxPrice->name = "maxPrice";
	$maxPrice->label = HTML_label::innerText(" to ");
	
	$div8 = new HTML_div();
	$div8->class_name = "form field";
	$div8->addChild(HTML_label::innerText("Price: "));
	$div8->addChild($minPrice);
	$div8->addChild($maxPrice);
	$div8->addChild(HTML_label::innerText($numberValidator3->message));
	$div8->addChild(HTML_label::innerText($numberValidator4->message));
	$div8->addChild(HTML_label::innerText($comparisonValidator2->message));
	$searchForm->addChild($div8);
	
	$submitButton = new HTML_input_field();
	$submitButton->type="submit";
	$submitButton->value="search";
	$submitButton->name="submit";
	$searchForm->addChild($submitButton);
	
	$searchView->addChild($searchForm);
	$searchView->display();
?>
