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
        $array_chunk = array_chunk($days_range_of_month, $size);
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
        return $arr;
        return get_defined_vars();
    }

    function wtf()
    {
        $months = range(1, 12);
        $arr = [];
        foreach ($months as $key => $value) {
            $arr[] = $this->month($value);
        }
        print_r($arr);
    }
}

$Cal = new Cal;
// $init = $Cal->month();
$init = $Cal->wtf();
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
// echo $Cal->years();


?>
</main>
</body>
