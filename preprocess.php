
<?php 

class Preprocess
{
    function removeStopwords($topics){ 
        $stopwords = array('/\bI\b/i',  '/\ba\b/i', '/\babout\b/i', '/\ban\b/i',
                            '/\bare\b/i',  '/\bas\b/i', '/\bat\b/i', '/\bbe\b/i',
                            '/\bby\b/i',  '/\bcom\b/i', '/\bfrom\b/i', '/\bhow\b/i',
                            '/\bin\b/i',  '/\bis\b/i', '/\bit\b/i', '/\bof\b/i',
                            '/\bon\b/i',  '/\bor\b/i', '/\bthat\b/i', '/\bthe\b/i', 
                            '/\bthis\b/i',  '/\bto\b/i', '/\bwas\b/i', '/\bwhat\b/i',
                            '/\bwhen\b/i',  '/\bwhere\b/i', '/\bwho\b/i', '/\bwill\b/i',
                            '/\bwith\b/i',  '/\bthe\b/i', '/\bwww\b/i', '/\band\b/i',
                            );

        return preg_replace($stopwords, "", $topics);
    }

    function getTopics($result){ //get course topics from database to array
        if (mysqli_num_rows($result) > 0) {
            $topics = array();
            
            while($row = mysqli_fetch_assoc($result)  ) {
                $topics[] = $row['topic'];
            }
        }
        $t = $this->removeStopwords($topics);
        return $t; 
    }

    //COURSE TOPICS
    function courseQuery(){ 
        include 'connect-db.php';
        $query = "SELECT topic 
                    FROM course_topics 
                    WHERE course_id = 8";
        $result = mysqli_query($db, $query);
        $r = $this->getTopics($result);
        return $r;
    }

    //CERTIFICATION TOPICS
    function certQuery(){ 
        include 'connect-db.php';
        $query = "SELECT topic 
            FROM certification_topics 
            WHERE certification_id = 2";
        $result = mysqli_query($db, $query);
        $r = $this->getTopics($result);
        return $r;

        $db -> close();
    }

    function tokenizeTopics($topics){ //tokenize sentences to words per element
        foreach($topics as $topic){
            $Words[] = explode(" ", $topic);
        }

        //print_r($courseWords);
        return $Words;
    }
}

$course = new Preprocess();
$c = $course->courseQuery();
print_r($c);

echo "<br><br>";

$certification = new Preprocess();
$cert = $certification->certQuery();
print_r($cert);

?>