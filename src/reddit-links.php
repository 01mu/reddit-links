<?php
/*
 * reddit-links
 * github.com/01mu
 */

class reddit_item
{
    public $url;

    public $count_percentage;
    public $score_percentage;
    public $comments_percentage;

    public $count_total;
    public $score_total;
    public $comments_total;
}

class reddit_links
{
    private $url_base;
    private $data;
    private $pages;

    public $itm_array = array();
    public $arr = array();

    public $thread_total = 0;
    public $unique_total = 0;
    public $itm_total = 0;
    public $score_total = 0;
    public $comments_total = 0;

    public function reddit_links($sub, $limit, $pag, $sort, $type)
    {
        $this->url_base = 'https://www.reddit.com/r/' . $sub
            . '/hot/.json?limit=' . $limit;

        $this->get_threads($pag, $type);
        $this->struct();
        $this->sort($sort);
    }

    public static function sort_count($a, $b)
    {
        return $a->count_percentage < $b->count_percentage;
    }

    public static function sort_score($a, $b)
    {
        return $a->score_percentage < $b->score_percentage;
    }

    public static function sort_comments($a, $b)
    {
        return $a->comments_percentage < $b->comments_percentage;
    }

    public function sort($type)
    {
        switch($type)
        {
            case 'count':
                usort($this->arr, array('reddit_links', 'sort_count'));
                break;
            case 'score':
                usort($this->arr, array('reddit_links', 'sort_score'));
                break;
            case 'comments':
                usort($this->arr, array('reddit_links', 'sort_comments'));
                break;
            default:
                usort($this->arr, array('reddit_links', 'sort_count'));
                break;
        }
    }

    private function struct()
    {
        $item = new reddit_item();

        $first = $this->itm_array[0]['itm'];

        $item->url = $first;

        $item->count_percentage = (1 / $this->itm_total) * 100;
        $item->score_percentage = (1 / $this->score_total) * 100;
        $item->comments_percentage = (1 / $this->comments_total) * 100;

        $item->count_total = 1;
        $item->score_total = $this->itm_array[0]['score'];
        $item->comments_total = $this->itm_array[0]['cmts'];

        $this->arr[$first] = $item;

        for($i = 1; $i < count($this->itm_array); $i++)
        {
            $itm = $this->itm_array[$i]['itm'];
            $score = $this->itm_array[$i]['score'];
            $cmts = $this->itm_array[$i]['cmts'];

            $this->add($itm, $score, $cmts);
        }

        $this->unique_total = count($this->arr);
    }

    private function add($itm, $score, $cmts)
    {
        if(isset($this->arr[$itm]))
        {
            $cnt = $this->arr[$itm]->count_total;
            $cmt = $this->arr[$itm]->comments_total;
            $st = $this->arr[$itm]->score_total;

            $new_cmt = $cmt / $this->comments_total * 100;

            $this->arr[$itm]->count_percentage = $cnt / $this->itm_total * 100;
            $this->arr[$itm]->score_percentage = $st / $this->score_total * 100;
            $this->arr[$itm]->comments_percentage = $new_cmt;

            $this->arr[$itm]->count_total++;
            $this->arr[$itm]->score_total = $st + $score;
            $this->arr[$itm]->comment_total = $cmt + $cmts;
        }
        else
        {
            $item = new reddit_item();

            $item->url = $itm;

            $item->count_percentage = (1 / $this->itm_total) * 100;
            $item->score_percentage = ($score / $this->score_total) * 100;
            $item->comments_percentage = ($cmts / $this->comments_total) * 100;

            $item->count_total = 1;
            $item->score_total = $score;
            $item->comment_total = $cmts;

            $this->arr[$itm] = $item;
        }
    }

    private function get_threads($pagination, $type)
    {
        $after = '';

        for($j = 0; $j < $pagination; $j++)
        {
            $this->data = file_get_contents($this->url_base . $after, false);
            $this->pages = json_decode($this->data, true);
            $this->thread_total = sizeof($this->pages['data']['children']);

            for($i = 0; $i < $this->thread_total; $i++)
            {
                $pg = $this->pages['data']['children'][$i]['data'];

                $title = $pg['title'];
                $id = $pg['id'];

                if(!strcmp($type, 'domain'))
                {
                    $itm = $pg['domain'];
                }
                else
                {
                    $itm = $pg['author'];
                }

                $score = $pg['score'];
                $cmts = $pg['num_comments'];

                $arr = ['itm' => $itm, 'score' => $score, 'cmts' => $cmts];

                $this->itm_array[] = $arr;

                $this->itm_total++;
                $this->score_total += $score;
                $this->comments_total += $cmts;
            }

             $after = '&after=' . $this->pages['data']['after'];
        }
    }
}
