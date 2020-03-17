<?php

namespace Libs;

class View
{ 
  private $layout;
  private $content;
  private $data;

  public function setContent($content)
  {
    $this->content = 'views/'.$content;
    return $this;
  }

  public function setData(Array $data)
  {
    $this->data = $data;
    return $this;
  }

  public function setLayout($layout)
  {
    $this->layout = 'views/'.$layout;
    return $this;
  }

  public function yield()
  {
    foreach ($this->data as $key => $val) {
      $$key = $val;
    }
    require_once($this->content);
  }

  public function render($content = null, Array $data = [])
  {
    if (!empty($content)) $this->setContent($content);
    if (!empty($data)) $this->data = $data;

    $view = $this;
    if (empty($this->layout))
    {
      foreach ($this->data as $key => $val) {
        $$key = $val;
      }
      require_once($this->content);
      
    } else {
      require_once($this->layout);
    }
  }
}