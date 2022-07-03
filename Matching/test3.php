<?php
include 'test2.php';

$articles = array(
	array(
		"article" => "Data Mining: Finding Similar Items", 
		"tags" => array("Algorithms", "Programming", "Mining", "Python", "Ruby")
	),
	array(
		"article" => "Blogging Platform for Hackers",  
		"tags" => array("Publishing", "Server", "Cloud", "Heroku", "Jekyll", "GAE")
	),
	array(
		"article" => "UX Tip: Don't Hurt Me On Sign-Up", 
		"tags" => array("Web", "Design", "UX")
	),
	array(
		"article" => "Crawling the Android Marketplace", 
		"tags" => array("Python", "Android", "Mining", "Web", "API")
	)
);

$dot = Similarity::dot(call_user_func_array("array_merge", array_column($articles, "tags")));

$target = array('Publishing', 'Web', 'API');

echo "Example Articles: <br>";
echo "<pre>";
print_r($dot);
echo "<pre>";

echo "<br> <br>";
echo "target article: <br>";
echo "<pre>";
print_r($target);
echo "<pre>";

foreach($articles as $article) {
	$score[$article['article']] = Similarity::cosine($target, $article['tags'], $dot);
}
asort($score);

echo "Sorted result similarity:\n";
print_r($score);
?>