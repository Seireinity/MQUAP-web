<?php
include 'similarity.php';
include 'BruteForce.php';

$wordsTarget = $word; //identical words
$certifications = $y; //certification content

$articles = $certifications;

$dot = Similarity::dot(call_user_func_array("array_merge", array_column($articles, "tags")));

echo "Certifications: <br>";
echo "<pre>";
//print_r($articles);
echo "<pre>";
echo "<br>";

echo "<br><br>";
echo "Target words: <br>";
echo "<pre>";
//print_r($wordsTarget);
echo "<pre>";

foreach($articles as $article) {
	$score[$article['certification']] = Similarity::cosine($wordsTarget, $article['tags'], $dot);
}
//asort($score);

echo "<br> <br>";
echo "Sorted result similarity:";

for($i=0; $i<count($test); $i++){
	$y[]["certification"] = $test[$i]['name'];
	$y[$i]["tags"] = $sample[$i]; //need to add tags to certification array
	$y[$i]["tags"] = explode(" ", $y[$i]["tags"]);
}

foreach($score as $x => $x_value) {
	$percentage[] = round($x_value * 100, 2);
	echo "<br>";
}

//echo "<br> <br>";
//echo $score->$certifications;
//$percentage = $score * 100;
                          
echo "<pre>";
print_r($score);
echo "<pre>"; 

?>
