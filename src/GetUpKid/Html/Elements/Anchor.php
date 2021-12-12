<?php

namespace GetUpKid\Html\Elements;

class Anchor extends Element
{
  protected $href;

  protected $element = 'a';

  public function __construct($href)
  {
    $this->close(); // Always close anchor tags.
    $this->setAttribute('href', $href);
  }

  public function render()
  {
    $a = sprintf('<'.$this->element.'%s>', $this->renderAttributes());
    $a .= $this->content . $this->close;
    return $a;
  }

  public function blank()
  {
    $this->setAttribute('target', '_blank');
    return $this;
  }
}
