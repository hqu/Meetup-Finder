<html>
<body>
    <h1>Meetup Finder</h1>
<?php
echo "Search for a Meetup that matches your interests";

$myFile = "raw_data.xml";
$fh = fopen($myFile, 'r');
$theString = fread($fh, filesize($myFile));
fclose($fh);
//echo $theString;



$splitter = "yes_rsvp_count>";
$string_array = split($splitter, $theString);

?>
</body>
</html>

