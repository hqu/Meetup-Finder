<html>
<body style="font-family: verdana;font-size:11px;">
<center>
    <h1>Meetup Finder</h1>
<?php
$temp_query=$_POST['query'];
$num_rsvps=$_POST['rsvps'];
$num_days=$_POST['days'];
$zipcode=$_POST['zipcode'];
if ($temp_query=="") {
	$temp_query="moms";
}
if ($num_rsvps=="") {
	$num_rsvps="2";
}
if ($num_days=="") {
	$num_days="5";
}
if ($zipcode=="") {
	$zipcode="10001";
}
echo "</center><p><form name='twSearch' id='twSearch' action='index.php' method='post'>";
echo "<div style='font-size:12px;font-color:#0C0C0C;border:#333 solid 1px;padding:8px 8px 8px 8px;background-color:#F8F8F8;width:80%;margin-left: auto;margin-right: auto;'><span style='font-weight:300;'>I am interested in <input type='text' name='query' id='query' value='$temp_query' size='22'> events</span> happening over the next <input type='text' name='days' id='days' value='$num_days' size='2'> days with at least <input type='text' name='rsvps' id='rsvps' value='$num_rsvps' size='3'> <span style='border:1px #999 solid;background-color:#EFEFEF;padding:2px 2px 2px 2px;margin:2px 2px 2px 2px;'><a href='#' onClick='document.form[0].rsvps.value=3;alert(document.form[0].rsvps.value);'>a few</a></span> <span style='border:1px #999 solid;background-color:#EFEFEF;padding:2px 2px 2px 2px;margin:2px 2px 2px 2px;'><a href='#' onClick='document.form[0].rsvps.value=3;alert(document.form[0].rsvps.value);'>many</a></span> <span style='border:1px #999 solid;background-color:#EFEFEF;padding:2px 2px 2px 2px;margin:2px 2px 2px 2px;'><a href='#' onClick='document.form[0].rsvps.value=3;alert(document.form[0].rsvps.value);'>lots</a></span>people RSVP'ed gathering near <input type='text' name='zipcode' id='zipcode' value='$zipcode' size='5'> zipcode.<br> <div style='text-align:center;padding-top:3px;font-weight:bold;font-family:tahoma'><input type='submit' name='SubmitForm' value='Search Meetups'></div></form></center></div>";

?>
<p>    
<?php
$trends_url = "https://api.meetup.com/2/open_events?key=746e1755695941746929451221477863&time=1d," . $num_days . "d&zip=" . $zipcode . "&sign=true&topic=" . $temp_query;
// initialise the session
$ch = curl_init();
// Set the URL
curl_setopt($ch, CURLOPT_URL, $trends_url);
// Return the output from the cURL session rather than displaying in the browser.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//Execute the session, returning the results to $curlout, and close.
$curlout = curl_exec($ch);
$curlout_no_html = strip_tags($curlout);
//echo $curlout_no_html;

curl_close($ch);

$myJSONFile = "JS_data.js";
$fh_json = fopen($myJSONFile, 'r');
$theJSONData = fread($fh_json, filesize($myJSONFile));
fclose($fh_json);

$data = json_decode($curlout);
//print_r($data);

  if ($data) {
    foreach ($data->results as $MUevents)
    {
      echo '<p>';
      $rsvps = $MUevents->yes_rsvp_count;
	  if ($rsvps >= $num_rsvps) {
		echo '<div style=""><div style="border:2px #D2D2D2 solid;padding:5px 5px 5px 5px;background-color:#EFEFEF;width:80%;margin-left: auto ;margin-right: auto ;">';
		$tempURL = $MUevents->event_url; 
      	echo '<h3><a href="' . $tempURL . '">' . htmlspecialchars($MUevents->name) . '</a></h3>';
      	$tempDesc = htmlspecialchars($MUevents->description);
      	echo '<div style="border:0px #CCC solid;padding:2px 2px 2px 2px;"><small><i>' . $tempDesc  . '</i></small></div>';
		echo '<p>';
		$temp_group_URL = $MUevents->group->urlname; 
		echo 'Meetup group: <b><a href="http://www.meetup.com/' . $temp_group_URL . '">' . htmlspecialchars($MUevents->group->name) . '</a></b><br />';
		echo 'RSVP\'s: <b>' . htmlspecialchars($MUevents->yes_rsvp_count) . '</b><br />';
		echo '</div></div>';
	  }
    }
  }

?>
</body>
</html>
