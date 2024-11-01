<?php
/*
Plugin Name: Solat Times
Plugin URI: http://nahrizuladib.com/wordpress/?p=675
Description: This plugin will extract the daily solat (Muslim prayer) times for a specified location based on calculations made by IslamicFinder.org. <a href="http://nahrizuladib.com/wordpress/?p=675" target="_blank">Read the instructions and its usage</a>.
Author: Nahrizul Adib Kadri
Version: 0.1
Author URI: http://nahrizuladib.com/

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/ 

//function to display solat times
function solat_times() {

//COPY AND PASTE YOUR URL FROM ISLAMICFINDER.ORG WEBSITE WITHIN 
//THE QUOTE MARKS
$islamicfinder_url = fopen("PUT_URL_HERE","r");

//YOUR CITY OR TOWN NAME
$city = "MY_CITY";















//***** DO NOT EDIT BELOW THIS LINE *******************************
//*****************************************************************
// begining of functions used to parse html
function parse($html, &$title, &$text, &$anchors)
{
  $pstring1 = "'[^']*'";
  $pstring2 = '"[^"]*"';
  $pnstring = "[^'\">]";
  $pintag   = "(?:$pstring1|$pstring2|$pnstring)*";
  $pattrs   = "(?:\\s$pintag){0,1}";

  $pcomment = enclose("<!--", "-", "->");
  $pscript  = enclose("<script$pattrs>", "<", "\\/script>");
  $pstyle   = enclose("<style$pattrs>", "<", "\\/style>");
  $pexclude = "(?:$pcomment|$pscript|$pstyle)";

  $ptitle   = enclose("<title$pattrs>", "<", "\\/title>");
  $panchor  = "<a(?:\\s$pintag){0,1}>";
  $phref    = "href\\s*=[\\s'\"]*([^\\s'\">]*)";

  $html = preg_replace("/$pexclude/iX", " ", $html);

  if ($title !== false)
    $title = preg_match("/$ptitle/iX", $html, $title)
             ? $title[1] : '';

  if ($text !== false)
  {
    $text = preg_replace("/<$pintag>/iX",   " ", $html);
    $text = preg_replace("/\\s+|&nbsp;/iX", " ", $text);
  }

  if ($anchors !== false)
  {
    preg_match_all("/$panchor/iX", $html, $anchors);
    $anchors = $anchors[0];

    reset($anchors);
    while (list($i, $x) = each($anchors))
      $anchors[$i] =
        preg_match("/$phref/iX", $x, $x) ? $x[1] : '';

    $anchors = array_unique($anchors);
  }
}

function enclose($start, $end1, $end2)
{
  return "$start((?:[^$end1]|$end1(?!$end2))*)$end1$end2";
}
// end of functions used to parse html

//retrive data. 1000 is big enough to get the content of the prayer table
//EOF doesn't work.
$i=0;
while($i<1000){
	$html_data.=fgets($islamicfinder_url);
	$i++;
}
	
//use funcion above to remove html tags
parse($html_data,$title,$text,$anchors);
	
//break content into an array
$array=explode(" ",$text);
	
//pattren to grab only time formated items
$time_pat="/^[0-9]{1,2}\:+[0-9]{2}$/";
$array=preg_grep($time_pat,$array);

//shift items to begining of array
$i=0;
$j=0;
$str="";
$flag=true;
while($flag)
{
	if($array[$i])
	{
		$prayer_times[$j]=$array[$i];
		$j++;
		if($j==6){
			$flag=false;}
	}
	$i++;
}
//end of shiftings

//separate hours and minutes for time adjustment 
	$if_times['fajr']=explode(':',$prayer_times[0]);
	$if_times['sunrise']=explode(':',$prayer_times[1]);
	$if_times['dhuhur']=explode(':',$prayer_times[2]);
	$if_times['asr']=explode(':',$prayer_times[3]);
	$if_times['maghrib']=explode(':',$prayer_times[4]);
	$if_times['isha']=explode(':',$prayer_times[5]);
	
//fajr
$final_times['fajr']=date('g:i A',mktime($if_times['fajr'][0],$if_times['fajr'][1]));

//sunrise
$final_times['sunrise']=date('g:i A',mktime($if_times['sunrise'][0],$if_times['sunrise'][1]));

//dhuhur
$final_times['dhuhur']=date('g:i A',mktime($if_times['dhuhur'][0],$if_times['dhuhur'][1]));

//asr
$final_times['asr']=date('g:i A',mktime($if_times['asr'][0]+12,$if_times['asr'][1]));

//maghrib
$final_times['maghrib']=date('g:i A',mktime($if_times['maghrib'][0]+12,$if_times['maghrib'][1]));

//isha
$final_times['isha']=date('g:i A',mktime($if_times['isha'][0]+12,$if_times['isha'][1]));


//***** DO NOT EDIT ABOVE THIS LINE *******************************
//*****************************************************************



//***** START EDIT HERE TO CHANGE THE LAYOUT **********************
//*****************************************************************
echo "

<div id='calendar_wrap'>
<table id='wp-calendar' summary='Calendar'>
	<caption>".$city."</caption>
	<thead>
	<tr>
		<th scope='col' title='Prayer'>Prayer</th>
		<th scope='col' title='Time'>Time</th>
	</tr>
	</thead>
	<tbody>
	<tr>
    		<td><strong>Fajr</strong></td>
		<td>".$final_times['fajr']."</td>
	</tr>    
	<tr>
		<td><strong>Sunrise</strong></td>
		<td>".$prayer_times[1]." AM</td>
	</tr>
	<tr>
		<td><strong>Dhuhur</strong></td>
		<td>".$final_times['dhuhur']."</td>
	</tr>
	<tr>
		<td><strong>Asr</strong></td>
		<td>".$final_times['asr']."</td>
	</tr>
	<tr>
		<td><strong>Maghrib</strong></td>
		<td>".$final_times['maghrib']."</td>
	</tr>
	<tr>
		<td><strong>Isha</strong></td>
		<td>".$final_times['isha']."</td>
	</tr>
	</tbody>
</table>
</div>











	";
}
?>