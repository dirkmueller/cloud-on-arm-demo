<?php
$add = -1;

if (isset($_REQUEST["up"])) {
    $add = intval($_REQUEST["up"]);
}

$myfile = fopen("demo.json", "r") or die("Unable to open input file!");
$myoutfile = fopen("demo.json.new", "w") or die("Unable to open output file!");
$myphpfile = fopen("demo.json.php.new", "w") or die("Unable to open output file!");
# Write php header
fputs($myphpfile, '<?php header("Access-Control-Allow-Origin: * "); ?>');
# Read { line
$line = fgets($myfile);
# Write { line
fputs($myoutfile, $line);
fputs($myphpfile, $line);
# Read first data line
$line = fgets($myfile);
$counter = 0;
$lastline = "";
# Read other data lines and copy them
while (($line = fgets($myfile)) !== false) {
  # "17:03:15.042":5

  $tline = trim($line);

  if ($tline == "}")
    break;

  $lastline = $tline;

  if (substr($tline, -1) != ",")
    $line = $tline . ",\n";

  fputs($myoutfile, $line);
  fputs($myphpfile, $line);
}

list($foo, $datestr, $counter) = explode("\"", $lastline);
list($counter) = sscanf($counter, ':%d');

$counter = $counter + $add;
if ($counter < 0)
  $counter = 0;

$usec = microtime(true);

fputs($myoutfile, sprintf("\"%s\":%d\n", strftime("%T.") . str_replace('0.', '', sprintf('%.1f', $usec - floor($usec))), $counter));
fputs($myoutfile, "}\n");

fputs($myphpfile, sprintf("\"%s\":%d\n", strftime("%T.") . str_replace('0.', '', sprintf('%.1f', $usec - floor($usec))), $counter));
fputs($myphpfile, "}\n");

fclose($myfile);
fclose($myoutfile);
fclose($myphpfile);

rename("demo.json.new", "demo.json");
rename("demo.json.php.new", "demo.json.php");

?>
