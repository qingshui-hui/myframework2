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
    if (isset($data)) $this->data = array_merge($this->data, $data);
    if (isset($layout)) $this->layout = self::PREFIX_PATH.$layout;
    return $this;
  }

  public function addData(Array $data)
  {
    $this->data = array_merge($this->data, $data);
    return $this;
  }

  // データを空にしたいときなどに使う
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
    if (!isset($this->layout)) {
      require_once($this->content);
    } else {
      // layoutからcontentを呼び出す時、$view->yield()と記述するため、layoutに、viewのインスタンスを渡す。
      $view = $this;
      require_once($this->layout);
    }
  }
}