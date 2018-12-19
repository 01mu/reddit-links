# reddit-links
Pulls a list of domains or users featured on a given subreddit. Returns score and comment information for domains or users.
## Usage
Return the top 50 most popular domains ordered by `count` from the most recent posts on reddit's /r/politics.
* `$sub`: A chosen subreddit.
* `$limit`: The number of links returned per reddit API request (max = 100).
* `$pag`: The number of API request pages parsed (max = 10).
* `$sort`: Sort in descending order. Possible values are `count`, `score`, and `comments`.
* `type`: Type of content to return. Possible are values `domain` and `author`.
```php
<?php
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
```
```
washingtonpost.com: 7
thehill.com: 5
cnn.com: 3
www-m.cnn.com: 1
politico.com: 1
vanityfair.com: 1
reuters.com: 1
esquire.com: 1
washingtonmonthly.com: 1
huffingtonpost.com: 1
buzzfeednews.com: 1
abcnews.go.com: 1
treasury.gov: 1
nydailynews.com: 1
nj.com: 1
theroot.com: 1
self.politics: 1
businessinsider.com: 2
thinkprogress.org: 1
marketwatch.com: 2
cnbc.com: 2
cbsnews.com: 1
talkingpointsmemo.com: 2
sfexaminer.com: 1
thedailybeast.com: 1
msnbc.com: 2
independent.co.uk: 1
kansascity.com: 1
bloomberg.com: 1
motherjones.com: 1
politifact.com: 2
rollcall.com: 1
axios.com: 1

Items Total: 51
Unique Total: 33
Score Total: 273532
Comments Total: 19923
```
