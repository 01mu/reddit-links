<?php

class reddit_url
{
    public $url;
    public $count_percentage;
    public $score_percentage;
    public $count_total;
    public $score_total;
}

class reddit_links
{
    private $url;
    private $data;
    private $pages;
    private $thread_total;
    private $url_array;
    private $arr;
    private $url_total;
    private $score_total;

    public function reddit_links($sub, $limit, $pagination)
    {
        $this->url_array = array();
        $this->arr = array();
        $this->url_total = 0;
        $this->score_total = 0;

        $this->url_base = 'https://www.reddit.com/r/' . $sub
            . '/hot/.json?limit=' . $limit;

        $this->get_threads($pagination);
        $this->struct();
    }

    public function get_arr()
    {
        return $this->arr;
    }

    public function unique_url_total()
    {
        return count($this->arr);
    }

    public function url_total()
    {
        return $this->url_total;
    }

    public function score_total()
    {
        return $this->score_total;
    }

    public static function sort_cp($a, $b)
    {
        return $a->count_percentage < $b->count_percentage;
    }

    public static function sort_sp($a, $b)
    {
        return $a->score_percentage < $b->score_percentage;
    }

    public static function sort_ct($a, $b)
    {
        return $a->count_total < $b->count_total;
    }

    public static function sort_st($a, $b)
    {
        return $a->score_total < $b->score_total;
    }

    public function sort($type)
    {
        switch($type)
        {
            case 'count_percentage':
                usort($this->arr, array('reddit_links','sort_cp'));
                break;
            case 'score_percentage':
                usort($this->arr, array('reddit_links','sort_sp'));
                break;
            case 'count_total':
                usort($this->arr, array('reddit_links','sort_ct'));
                break;
            case 'score_total':
                usort($this->arr, array('reddit_links','sort_st'));
                break;
        }
    }

    public function display()
    {
        for($i = 0; $i < count($this->arr); $i++)
        {
            printf($this->arr[$i]->url . " "
                . $this->arr[$i]->score_total . " "
                . $this->arr[$i]->count_total . " "
                . number_format($this->arr[$i]->score_percentage, 2) . " "
                . number_format($this->arr[$i]->count_percentage, 2) . "\n");
        }
    }

    private function check_exists($url, $sc)
    {
        $found = 0;

        for($i = 0; $i < count($this->arr); $i++)
        {
            if(strcmp($this->arr[$i]->url, $url) == 0)
            {
                $this->arr[$i]->count_total++;
                $this->arr[$i]->count_percentage = ($this->arr[$i]->count_total
                    / $this->url_total) * 100;
                $this->arr[$i]->score_total = $this->arr[$i]->score_total + $sc;
                $this->arr[$i]->score_percentage = ($this->arr[$i]->score_total
                    / $this->score_total) * 100;

                $found = 1;
            }
        }

        if(!$found)
        {
            $reddit_url = new reddit_url();

            $reddit_url->url = $url;
            $reddit_url->count_percentage = (1 / $this->url_total) * 100;
            $reddit_url->score_percentage = (1 / $this->score_total) * 100;
            $reddit_url->count_total = 1;
            $reddit_url->score_total = $sc;

            $this->arr[] = $reddit_url;
        }
    }

    private function struct()
    {
        $reddit_url = new reddit_url();

        $reddit_url->url = $this->url_array[0]['url'];
        $reddit_url->count_percentage = (1 / $this->url_total) * 100;
        $reddit_url->score_percentage = (1 / $this->score_total) * 100;
        $reddit_url->count_total = 1;
        $reddit_url->score_total = $this->url_array[0]['score'];

        $this->arr[] = $reddit_url;

        for($i = 1; $i < count($this->url_array); $i++)
        {
            $url = $this->url_array[$i]['url'];
            $score = $this->url_array[$i]['score'];

            $this->check_exists($url, $score);
        }
    }

    private function get_threads($pagination)
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
                $url = $pg['domain'];
                $score = $pg['score'];
                //$comments = $pg['replies'];

                $this->url_array[] = ['url' => $url, 'score' => $score];

                $this->url_total++;
                $this->score_total += $score;
            }

             $after = '&after=' . $this->pages['data']['after'];
        }
    }
}
