<?php
namespace traits;

trait _Abstract
{
    public function _errorReport()
    {
        print_r(func_get_args());
    }
}
