<?php

/**
 * Force Open File
 * Used for protected images and pdf 
 * 
 * Sometimes we need to protect user uploaded files from public access.
 * We usually add .htaccess and protect the folder with 0744 permissions at minimum.
 * But, we still need to access and download this files as admins.
 * We can use this end point to get the protected files /ajax/force-open/.
 * Only administrators can access this end point by default.
 * It is defined in tpf_force_open_roles() function.
 * You can use filter to extend the roles array 
 * @example
 * add_filter('TPF_Protected_Access', function($roles) {
 *    $roles[] = 'factory';
 *    return $roles;
 * });
 * 
 * @var string $_REQUEST['file_path'] - Path to the file relative to the 'wp-content' folder
 */

$allow = TPF_Has_Protected_Access();

// If current user does not have required role, die
if (!$allow) {
  wp_die('You are not allowed to access this file.');
}

// Get file path
$file_path = isset($_REQUEST['file_path']) ? $_REQUEST['file_path'] : false;
// remove base url from file path
$file_path = str_replace(get_site_url(), '', $file_path);
// remove get variables from the string
$file_path = explode('?', $file_path)[0];

// If file path is not set, die
if (!$file_path) {
  wp_die('File path is required.');
}

// Get full absolute file path
$file_path = ABSPATH . esc_html($file_path);

// Check if file exists
if (!file_exists($file_path)) {
  wp_die('File not found.');
}

// get file mime type
$mime_type = mime_content_type($file_path);

// Set headers for the preview
header('Content-Type: ' . $mime_type); // Adjust the content type if the file is not a PDF
header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
header('Content-Length: ' . filesize($file_path));

// Output the file
readfile($file_path);

exit();
