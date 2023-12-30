<?php

/**
 * Render Forms
 * - used for ACF forms
 */

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class Form {

  public $fields;
  public $id;
  public $class;
  public $method;
  public $action;
  public $numb_captcha;
  public $button_style;
  public $button_text;
  public $labels;
  public $grid_size;
  public $ajax;
  public $enctype;

  public function __construct() {

    $this->class = "uk-form-stacked";
    $this->method = "POST";
    $this->action = "./";
    $this->ajax = true;
    $this->enctype = "multipart/form-data";
    $this->numb_captcha = false;
    $this->button_style = "primary";
    $this->button_text = "Submit";
    $this->labels = true;
    $this->grid_size = "default";
  }

  public function fields($fields = []) {
    $this->fields = $fields;
    return $this;
  }

  public function id($id = "") {
    $this->id = $id;
    return $this;
  }

  public function class($class) {
    $this->class = $class;
    return $this;
  }

  public function method($method) {
    $this->method = $method;
    return $this;
  }

  public function action($action) {
    $this->action = $action;
    return $this;
  }

  public function ajax($ajax) {
    $this->ajax = $ajax;
    return $this;
  }

  public function enctype($enctype) {
    $this->enctype = $enctype;
    return $this;
  }

  public function numb_captcha($numb_captcha) {
    $this->numb_captcha = $numb_captcha;
    return $this;
  }

  public function button_style($button_style) {
    $this->button_style = $button_style;
    return $this;
  }

  public function button_text($button_text) {
    $this->button_text = $button_text;
    return $this;
  }

  public function labels($labels) {
    $this->labels = $labels;
    return $this;
  }

  public function grid_size($grid_size) {
    $this->grid_size = $grid_size;
    return $this;
  }

  //-------------------------------------------------------- 
  //  Render
  //-------------------------------------------------------- 

  public function render() {

    $class = "tpf-form";
    $class = !empty($this->class) ? " $this->class" : "";
    $margin_bottom = $this->grid_size == "default" ? "uk-margin-bottom" : "uk-margin-{$this->grid_size}-bottom";

    $form = "<form id='{$this->id}' action='{$this->action}' method='{$this->method}' class='{$class}' enctype='$this->enctype'>";
    $form .= "<div class='uk-grid uk-grid-{$this->grid_size}' uk-grid>"; // grid start
    foreach ($this->fields as $field) {

      $grid = isset($field['grid']) ? $field['grid'] : '1-1';
      $type = isset($field['type']) ? $field['type'] : 'text';

      if ($type == "hidden") {

        $form .= $this->hidden($field);
      } else {

        $form .= "<div class='uk-width-{$grid}@m uk-margin-remove-top {$margin_bottom}'>";

        if ($this->labels) $form .= $this->label($field);

        switch ($type) {
          case 'text':
            $form .= $this->text($field);
            break;
          case 'select':
            $form .= $this->select($field);
            break;
          case 'radio':
            $form .= $this->radio($field);
            break;
          case 'checkbox':
            $form .= $this->checkbox($field);
            break;
          case 'textarea':
            $form .= $this->textarea($field);
            break;
          case 'date':
            $form .= $this->date($field);
            break;
          case 'file':
            $form .= $this->file($field);
            break;
          case 'hidden':
            $form .= $this->hidden($field);
            break;
          case 'wysiwyg':
            $form .= $this->wysiwyg($field);
            break;
          default:
            $form .= $this->text($field);
        }

        $form .= "</div>";
      }
    }

    $form .= "</div>"; // grid end

    if ($this->numb_captcha) {
      $form .= "<div class='uk-grid uk-grid-small' uk-grid>";
      $form .= "<div class='uk-width-auto@s'>" . $this->numb_captcha_markup() . "</div>";
      $form .= "<div class='uk-width-expand@s'>";
      if ($this->ajax) {
        $form .= $this->submitButtonAjax();
      } else {
        $form .= $this->submitButton();
      }
      $form .= "</div>";
      $form .= "</div>";
    } else {
      if ($this->ajax) {
        $form .= "<div class='uk-margin-top'>{$this->submitButtonAjax()}</div>";
      } else {
        $form .= "<div class='uk-margin-top'>{$this->submitButton()}</div>";
      }
    }

    $form .= "</form>";

    echo $form;
  }

  //-------------------------------------------------------- 
  //  Fields
  //-------------------------------------------------------- 

  public function field_data($field) {
    $array = [
      'type' =>  isset($field['type']) ? $field['type'] : "text",
      'name' =>  isset($field['name']) ? $field['name'] : "",
      'label' =>  isset($field['label']) ? $field['label'] : "",
      'value' => isset($field['value']) ? $field['value'] : "",
      'req' => isset($field['req']) && $field['req'] == 1 ? 'required' : '',
      'class' => isset($field['class']) ? $field['class'] : "",
      'placeholder' => isset($field['placeholder']) ? $field['placeholder'] : "",
      'grid' => isset($field['grid']) ? $field['grid'] : "1-1",
      'attr' => isset($field['attr']) ? $field['attr'] : "",
      'description' => isset($field['description']) ? $field['description'] : "",
      "body" => isset($field['body']) ? $field['body'] : "",
    ];
    return $array;
  }

  public function label($field) {
    $f = $this->field_data($field);
    $attr = $f['description'] ? "title='{$f['description']}' uk-tooltip='pos: top-left'" : "";
    if (!$f['label']) return;
    $label = "<label class='uk-form-label' for='input-{$f['name']}' $attr>";
    $label .= $f['label'];
    if ($f['req']) $label .= "<span class='uk-text-danger'>*</span>";
    if ($f['description']) $label .= "<div class='tpf-form-desc uk-text-small uk-text-muted'>{$f['description']}</div>";
    $label .= "</label>";
    return $label;
  }

  public function hidden($field) {
    $f = $this->field_data($field);
    return "<input type='hidden' name='{$f['name']}' value='{$f['value']}' />";
  }

  public function text($field) {
    $f = $this->field_data($field);
    $class = $f['class'] ? $f['class'] : 'uk-input';
    return "<input id='input-{$f['name']}' class='{$class}' type='{$f['type']}' name='{$f['name']}' value='{$f['value']}' placeholder='{$f['placeholder']}' {$f['req']} {$f['attr']} />";
  }

  public function textarea($field) {
    $f = $this->field_data($field);
    $class = $f['class'] ? $f['class'] : 'uk-textarea';
    $rows =  isset($field['rows']) ? $field['rows'] : 5;
    return "<textarea class='$class' name='{$f['name']}' placeholder='{$f['placeholder']}' rows='$rows' {$f['attr']}>{$f['value']}</textarea>";
  }

  public function select($field) {
    $f = $this->field_data($field);
    $class = $f['class'] ? $f['class'] : 'uk-select';
    $options = isset($field['options']) ? $field['options'] : "";
    $select = "<select id='input-{$f['name']}' name='{$f['name']}' class='$class' {$f['req']} {$f['attr']}>";
    if ($f['placeholder']) $select .= "<option value=''>{$f['placeholder']}</option>";
    if ($options && is_array($options)) {
      foreach ($options as $key => $value) {
        $selected = $key == $f['value'] ? 'selected' : '';
        $select .= "<option value='$key' $selected>$value</option>";
      }
    }
    $select .= "</select>";
    return $select;
  }

  public function radio($field) {
    $f = $this->field_data($field);
    $class = $f['class'] ? $f['class'] : 'uk-radio';
    $options = isset($field['options']) ? $field['options'] : "";
    $radio = "";
    foreach ($options as $key => $value) {
      $checked = $key == $f['value'] ? 'checked' : '';
      $radio .= "
        <label class='uk-margin-small-right'>
          <input class='$class' type='radio' name='{$f['name']}' $checked {$f['attr']}>
          <span>$value</span>
        </label>
      ";
    }
    return $radio;
  }

  public function checkbox($field) {
    $f = $this->field_data($field);
    $class = $f['class'] ? $f['class'] : 'uk-checkbox';
    $options = isset($field['options']) ? $field['options'] : "";
    $placeholder = isset($field['placeholder']) ? $field['placeholder'] : "";
    $html = "";
    foreach ($options as $key => $value) {
      $checked = is_array($f['value']) && in_array($key, $f['value']) ? 'checked' : '';
      $html .= "
        <label class='uk-margin-small-right'>
          <input class='$class' type='checkbox' name='{$f['name']}' $checked {$f['attr']}>
          <span style='margin-left: 5px;'>$placeholder</span>
        </label>
      ";
    }
    return $html;
  }

  public function date($field) {
    $f = $this->field_data($field);
    $class = $f['class'] ? $f['class'] : 'uk-input';
    $min = isset($field['min']) ? "min='{$field['min']}'" : ''; // y-m-d
    $max = isset($field['max']) ? "max='{$field['max']}'" : ''; // y-m-d
    return "<input id='input-{$f['name']}' class='{$class}' type='{$f['type']}' name='{$f['name']}' value='{$f['value']}' placeholder='{$f['placeholder']}' {$f['req']} {$f['attr']} $min $max />";
  }

  public function file($field) {
    $f = $this->field_data($field);
    $class = $f['class'] ? $f['class'] : 'uk-input';
    $out = "<div uk-form-custom='target: true'>";
    $out .= "<input id='{$f['name']}' type='file' {$f['req']} {$f['attr']}>";
    $out .= "<input class='{$class}' type='text' placeholder='{$f['placeholder']}' disabled>";
    $out .= "</div>";
    return $out;
  }

  public function wysiwyg($field) {
    return $field['body'];
  }


  //-------------------------------------------------------- 
  //  Numb Captcha
  //-------------------------------------------------------- 
  public function numb_captcha_markup() {
    $q1 = rand(1, 9);
    $q2 = rand(1, 9);
    $out = "<div class='uk-flex uk-flex-middle'>";
    $out .= "
      <input type='hidden' name='q1' value='$q1' />
      <input type='hidden' name='q2' value='$q2' />
      <span class='uk-h4 uk-margin-remove uk-text-muted uk-text-right' style='min-width:80px;'>$q1 + $q2 ?</span>
    ";
    $out .= "
      <div class='uk-width-expand@m'>
        <input class='uk-input uk-form-width-small uk-margin-small-left' type='text' name='answ' required style='max-width:80px;' />
      </div>
    ";
    $out .= "</div>";
    return $out;
  }


  //-------------------------------------------------------- 
  //  Submit
  //-------------------------------------------------------- 

  public function submitButtonAjax() {
    $onclick = 'project.formSubmit("' . $this->id . '")';
    $out = "<button class='uk-button uk-button-{$this->button_style}' type='button' onclick='$onclick'>$this->button_text</button><span class='ajax-indicator uk-hidden uk-margin-left' uk-spinner></span>";
    return $out;
  }

  public function submitButton($options = []) {
    $name = !empty($options['name']) ? $options['name'] : "submit_{$this->id}";
    $out = "<button class='uk-button uk-button-{$this->button_style}' type='submit' name='submit' form='{$this->id}'>$this->button_text</button>";
    return $out;
  }
}
