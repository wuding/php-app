<!DOCTYPE html>
<html>
<?php
function section($week_no = 3, $start = 12, $max = 19)
{
    $li = li($start, $max);
    $s = <<<HEREDOC
<section>
    <p><s>$week_no</s></p>
    <ul>
$li
    </ul>
</section>
HEREDOC;

    return $s;
}

function li($start = 1, $max = 8)
{
    // print_r(get_defined_vars());
    $a = [];
    for ($i = $start; $i < $max; $i++) {
        $s = <<<HEREDOC
<li>
    <dt><a href="javascript:">$i</a></dt>
    <dd></dd>
</li>
HEREDOC;

        $a[] = $s;
    }

    return implode(PHP_EOL, $a);
}

function ls($variable = [])
{
    $a = [];
    foreach ($variable as $key => $value) {
        $s = <<<HEREDOC
<li>
    <dt><a href="javascript:">$value</a></dt>
    <dd></dd>
</li>
HEREDOC;

        $a[] = $s;
    }

    return implode(PHP_EOL, $a);
}

function lst()
{
    $variable = month();
    $arr = [];
    foreach ($variable as $key => $value) {
        $arr[] = ls($value);
    }

    return implode(PHP_EOL, $arr);
}

function ol()
{
    $luna = 'Feb';
    $s = <<<HEREDOC
    <ol>
        <h2 class="p175"><b>$luna</b></h2>
        <article>
            <section>
                <p class="w175"><s>1</s></p>
                <ul>
                    <li>
                        <dt><a href="javascript:">1</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:" class="red">2</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">3</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">4</a></dt>
                        <dd></dd>
                    </li>
                </ul>
            </section>
            <section>
                <p><s>2</s></p>
                <ul>
                    <li>
                        <dt><a href="javascript:">5</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">6</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">7</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">8</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">9</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">10</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">11</a></dt>
                        <dd></dd>
                    </li>
                </ul>
            </section>
        </article>
    </ol>
HEREDOC;

    return $s;
}

function ols()
{
    $sec = null;
    $luna = 'Feb';
    $s = <<<HEREDOC
    <ol>
        <h2 class="p175"><b>$luna</b></h2>
        <article>
        $sec
        </article>
    </ol>
HEREDOC;

    return $s;
}

function year($year = 2025)
{
    $size = 7;
    $variable = range(1, 12);
    $arr = [];
    foreach ($variable as $month) {
        $month_week = month($month, $year, $size);
        $arr[] = $month_week;
    }
    return $arr;
}

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
    return get_defined_vars();
}

function weeks($variable, $month = 2, $year = 2025)
{
    $arr = $wk = [];
    $blank = '         ';
    foreach ($variable as $key => &$value) {
        $zj = '';
        foreach ($value as $k => &$v) {
            if ($v) {
                $time = strtotime("$year-$month-$v");
                // print_r([$key, $value, $time]);die;
                $zj = date('W', $time);
            }
            $len = strlen($v);
            $max = 4 - $len;
            // $v = substr($blank, 0, $max) . $v;
        }
        array_unshift($value, $zj);
        // $arr[] = implode(' ', $value);
        // $arr[] = ls($value);
    }
return $variable;
    // print_r($arr);
    print_r($variable);
}

$variable = year();
$i = 1;
foreach ($variable as $key => $value) {
    // print_r([$key]);
    // print_r(weeks($value, $i, 2025));
    $i++;
}

// print_r(month());
print_r(lst());
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" type="text/css" href="/css/tpl.css">
    <link rel="stylesheet" type="text/css" href="/css/cst.css">
</head>
<body>
<header>
    <nav>
        <dfn>S</dfn>
        <dfn>M</dfn>
        <dfn>T</dfn>
        <dfn>W</dfn>
        <dfn>T</dfn>
        <dfn>F</dfn>
        <dfn>S</dfn>
    </nav>
</header>

<main>
<h1>2025</h1>
<dl>
    <ol>
        <h2 class="p175"><b>Jan</b></h2>
        <article>
            <section>
                <p class="w175"><s>1</s></p>
                <ul>
                    <li>
                        <dt><a href="javascript:">1</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:" class="red">2</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">3</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">4</a></dt>
                        <dd></dd>
                    </li>
                </ul>
            </section>
            <section>
                <p><s>2</s></p>
                <ul>
                    <li>
                        <dt><a href="javascript:">5</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">6</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">7</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">8</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">9</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">10</a></dt>
                        <dd></dd>
                    </li>
                    <li>
                        <dt><a href="javascript:">11</a></dt>
                        <dd></dd>
                    </li>
                </ul>
            </section>
            <?php
// echo section(3, 12, 19);

// echo section(4, 19, 26);
            ?>

        </article>
    </ol>

    <?php
// echo ol();
?>
</dl>
</main>
</body>
</html>
