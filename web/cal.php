<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<?php
class Cal
{
    function month($month = 2, $year = 2025, $size = 7)
    {
        $cal_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $days_range_of_month = range(1, $cal_days_in_month);

        $time = strtotime("$year-$month-1");
        list(
            $full_text_of_month,
            $num_day_of_week,
            $week_num_of_year
        ) = explode('-', date('F-N-W', $time));

        $day_of_month = date('j');
        $right_grid_width = 50 * (7 - $num_day_of_week);
        $padding_width = 50 * $num_day_of_week + 25;

        for ($i=0; $i < $num_day_of_week; $i++) {
            array_unshift($days_range_of_month, '');
        }
        return $array_chunk = array_chunk($days_range_of_month, $size);
        $week_num_of_year= (int) $week_num_of_year;

        $arr = [];
        $blank = '         ';
        foreach ($array_chunk as $key => &$value) {
            $ar = [];
            foreach ($value as $k => &$v) {
                $len = strlen($v);
                $max = 4 - $len;
                $v = substr($blank, 0, $max) . $v;
            }

            $arr[$week_num_of_year] = implode('', $value);
            $week_num_of_year++;
        }
        // return $arr;
        return get_defined_vars();
    }

    function month0($month = 2, $year = 2025, $size = 7)
    {
        $cal_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $days_range_of_month = range(1, $cal_days_in_month);

        $time = strtotime("$year-$month-1");
        list(
            $full_text_of_month,
            $num_day_of_week,
            $week_num_of_year
        ) = explode('-', date('F-N-W', $time));

        $day_of_month = date('j');
        $right_grid_width = 50 * (7 - $num_day_of_week);
        $padding_width = 50 * $num_day_of_week + 25;

        for ($i=0; $i < $num_day_of_week; $i++) {
            array_unshift($days_range_of_month, '');
        }
        return $array_chunk = array_chunk($days_range_of_month, $size);

        return get_defined_vars();
    }

    function year($year = 2025)
    {
        $size = 7;
        $variable = range(1, 12);
        $arr = [];
        foreach ($variable as $month) {
            $month_week = $this->month($month, $year, $size);
            $arr[] = $month_week;#$this->push_week_no($month, $year, $month_week);
        }
        return $arr;
        return get_defined_vars();
    }

    function date_format($format = 'F-N-W', $year = 1, $month = 1, $day = 1)
    {
        $time = strtotime("$year-$month-$day");
        return explode('-', date($format, $time));
    }

    function years()
    {
        $pieces = [];
        for ($i=2025; $i < 2027; $i++) {
            $pieces[] = $this->dl($i);
        }
        return implode(PHP_EOL, $pieces);
    }

    function dl($year = 2025)
    {
        $arr = ["<h1>$year</h1>"];
        $arr[] = '<dl>';
        for ($i=1; $i < 13; $i++) {
            $b = $this->date_format($format = 'M-N-W', $year, $i);
            list(
                $full_text_of_month,
                $num_day_of_week,
                $week_num_of_year
            ) = $b;
            $arr[] = $this->ol($full_text_of_month, $week_num_of_year);
        }
        $arr[] = '</dl>';
        return implode(PHP_EOL, $arr);
    }

    function ol($b = 'Jan', $week_num_of_year = null)
    {
        $pieces = ['<ol>'];
        $pieces[] = <<<HEREDOC
<h2>
<b>$b</b>
</h2>
HEREDOC;
        $pieces[] = '<article>';
        for ($i=0; $i < 4; $i++) {
            $pieces[] = $this->sec($week_num_of_year);
        }

        $pieces[] = '</article>';
        $pieces[] = '</ol>';
        $pieces[] = PHP_EOL;
        return implode(PHP_EOL, $pieces);
    }

    function sec($week_num_of_year)
    {
        // $week_num_of_year = $this->date_format($format = 'W', $year, $i);
        $pieces = ['<section>'];
        $pieces[] = "<p class=\"p\">$week_num_of_year</p>";
        $pieces[] = $this->ul();
        $pieces[] = '</section>';
        return implode(PHP_EOL, $pieces);
    }

    function ul()
    {
        $pieces = ['<ul>'];
        for ($i=1; $i < 8; $i++) {
            $pieces[] = $this->li($i);
        }

        $pieces[] = '</ul>';
        // $pieces[] = PHP_EOL;
        return implode('', $pieces);
    }

    function li($day)
    {
        $s = <<<HEREDOC
<li><dt>$day</dt><dd></dd></li>
HEREDOC;

        return " $s ";
    }
}

$Cal = new Cal;
$init = $Cal->month();
// $init = $Cal->wtf();
// $init = $Cal->year();
print_r($init);

// $sess = $Cal->sess($init);
// $dl = $Cal->dl();
?>


<body class="drm">

<div class="nav">
<nav>
<dfn>S</dfn>
<dfn>M</dfn>
<dfn>T</dfn>
<dfn>W</dfn>
<dfn>T</dfn>
<dfn>F</dfn>
<dfn>S</dfn>
</nav>
</div>

<main>
<?php
echo $Cal->years();


?>
</main>
</body>
