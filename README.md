# reddit-links
Pulls a list of domains featured on a given subreddit. Returns score total, score percentage, and domain frequency. `$limit` refers to the number of links returned per reddit API request. `$pag` refers to the number of API request pages parsed. 
## Usage
Input (driver.php):
```
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
```
Output:
```
Subreddit: politics
Limit: 100
Pagination: 1

Domain | Count Total | Count % | Score Total | Score %

thehill.com 12 11.76 54955 12.89
huffingtonpost.com 7 6.86 53475 12.55
washingtonpost.com 6 5.88 45373 10.64
msnbc.com 5 4.90 32171 7.55
commondreams.org 2 1.96 22423 5.26
thedailybeast.com 2 1.96 21621 5.07
thinkprogress.org 3 2.94 17802 4.18
nymag.com 2 1.96 9530 2.24
news.vice.com 2 1.96 9033 2.12
talkingpointsmemo.com 2 1.96 7903 1.85
cnn.com 3 2.94 5869 1.38
vice.com 2 1.96 4506 1.06
esquire.com 2 1.96 4479 1.05
usatoday.com 3 2.94 4097 0.96
rollcall.com 2 1.96 4043 0.95
businessinsider.com 2 1.96 3590 0.84
rollingstone.com 2 1.96 3354 0.79
newsweek.com 2 1.96 3140 0.74
thenation.com 2 1.96 2931 0.69
lawandcrime.com 2 1.96 2866 0.67
time.com 2 1.96 2234 0.52
apnews.com 2 1.96 2177 0.51
thecut.com 2 1.96 1682 0.39
theintercept.com 2 1.96 1481 0.35
self.politics 2 1.96 466 0.11
theweek.com 1 0.98 409 0.00
axios.com 1 0.98 662 0.00
nytimes.com 1 0.98 489 0.00
wvva.com 1 0.98 862 0.00
mainepublic.org 1 0.98 761 0.00
cnbc.com 1 0.98 740 0.00
abcnews.go.com 1 0.98 1089 0.00
newyorker.com 1 0.98 20812 0.00
progressive.org 1 0.98 1741 0.00
sltrib.com 1 0.98 838 0.00
actionnewsnow.com 1 0.98 2354 0.00
theroot.com 1 0.98 1660 0.00
npr.org 1 0.98 4746 0.00
kmov.com 1 0.98 1155 0.00
motherjones.com 1 0.98 1873 0.00
economist.com 1 0.98 2023 0.00
slate.com 1 0.98 5148 0.00
vox.com 1 0.98 2850 0.00
abovethelaw.com 1 0.98 27513 0.00
ag.ny.gov 1 0.98 1472 0.00
salon.com 1 0.98 3477 0.00
nbcnews.com 1 0.98 2473 0.00
al.com 1 0.98 2379 0.00
buzzfeednews.com 1 0.98 5650 0.00
marketwatch.com 1 0.98 6154 0.00
mcclatchydc.com 1 0.98 5355 0.00
nj.com 1 0.98 361 0.00

URL Total: 102
Unique Domain Total: 52
Score Total: 426247
```
