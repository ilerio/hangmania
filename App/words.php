<?php
$word_file = fopen("words/words.txt", "r");
$max = 4341; // number of words in the file
$line_num = rand(1, $max);
for ($i = 0; $i <= $line_num; $i++)
{
    $word = fgets($word_file);
}
fclose($word_file);
echo $word;
?>