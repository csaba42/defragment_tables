<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';

$db = mysql_connect($db_host, $db_user, $db_pass) or die('Cannot connect to DB');
mysql_select_db('information_schema') or die('Cannot select information_schema');

$list_tables = "SELECT table_schema, table_name FROM information_schema.tables WHERE data_free > 0 ORDER BY table_schema ASC, table_name ASC";
$r = mysql_query($list_tables);
if (!$r) die('Query error'.mysql_error());

while ($row = mysql_fetch_assoc($r)) {
        $tables[] = $row;
}

$fragmented = count($tables);

echo "$fragmented fragmented tables found.\n";

foreach ($tables as $table){
        $name = $table['table_schema'].".".$table['table_name'];
        $query = "OPTIMIZE TABLE ".$name;
        
        echo "Optimizing $name... ";
        $ro = mysql_query($query);
        if (!$ro) $success = false;
        else $success = true;
        if ($success) echo "OK\n";
        else echo mysql_error();
}
?>
