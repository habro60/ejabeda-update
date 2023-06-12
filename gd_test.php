<?php
// Check for the GD extension
if (extension_loaded('gd') && function_exists('gd_info')) {
    echo "GD extension is enabled.";
    // Additional information about the GD extension
    // You can uncomment the line below to display detailed GD information
    // phpinfo();
} else {
    echo "GD extension is not enabled.";
}
