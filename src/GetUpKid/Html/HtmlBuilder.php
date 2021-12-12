<?php

namespace GetUpKid\Html;

use GetUpKid\Html\Elements\Div;
use GetUpKid\Html\Elements\Paragraph;
use GetUpKid\Html\Elements\Anchor;

class HtmlBuilder
{
    public function div()
    {
        $div = new Div;
        return $div;
    }

    public function divClose()
    {
        return '</div>';
    }

    public function p()
    {
        $p = new Paragraph;
        return $p;
    }

    public function pClose()
    {
        return '</p>';
    }

    public function a($href)
    {
        $a = new Anchor($href);
        return $a;
    }
}
