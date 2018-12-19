# reddit-links
Pulls a list of domains featured on a given subreddit. Returns score total, score percentage, and domain frequency.
## Usage
Return top 10 most popular domains ordered by `count` from reddit's /r/politics recent posts.
* `$sub`: A chosen subreddit.
* `$limit`: The number of links returned per reddit API request (max = 100).
* `$pag`: The number of API request pages parsed (max = 10).
* `$sort`: Sort in descending order. Possible values are `count`, `score`, and `comments`.
* `type`: Type of content to return. Either `domain` or `author`.
```php
<?php
include_once 'reddit-links.php';

$sub = 'politics';
$limit = 10;
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
```
```
self.politics: 1
thinkprogress.org: 1
rollcall.com: 1
washingtonpost.com: 2
politifact.com: 1
motherjones.com: 1
kansascity.com: 1
bloomberg.com: 1
independent.co.uk: 1
msnbc.com: 1

Items Total: 11
Unique Total: 10
Score Total: 108109
Comments Total: 6629
```
