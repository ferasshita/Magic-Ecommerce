<?php
// Example: Download and update files from the server
$updatedFiles = file_get_contents('http://feras.com.ly/path/to/update-files/update-files.zip');
file_put_contents(__DIR__ . '/updated-files.zip', $updatedFiles);

// Example: Extract the updated files
$zip = new ZipArchive;
if ($zip->open(__DIR__ . '/updated-files.zip') === TRUE) {
    // Extract all files except those in the exclusion list
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $filename = $zip->getNameIndex($i);

        // Check if the file or folder is excluded
        $exclude = false;
        foreach ($excludedFiles as $excluded) {
            if (strpos($filename, $excluded) === 0) {
                $exclude = true;
                break;
            }
        }

        // Extract the file if not excluded
        if (!$exclude) {
            $zip->extractTo(__DIR__, [$filename]);
        }
    }
    $zip->close();
    echo "Update successful!\n";
} else {
    echo "Failed to extract updated files.\n";
}
