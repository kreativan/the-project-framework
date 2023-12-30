<?php

/**
 * Display time ago string
 * @param int|string $timestamp
 * @return string
 */
function TPF_Time_Ago($timestamp) {
  if (is_string($timestamp)) $timestamp = strtotime($timestamp);
  $ago = human_time_diff($timestamp, time());
  return sprintf(__("%s ago", 'the-project-framework'), $ago);
}
