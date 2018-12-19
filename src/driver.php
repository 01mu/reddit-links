<?php
/*
 * reddit-links
 * github.com/01mu
 */

include_once 'reddit-links.php';

$sub = 'politics';
$limit = 50;
$pag = 1;
$sort = 'count';
$type = 'domain';

$reddit = new reddit_links($sub, $limit, $pag, $sort, $type);

$arr = $reddit->arr;

foreach($arr as $itm)
{
    printf($itm->url . ': ' . $itm->count_total . "\n");
}

printf("\n" . 'Items Total: ' . $reddit->itm_total . "\n");
printf('Unique Total: ' . $reddit->unique_total . "\n");
printf('Score Total: ' . $reddit->score_total . "\n");
printf('Comments Total: ' . $reddit->comments_total . "\n");
