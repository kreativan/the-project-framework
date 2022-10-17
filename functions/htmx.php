<?php
/**
 * Check if htmx is enable globally on the project
 */
function is_project_htmx() {
  if (isset($_GET['htmx']) && the_project('htmx')) return true;
}

/**
 * Htmx request attributes
 * @return string
 */
function htmx_req($file_path,  $data = []) {

  // use file, get or post
  $file = !empty($data["file"]) ? $data["file"] : false;
  $get = !empty($data["get"]) ? $data["get"] : false;
  $post = !empty($data["post"]) ? $data["post"] : false;
  if(!$get && !$post && !$file) return false;

  $trigger = !empty($data["trigger"]) ? $data["trigger"] : "click";
  $target = !empty($data["target"]) ? $data["target"] : false;
  $swap = !empty($data["swap"]) ? $data["swap"] : false;
  $indicator = !empty($data["indicator"]) ? $data["indicator"] : false;
  $push_url = !empty($data["push_url"]) ? $data["push_url"] : false;
  $vals = !empty($data["vals"]) ? $data["vals"] : false;
  if($vals && is_array($vals)) $vals = json_encode($vals);

  if($file) $attr = "hx-get='{$this->url}{$file}'";
  if($get) $attr = "hx-get='{$this->url}{$get}'";
  if($post) $attr = "hx-post='{$this->url}{$post}'";
  $attr .= " hx-trigger='$trigger'";
  if($target) $attr .= " hx-target='$target'";
  if($swap) $attr .= " hx-swap='$swap'";
  if($indicator) $attr .= " hx-indicator='$indicator'";
  if($push_url) $attr .= " hx-push-url='$push_url'";
  if($vals) $attr .= " hx-vals='$vals'";

  return $attr;
}

/**
 * HTMX modal req
 */
function htmx_modal($file_path, $data = []) {
  $attr = "hx-get='./?htmx={$file_path}'";
  $attr .= ' hx-target="body"';
  $attr .= ' hx-swap="beforeend"';
  $onclick = "project.htmxModal()";
  $attr .= " onclick=$onclick";
  if(count($data) > 0) {
    $vals = json_encode($data);
    $attr .= " hx-vals='$vals'";
  }
  return $attr;
}

/**
 * HTMX offcanvas req
 */
function htmx_offcanvas($file_path, $data = []) {
  $attr = "hx-get='./?htmx={$file_path}'";
  $attr .= ' hx-target="body"';
  $attr .= ' hx-swap="beforeend"';
  $onclick = "project.htmxOffcanvas()";
  $attr .= " onclick=$onclick";
  if(count($data) > 0) {
    $vals = json_encode($data);
    $attr .= " hx-vals='$vals'";
  }
  return $attr;
}