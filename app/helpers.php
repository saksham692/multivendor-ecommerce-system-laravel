<?php

if (!function_exists('isActiveRoute')) {
    /**
     * Return 'active' class if the current route matches any of the given common names.
     *
     * @param array|string $commonNames
     * @return string
     */
    function isActiveRoute($commonNames){
        // Convert to an array if a single string is provided
        $commonNames = (array) $commonNames;

        foreach ($commonNames as $name) {
            if (str_contains(Route::currentRouteName(), $name)) {
                return 'active';
            }
        }

        return '';
    }
}

// app/Helpers/FileHelper.php

if (!function_exists('formatFileSize')) {
    /**
     * Convert bytes to a human-readable file size (KB, MB, GB)
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    function formatFileSize(int $bytes, int $precision = 2): string
    {
        if ($bytes >= 1073741824) {
            $size = $bytes / 1073741824; // Convert to GB
            $unit = 'GB';
        } elseif ($bytes >= 1048576) {
            $size = $bytes / 1048576; // Convert to MB
            $unit = 'MB';
        } elseif ($bytes >= 1024) {
            $size = $bytes / 1024; // Convert to KB
            $unit = 'KB';
        } else {
            return $bytes . ' bytes'; // Less than 1 KB
        }

        return number_format($size, $precision) . ' ' . $unit;
    }

    if (!function_exists('getUpload')){
        function getUpload($id){
            $upload = \App\Models\Upload::find($id);
            return asset('storage/' . $upload->path);
        }
    }
}

if (!function_exists('get_image')) {
    function get_image($path, $placeholder = 'assets/img/placeholder.jpg')
    {
        // Define the full storage path for images
        $fullPath = storage_path('app/public/' . $path);

        // Check if the image exists and the path is not empty
        if (!empty($path) && file_exists($fullPath)) {
            // Return the URL of the image in the storage directory
            return asset('storage/' . $path);
        }

        // If the image does not exist, return the placeholder image
        return asset($placeholder);
    }
}
