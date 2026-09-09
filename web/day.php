<?php

class Day
{
  static VERSION = 26.0909;
  static REVISION = 1;
  static BUILD = 20260711.1923;

  function all()
  {
    $s = 343670400;
    $n = 86400000;
    $a = [];
    for ($i=1; $i < 31; $i++) {
      $k = 1000 * $i;

    }
  }

  static function square()
  {
    for ($i=0; $i < 101; $i++) {
      $j = $i * $i;
      echo "<p>$i * $i = $j</p>";
    }
  }

  static function full()
  {
    for ($i=0; $i < 101; $i++) {
      $j = $i * 15;
      echo "<p>15 * $i = $j</p>";
    }
  }

  static function path($o)
  {
    $path_info = $_SERVER['PATH_INFO'] ?? '';
    $trim = trim($path_info, '/');
    $m = get_class_methods($o);
    $in_array = in_array($trim, $m);
    $f = 'square';
    if ($in_array) {
      $f = $trim;
    }
    $o::$f();
    // print_r($in_array);
  }
}

// Day::square();
// Day::full();
Day::path(new Day);
