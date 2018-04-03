<?php include "../config.php"; ?>
<?php

$opFile ="data/blog/blogfile.txt";

$fp =fopen($opFile,"r") or die("Error Reading File"); 

  while (!feof($fp)) {
	  
	  $posts[] =fgets($fp);
  }
fclose($fp); 

$no_of_posts =count($posts)-1;
$records =$no_of_posts;
$max_links = 30;

if ($records > $max_links)
	$limit = $records-$max_links;
else
	$limit = 0;

echo '<?xml version="1.0" encoding="utf-8"?>' . "\n" ;
echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n" ;
echo '<channel>' . "\n\n" ;

echo "<title>$blog_title</title>" . "\n";
echo "<link>$blog_url</link>" . "\n";
echo "<description>$blog_description</description>" . "\n";
echo '<language>en-us</language>' . "\n\n";

for ($n=$records  ;  $n>=$limit  ;  $n-- ) { 

  $blog =explode("|", $posts[$n]);
  
  if (isset($blog[2]) && $blog[2] !='') 
   { 
   	 $post_id =$n+1;
	 echo '<item>' . "\n" ;
	 echo '<title>' . $blog[3] . '</title>' . "\n";
	 echo '<link>' . $blog_url .'?d='. $blog[0] .'</link>' . "\n";
	 echo "<description><![CDATA[" . str_replace("##more##", "", $blog[4]) . "]]></description>" . "\n";
	 echo '<pubDate>' . $blog[2] . '</pubDate>' . "\n";
	 echo '<guid isPermaLink="true">' . $blog_url .'?d='. $blog[0] .'</guid>' . "\n";
	 echo '</item>' . "\n\n";

   }
   else{
	 continue;   
   }
}

echo "\n\n" . '</channel>';
echo "\n" . '</rss>';

?>