<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Check if number is even or odd
 * @param int $number
 * @return string
 */
function TPF_Even_Odd($number) {
  if ($number % 2 == 0) {
    return "even";
  } else {
    return "odd";
  }
}

/**
 *  Add Percent to a number
 *  sum = n + (( p / 100) * n )
 *  @param int $number
 *  @param int $percent
 *  @return int
 */
function TPF_Add_Percent(float $number, float $percent): float {
  $sum = $number + (($percent / 100) * $number);
  return $sum;
}
