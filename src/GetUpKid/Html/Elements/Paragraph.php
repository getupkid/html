<?php

namespace GetUpKid\Html\Elements;

class Paragraph extends Element
{
  public $content;

  public function render()
  {
    $p = sprintf('<p%s>', $this->renderAttributes());
    $p .= $this->content . $this->close;
    return $p;
  }

  
}
