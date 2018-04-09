<?php
/**
*defines some commonly used utility functions

*/
class Util_model extends CI_Model{

function __construct()
{
	parent::__construct();
//	$this->load->database();	
}

function formatDate($date,$separator='.')
{
	$dateArray=explode("-",$date);
	$formatedDate=$dateArray[1].$separator.$dateArray[2].$separator.$dateArray[0];
	return $formatedDate;
}


function goToUrl($url)
{
  $str="<script language=Javascript>window.location='$url';</script>";
	print $str;
	
}

function captcha($number=6)
{
	$str="";
	$imgString="";
	for($i=0;$i<$number;$i++)
	{
		$var=mt_rand(0,9);
		$str.=$var;
		$imgString.="<img src=".base_url()."/themeF/default/images/captcha/{$var}.gif HSPACE='2'>"; 
	}	
//	$_SESSION['captchaNew']=$str;
	$newdata = array(
                   'captcha_new'  => $str
               );
	$this->session->set_userdata($newdata);
	return $imgString;

}

function generateRandom ($length)
{
	$order = "";
	$possible = "0123456789abcdefghijklmnopqrstuvwxyz"; 
	$i = 0; 
	while ($i < $length) 
	{ 
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		if (!strstr($order, $char)) 
		{ 
			$order .= $char;
			$i++;
		}
	}
	return $order;
}

function isEmail($str)
{
	if (ereg ("^.+@.+\\..+$", $str)) {
      $ret=true;
    } 
	else 
	{
      $ret=false;
    }
	return $ret;
}

function createOptions_new($query,$selValue='')
{
	//echo $query;
	//echo $selValue;
	$vset = explode(",",$selValue);
	
	$result=mysql_query($query);
	$str = '';
	if(mysql_num_rows($result) > 0)
	{
		while($row=mysql_fetch_array($result))
		{
			$value=stripslashes($row[0]);
			$name=stripslashes($row[1]);
			
			//if (strpos($selValue,$value)) 
			if(in_array($value,$vset))
			{
				$selected=" selected ";
				$str =$str . "<option value='". $value. "'" . $selected . ">". $name ." </option>" ; 
			}
			else
			{
				$selected=" ";
				$str =$str . "<option value='". $value. "'" . $selected . ">". $name ." </option>" ;
			}
			
		   //$str =$str . "<option value='". $value. "'>". $name ." </option>" ;
			
		}
	}
		
		return $str;
}

function createOptions($query,$selValue='')
{
	//echo $query;
	$result=mysql_query($query);
	$str = '';
	if(mysql_num_rows($result) > 0)
	{
		while($row=mysql_fetch_array($result))
		{
			$value=stripslashes($row[0]);
			$name=stripslashes($row[1]);
	
			if ($value==$selValue)
				$selected=" selected ";
			else
			 $selected=" ";
				 if($name);
				$str =$str . "<option value='". $value. "'" . $selected . ">". $name ." </option>" ;
			
		}
	}
		
		return $str;
}

function createNewOptions($tbl, $optVal, $optId, $setValue=''){
	/*For Admin User*/
	$where = '(status=1)';
	$this->db->select($optId,$optVal );
	$this->db->from("$tbl");
	$this->db->where($where);
	echo $query = $this->db->get();
	$rows = $query->result();
	//$this->db->last_query();

	$num_rows = $query->num_rows();
	print_r($rows);
	foreach ($rows as $row){
		print_r($row);
	}

	/*if($num_rows > 0)
	{
		while($rows)
		{
			$value=stripslashes($row[0]);
			$name=stripslashes($row[1]);

			if ($value==$selValue)
				$selected=" selected ";
			else
				$selected=" ";
			if($name);
			$str =$str . "<option value='". $value. "'" . $selected . ">". $name ." </option>" ;

		}
	}

	if ($num_rows1 === 1) {
		$row1 = $query1->row();
		return $row1;
	} else {
		return false;
	}*/
}


function createOptionsByArray ($values,$names, $selValue=false)
{
	$limit = count($values);
	for ($x=0; $x<$limit; $x++)
	{
		$value=$values[$x];
		$name=$names[$x];
		if(!$name)
			$name = $value;	
	
		if ($value==$selValue)
	 		$selected=" Selected ";
		else
	 	 $selected=" ";		
		 
		$str =$str . "<option value='". $value . "'". $selected . ">" . $name . " </option>" ;

	}
		
		return $str;
}

function footer_country_html($language='english' )
	{  
	 	$sql = "select  c.color_code, c.flag_image, cd.country_id, cd.country_name, cityd.city_name, cityd.city_id
		from ".$this->db->dbprefix('countries')." c inner join ".$this->db->dbprefix('country_details')." cd  on c.country_id = cd.country_id
		inner join ".$this->db->dbprefix('city_details')." cityd  on cityd.city_id = c.capital_id 	
		where cd.language='".$language."' AND c.status='Y' AND cityd.language='".$language."' 
		 ORDER BY cd.country_name"; 


		$query = $this->db->query($sql);					
		$rows = $query->result();
		
		$footer_str='';
		foreach($rows as $row)
		{
			if($row->country_name !='')
			{
				$country_name ="<font color='".$row->country_name."'>".$row->country_name."</font>";
				$url = site_url('country/index/'.$row->country_id);
				$country_link = "<a href='$url'>".$country_name."</a>";
				
				$city_url = site_url('city/index/'.$row->city_id);
				$city_link = "<a href='$city_url'>".$row->city_name."</a>";

				$footer_str .= "<li>".$country_link."----".$city_link."</li>";
			}
		}
		$footer = "<ul>".$footer_str."</ul>";

		return $footer;	
	}
	
function menu_pages($menu_name, $language)
{
	$condition = ' AND m.name = "'.$menu_name.'" AND cd.cmspage_page_title !="" ';
	$order_by=' mp.ordering, m.name' ; 
	$sql = "select c.*, cd.* from ".$this->db->dbprefix('menu')." m inner join ".$this->db->dbprefix('menu_pages')." mp  on m.menu_id = mp.menu_id
	inner join ".$this->db->dbprefix('cmspage_details')." cd on mp.page_id = cd.cmspage_id 
	inner join ".$this->db->dbprefix('cmspage')." c on cd.cmspage_id = c.cmspage_id 
	
	
	where cd.language='".$language."' ";		
	$sql .= $condition;	
	$sql .=" ORDER BY ".$order_by; 
	
	$query = $this->db->query($sql);					
	$rows = $query->result();
	return $rows;	
	 
	 
//	$this->load->model(ADMIN.'/cmsmenu');
	//$cmsmenu->get_data($cond);
	
}


}
?>
