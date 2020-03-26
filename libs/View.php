<?php

namespace Libs;

class View
{ 
  const PREFIX_PATH = "views/";
  private $layout;
  private $content;
  private $data = [];

  public function set($content, $data = null, $layout = null)
  {
    $this->content = self::PREFIX_PATH.$content;
    if (isset($data)) $this->data = $data;
    if (isset($layout)) $this->layout = self::PREFIX_PATH.$layout;
    return $this;
  }

  public function setData(Array $data)
  {
    $this->data = $data;
    return $this;
  }

  public function setLayout($layout)
  {
    $this->layout = self::PREFIX_PATH.$layout;
    return $this;
  }

  public function yield()
  {
    // こちらでもrenderと同じように変数を定義しなおさないと、データを渡せない
    foreach ($this->data as $key => $val) {
      $$key = $val;
    }
    require_once($this->content);
  }

  public function render()
  {
    foreach ($this->data as $key => $val) {
      $$key = $val;
    }
    if (empty($this->layout)) {
      require_once($this->content);
    } else {
      // layoutから中身を呼び出す時、$view->yield()とする。
      $view = $this;
      require_once($this->layout);
    }
  }
}