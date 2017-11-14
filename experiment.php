<?php
$name = 'marton';






function myName($name, $color) {
	echo "<li>my name is $name and i like color $color </li>";
}

myName('marton', 'blue');
myName('syche', 'red');
myName('xander', 'green');


$count = 1;

while($count <= 1000) {
	echo "<li>$count</li>";
	$count++;
}


?>