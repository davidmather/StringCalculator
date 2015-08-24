<?php
$testcases=new testcases();
class testcases
{
    function it_returns_0_for_an_empty_string(){
        add('');#0
    }

    function it_returns_a_single_number()
    {
        add("1");
	#shouldReturn(1);
    }
    function it_returns_an_error_on_negative_single_number()
    {
        add("-1");
	#shouldReturn(1);
    }

    function it_can_add_two_numbers()
    {
        add('1,2');
	#shouldReturn(3);
    }

    function it_can_add_multiple_numbers()
    {
        add('1,2,3,4,5');
	#shouldReturn(15);
    }

    function it_can_separate_numbers_by_new_lines()
    {
        add("\\\\[,][\n]\n1\n2,3",",","\n");
	#->shouldReturn(6);
    }


    function it_checks_strings_start_and_end_with_a_number()
    {
        echo "No delimeter check ";add("1,\n");echo "</br>";#should return syntax error
	echo "One delimeter check ";add("\\\\[***]\n1***\n2***3",'***');echo "</br>";#should return syntax error
	echo "Two delimeter check ";add("\\\\[***][,,,]\n1***\n2,,,3",'***',',,,');#should return syntax error
    }

    function it_ignores_numbers_above_1000()
    {
        add('1,2,1001,3');#->shouldReturn(6);	
    }

    function it_allows_any_length_delimeter()
    {
        add("\\\\[***]\n1***2***3",'***');#->shouldReturn(6);	
    }

    function it_allows_multiple_delimeters()
    {
        add("\\\\[*][%]\n1*2%3","*","%");#->shouldReturn(6);
    }

    function it_allows_multiple_delimeters_of_different_lengths()
    {
        add("\\\\[***][%]\n1***2%3","***","%");#shouldReturn(6);	
    }
    
    function it_fails_if_given_a_negative_number(){
        add("1,-2,3");#shouldReturn(6) and negative error
    }
    function it_allows_capital_letter_delimeters(){
        add("\\\\[AAA][,,,]\n1AAA2,,,3");#shouldReturn(6) and negative error
    }
}

function add($string,$delimeter1,$delimeter2){
	if(isset($string)&&("{$string}"!="")){
		if((isset($delimeter1)&&("{$delimeter1}"!=""))&&(isset($delimeter2)&&("{$delimeter2}"!="")))
		{
			$string=preg_replace("/\\\\n/", "\n", $string);
			$delimeter1=preg_replace("/\\\\n/", "\n", $delimeter1);	
			$delimeter2=preg_replace("/\\\\n/", "\n", $delimeter2);
			if((!(preg_match("/^[0-9]+$/", $delimeter1)))&&(!(preg_match("/^[0-9]+$/", $delimeter1)))){
				if (strpos($string,"\\\\[{$delimeter1}][{$delimeter2}]\n") !== false) {
					$string=str_replace("\\\\[{$delimeter1}][{$delimeter2}]\n","",$string);
					$string=str_replace("{$delimeter2}","{$delimeter1}",$string);
					if (str_replace("{$delimeter1}\n","{$delimeter}", $string)!="{$string}") {
						$syntax=" --> syntax error";
					}
					
					$string=explode($delimeter1,$string);
					$answer=0;
					$negatives="";
					$letters=array ();
					for($i=0; $i<=270; ++$i){
					if(($i>47)&&($i<58)){}
					elseif(chr($i)=="-"){}
					else array_push($letters, chr($i));
					}
					foreach($string as $value){
						if(str_replace($letters, "", $value)<1000){
							if(str_replace($letters, "", $value)<0)
							{
								$negatives=$negatives.$value;
								$value=str_replace($letters, "", $value)*-1;
								
							};
						$answer=$answer+str_replace($letters, "", $value);
						}
						else{}
					}
					echo $answer;
					if($negatives!=""){echo " ---> Error Negative Number Array ".$negatives;}
					if(isset($syntax)){echo $syntax;}
				}
				else{echo "invalid string syntax";}
			}
			else{echo "Invalid Delimeter Syntax, Delimeter cannot only contain numbers";}
		}
		elseif(isset($delimeter1)&&("{$delimeter1}"!=""))
		{
			$string=preg_replace("/\\\\n/", "\n", $string);
			$delimeter1=preg_replace("/\\\\n/", "\n", $delimeter1);	
			if((!(preg_match("/^[0-9]+$/", $delimeter1)))){
				if (strpos($string,"\\\\[{$delimeter1}]\n") !== false) {
					$string=str_replace("\\\\[{$delimeter1}]\n","",$string);
					if (str_replace("{$delimeter1}\n","{$delimeter}", $string)!="{$string}") {
						$syntax=" --> syntax error";
					}
					
					$string=explode($delimeter1,$string);
					$negatives="";
				    	$answer=0;
					$letters=array ();
					for($i=0; $i<=270; ++$i){
					if(($i>47)&&($i<58)){}
					elseif(chr($i)=="-"){}
					else array_push($letters, chr($i));
					}
					foreach($string as $value){
						if(str_replace($letters, "", $value)<1000){
							if(str_replace($letters, "", $value)<0)
							{
								$negatives=$negatives.$value.",";
								$value=str_replace($letters, "", $value)*-1;						
							};
						$answer=$answer+str_replace($letters, "", $value);
						}
						else
						{}
					}
					echo $answer;
					if($negatives!=""){echo " ---> Error Negative Number Array ".$negatives;}
					if(isset($syntax)){echo $syntax;}
				}
				else{echo "Invalid Delimeter Syntax, Delimeter cannot only contain numbers";}
				
			}
		}
		elseif($string!="")
		{
			$string=preg_replace("/\\\\n/", "\n", $string);
			$delimeter1=",";	
			$string=str_replace("\\\\[{$delimeter1}]\n","",$string);
			if (str_replace("{$delimeter1}\n","{$delimeter}", $string)!="{$string}") {
				$syntax=" --> syntax error";
			}
			
			$string=explode($delimeter1,$string);
			$negatives="";
			$answer=0;
			$letters=array ();
			for($i=0; $i<=270; ++$i){
			if(($i>47)&&($i<58)){}
			elseif(chr($i)=="-"){}
			else array_push($letters, chr($i));
			}
			foreach($string as $value){
				if(str_replace($letters, "", $value)<1000){
					if(str_replace($letters, "", $value)<0)
					{
						$negatives=$negatives.$value.",";
						$value=str_replace($letters, "", $value)*-1;						
					};
				$answer=$answer+str_replace($letters, "", $value);
				}
				else
				{}
			}
			echo $answer;
			if($negatives!=""){echo " ---> Error Negative Number Array ".$negatives;}
			if(isset($syntax)){echo $syntax;}
			

		}
		else{echo "0";}
	}
	else{echo "0";}
}
if(isset($_REQUEST['delimeter1'])&&("{$_REQUEST['delimeter1']}"!="")&&isset($_REQUEST['delimeter2'])&&("{$_REQUEST['delimeter2']}"!=""))
{
add($_REQUEST['string'],$_REQUEST['delimeter1'],$_REQUEST['delimeter2']);
}
elseif(isset($_REQUEST['delimeter1'])&&("{$_REQUEST['delimeter1']}"!=""))
{
add($_REQUEST['string'],$_REQUEST['delimeter1']);
}
elseif(isset($_REQUEST['string'])){
add($_REQUEST['string']);
}

echo "</br>Test cases</br>";
$testcases->it_returns_0_for_an_empty_string();echo "</br>";
$testcases->it_returns_a_single_number();echo "</br>";
$testcases->it_returns_an_error_on_negative_single_number();echo "</br>";
$testcases->it_checks_strings_start_and_end_with_a_number();echo"</br>";
$testcases->it_can_add_two_numbers();echo "</br>";
$testcases->it_can_add_multiple_numbers();echo "</br>";
$testcases->it_can_separate_numbers_by_new_lines();echo "</br>";
$testcases->it_ignores_numbers_above_1000();echo "</br>";
$testcases->it_allows_any_length_delimeter();echo "</br>";
$testcases->it_allows_multiple_delimeters();echo "</br>";
$testcases->it_allows_multiple_delimeters_of_different_lengths();echo "</br>";
$testcases->it_fails_if_given_a_negative_number();echo "</br>";
$testcases->it_allows_capital_letter_delimeters();echo "</br>";



?>
<form>
String<input type="text" name="string"></br>
Delimeter1<input type="text" name="delimeter1"></br>
Delimeter2<input type="text" name="delimeter2"></br>
<input type="submit">
</form>
