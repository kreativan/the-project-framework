<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Check if htmx is enabled globally on the project
 */
function is_project_htmx() {
  if (isset($_GET['htmx']) && the_project('htmx')) return true;
}

/**
 * Htmx request attributes
 * @return string
 */
function htmx_req($file_path, $data = []) {

  $trigger = !empty($data["trigger"]) ? $data["trigger"] : "click";
  $target = !empty($data["target"]) ? $data["target"] : false;
  $swap = !empty($data["swap"]) ? $data["swap"] : false;
  $indicator = !empty($data["indicator"]) ? $data["indicator"] : false;
  $push_url = !empty($data["push_url"]) ? $data["push_url"] : false;
  $vals = count($data) > 0 ? $data : false;
  if ($vals && is_array($vals)) $vals = json_encode($vals);

  $attr = "hx-get='./?htmx={$file_path}'";
  $attr .= " hx-trigger='$trigger'";
  if ($target) $attr .= " hx-target='$target'";
  if ($swap) $attr .= " hx-swap='$swap'";
  if ($indicator) $attr .= " hx-indicator='$indicator'";
  if ($push_url) $attr .= " hx-push-url='$push_url'";
  if ($vals) $attr .= " hx-vals='$vals'";

  return $attr;
}

/**
 * HTMX modal req
 */
function htmx_modal($file_path, $data = []) {
  $indicator = isset($data['indicator']) ? $data['indicator'] : '#htmx-page-indicator';
  $attr = "hx-get='./?htmx={$file_path}'";
  $attr .= ' hx-target="body"';
  $attr .= ' hx-swap="beforeend"';
  $onclick = "project.htmxModal()";
  $attr .= " onclick=$onclick";
  if ($indicator) $attr .= " hx-indicator='$indicator'";
  if (count($data) > 0) {
    $vals = json_encode($data);
    $attr .= " hx-vals='$vals'";
  }
  return $attr;
}

/**
 * HTMX offcanvas req
 */
function htmx_offcanvas($file_path, $data = []) {
  $indicator = isset($data['indicator']) ? $data['indicator'] : '#htmx-page-indicator';
  $attr = "hx-get='./?htmx={$file_path}'";
  $attr .= ' hx-target="body"';
  $attr .= ' hx-swap="beforeend"';
  $onclick = "project.htmxOffcanvas()";
  $attr .= " onclick=$onclick";
  if ($indicator) $attr .= " hx-indicator='$indicator'";
  if (count($data) > 0) {
    $vals = json_encode($data);
    $attr .= " hx-vals='$vals'";
  }
  return $attr;
}


/**
 * Submit form with htmx
 * Use change trigger for filter search, and submit for ajax form submit
 * @param string $trigger change / submit
 * @param array $params additional parameters to pass
 */
function htmx_form($trigger = "change", $params = [], $target = "") {
  $attr = "hx-trigger='$trigger'";
  $attr .= " hx-boost='true'";
  if ($target != "") {
    $attr .= " hx-target='$target'";
    $attr .= " hx-select='$target'";
    $attr .= " hx-swap='outerHTML'";
  }
  $attr .= " hx-indicator='#htmx-page-indicator'";
  if (count($params) > 0) $attr .= " hx-vals='" . json_encode($params) . "'";
  return $attr;
}

/**
 * HTMX based navigation
 * apply this to a parent element of the navigation
 */
function htmx_nav($params = [], $target = "") {
  $attr = "hx-trigger='click'";
  $attr .= " hx-boost='true'";
  if ($target != "") {
    $attr .= " hx-target='$target'";
    $attr .= " hx-select='$target'";
    $attr .= " hx-swap='outerHTML'";
  }
  $attr .= " hx-indicator='#htmx-page-indicator'";
  if (count($params) > 0) $attr .= " hx-vals='" . json_encode($params) . "'";
  return $attr;
}
