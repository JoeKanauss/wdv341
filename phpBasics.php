<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php 
$yourName = "Joe Kanauss";
echo "<h1>PHP Basics</h1>";?>

<h2>
<?php
echo $yourName;
?>
</h2>

<?php
$number1 = 19;
$number2 = 42;
$total = $number1 + $number2; 
echo $number1, " + ", $number2, " = ", $total;
?>

<p><script>
<?php
$classes = array("PHP", "HTML", "Javascript");
echo "document.write('$classes[0], $classes[1], $classes[2]');";
?>
</script></p>
</body>
</html>