<?php

if (!function_exists('humanReadableSize')) {
    /**
     * Convert bytes to a human-readable format.
     */
    function humanReadableSize($bytes): string
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.2f", $bytes / pow(1024, $factor)) . @$units[$factor];
    }
}

if (!function_exists('mimeTypeToExtension')) {
    /**
     * Convert a MIME type to a file extension.
     *
     * @param string $mimeType
     * @return string|null
     */
    function mimeTypeToExtension(string $mimeType): ?string
    {
        $mimeMap = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/bmp' => 'bmp',
            'image/webp' => 'webp',
            'application/pdf' => 'pdf',
            'text/plain' => 'txt',
            'text/html' => 'html',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
        ];

        return $mimeMap[$mimeType] ?? null;
    }
}
