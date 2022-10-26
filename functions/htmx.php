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
function htmx_req($file_path,  $config = [], $data = []) {

  $trigger = !empty($config["trigger"]) ? $config["trigger"] : "click";
  $target = !empty($config["target"]) ? $config["target"] : false;
  $swap = !empty($config["swap"]) ? $config["swap"] : false;
  $indicator = !empty($config["indicator"]) ? $config["indicator"] : false;
  $push_url = !empty($config["push_url"]) ? $config["push_url"] : false;
  $vals = count($data) > 0 ? $data : false;
  if($vals && is_array($vals)) $vals = json_encode($vals);

  $attr = "hx-get='./?htmx={$file_path}'";
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