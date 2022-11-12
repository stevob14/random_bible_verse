<?php
random_verse();

function checkurl($url)
{
$file_headers = @get_headers($url);
if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
    $exists = false;
}
else {
    $exists = true;
}
    return $exists;
}

function bible_api($book_name,$chapter,$verse,$translation)
{
$url = 'https://bible-api.com/'.$book_name. ' '. $chapter . ':' . $verse .'?translation='. $translation;
$url = str_replace(" ", "%20", $url);
if(checkurl($url)!== false)
{
$bible_data = json_decode(file_get_contents($url));
if($bible_data!=null)
{
return $bible_data;
}
}
    else{
       return false; 
    }
}

function random_verse ()
{
$translation = "kjv";
$translation2 = "web";
$random_verse = generate($translation2);
    while ($random_verse == false)
    {
        $random_verse = generate($translation2);
    }   
	echo $random_verse[0]. '<br>' . '<u>'. $random_verse[1] .'</u>' . ' | '. '<u>'. $translation2 .'</u>'; 
}

function generate($translation)
{
//verse : 80 max
//chapter: 28 max   
//books of the bible ( New Testament )
$book_name_array = array("Matthew", "Mark", "Luke", "John", "Acts", "Romans", "1 Corinthians", "2 Corinthians", "Galatians", "Ephesians", "Philippians", "Colossians", "1 Thessalonians", "2 Thessalonians", "1 Tomothy", "2 Timothy", "Titus", "Philemon", "Hebrews", "James", "1 Peter", "2 Peter", "1 John", "2 John", "3 John", "Jude", "Revelation");

$book_name = $book_name_array[array_rand($book_name_array)]; // random book of the bible
$chapter = rand(1, chapters($book_name)); // random chapter
$verse = rand(1, 80); // random verse 
$bible_data = bible_api($book_name,$chapter,$verse,$translation);  
if($bible_data!== false)
{
$text = $bible_data->text;
$reference = $bible_data->reference;
$votd = array($text,$reference,$translation);   
return $votd;
}
    else{
      return false;  
    }
}

function chapters($book_name)
{
	if($book_name == "Matt" || $book_name == "Acts")
	{
		$chapters = "28";
	}
	if($book_name == "Mark" || $book_name == "Romans" || $book_name == "1 Corinthians")
	{
		$chapters = "16";
	}
	if($book_name == "Philemon" || $book_name == "2 John" || $book_name == "3 John" || $book_name == "Jude")
	{
		$chapters = "1";
	}
	if($book_name == "1 Thessalonians" || $book_name == "James" || $book_name == "1 Peter" || $book_name == "1 John")
	{
		$chapters = "5";
	}
	if($book_name == "Galatians" || $book_name == "Ephesians" || $book_name == "1 Tomothy")
	{
		$chapters = "6";
	}
	if($book_name == "Luke")
	{
		$chapters = "24";
	}
	if($book_name == "John")
	{
		$chapters = "21";
	}
	if($book_name == "Philippians" || $book_name == "Colossians" || $book_name == "2 Timothy")
	{
		$chapters = "4";
	}
	if($book_name == "Hebrews" || $book_name == "2 Corinthians")
	{
		$chapters = "13";
	}
	if($book_name == "2 Thessalonians" || $book_name == "Titus" || $book_name == "2 Peter")
	{
		$chapters = "3";
	}
	if($book_name == "Revelation")
	{
		$chapters = "22";
	}
	return $chapters;		
}
?>
