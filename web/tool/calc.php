<!DOCTYPE html>
<?php
$string = '_Abstract,BC';
$dir = 'N:\Server\VCS\GitHub\wuding\php-ext\src';
$variable = explode(',', $string);
foreach ($variable as $value) {
    include "$dir\\$value.php";
}

use Ext\BC;

new BC;

// 参数
$var_array = array(
    'left_operand' => null,
    'right_operand' => null,
    'type' => null,
    'scale' => null,
    'operand' => null,
    'modulus' => null,
);
$var_array = array_merge($var_array, $_GET);
extract($var_array);

// 配置
BC::restore($scale);

// 执行
$result = $type ? BC::$type($left_operand, $right_operand) : null;
$sqrt = null !== $operand ? BC::sqrt($operand) : null;
$res = null !== $modulus ? BC::powMod($left_operand, $right_operand, $modulus) : null;

// 视图
$variable = array(
    'add' => '+',
    'sub' => '-',
    'mul' => '*',
    'div' => '/',
    'mod' => '%',
    'pow' => '**',
    'comp' => 'vs',
);
$opt = "";
foreach ($variable as $key => $value) {
    $sel = $type === $key ? " selected" : '';
    $opt .= "        <option value=\"$key\"$sel>$value</option>". PHP_EOL;
}
?>
<html>
<head>
    <title>计算器</title>
</head>

<body>
<h1>
    <a href="calc.php">计算器</a>
</h1>

<form>
    <input name="left_operand" value="<?=$left_operand?>">
    <select name="type">
<?=$opt?>
    </select>
    <input name="right_operand" value="<?=$right_operand?>">
    =
    <input value="<?=$result?>" disabled>
    <button type="submit">计算</button>
    <input name="scale" value="<?=$scale?>" placeholder="小数位数">
</form>
<p>
<hr>

<form>
    <input name="operand" value="<?=$operand?>">
    =
    <input value="<?=$sqrt?>" disabled>
    <button type="submit">平方根</button>
    <input name="scale" value="<?=$scale?>" placeholder="小数位数">
</form>
<p>
<hr>

<form>
    <input name="left_operand" value="<?=$left_operand?>">
    **
    <input name="right_operand" value="<?=$right_operand?>">
    %
    <input name="modulus" value="<?=$modulus?>">
    =
    <input value="<?=$res?>" disabled>
    <button type="submit">计算</button>
    <input name="scale" value="<?=$scale?>" placeholder="小数位数">
</form>
</body>
</html>