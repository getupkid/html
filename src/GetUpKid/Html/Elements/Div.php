<?php

namespace GetUpKid\Html\Elements;

class Div extends Element
{
  protected $element = 'div';
  
  public function render()
  {
    $div = sprintf('<'.$this->element.'%s>', $this->renderAttributes());
    $div .= $this->content . $this->close;
    return $div;
  }
}
