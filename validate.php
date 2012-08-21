<?php
require_once("HTMLtemplate.php");

class NumberValidator extends Validator
{
	var $inputField;
	function __construct($validatedField){
		$this->inputField = $validatedField;
	}
	function validate(){
		
		$fieldValue = $_REQUEST[$this->inputField];
		if(!is_numeric($fieldValue)&&$fieldValue!="")
		{
			$this->message="*{$this->inputField} must be a number";
			$this->valid=false;
		}
		return $this->valid;
	}
	
}
class ComparisonValidator extends Validator
{
	var $inputField1;
	var $inputField2;
	var $operator;
	function __construct($field1,$operator,$field2)
	{
		$this->inputField1 = $field1;
		$this->inputField2 = $field2;
		$this->operator = $operator;
	}
	function validate(){
		$this->valid=true;
		$field1 = $_REQUEST[$this->inputField1];
		$field2 = $_REQUEST[$this->inputField2];
		if($field1!=""&&$field2!=""){
			if($this->operator==">"){
				if(!($field1>$field2))
				{
					$this->message="*{$this->inputField1} must be greater than {$this->inputField2}";
					$this->valid=false;
				}
			}
			if($this->operator=="<"){
				if(!($field1<$field2))
				{
					$this->message="*{$this->inputField1} must be less than {$this->inputField2}";
					$this->valid=false;
				}
			}
			if($this->operator==">="){
				if(!($field1>=$field2))
				{
					$this->message="*{$this->inputField1} must be greater than or equal to {$this->inputField2}";
					$this->valid=false;
				}
			}
			if($this->operator=="<="){
				if(!($field1<=$field2))
				{
					$this->message="*{$this->inputField1} must be less than or equal to {$this->inputField2}";
					$this->valid=false;
				}
			}
		}
 	return $this->valid;
	}
}
class Validator
{
	var $message;
	var $page;
	var $valid = true;
	function validate(){}
}

?>
