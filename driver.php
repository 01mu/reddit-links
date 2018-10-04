<?php

include_once 'reddit-links.php';

$sub = 'politics';
$limit = 100;
$pag = 1;

$pt = new reddit_links($sub, $limit, $pag);

$pt->sort('score_percentage');

$urls = $pt->get_arr();

printf("Subreddit: " . $sub . "\nLimit: " . $limit . "\nPagination: " . $pag);
printf("\n\nDomain | Count Total | Count %% | Score Total | Score %%\n\n");

for($i = 0; $i < count($urls); $i++)
{
    printf($urls[$i]->url . " "
        . $urls[$i]->count_total . " "
        . number_format($urls[$i]->count_percentage, 2) . " "
        . $urls[$i]->score_total . " "
        . number_format($urls[$i]->score_percentage, 2) . "\n");
}

printf("\n" . 'URL Total: ' . $pt->url_total() . "\n");
printf('Unique Domain Total: ' . $pt->unique_url_total() . "\n");
printf('Score Total: ' . $pt->score_total() . "\n");
