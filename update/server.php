<?php

// Define the path to the private key file
$privateKeyPath = '/path/to/private-key.pem';

// Read the private key
$privateKey = file_get_contents($privateKeyPath);

// Define the path to the update files
$updateFilesPath = '/path/to/update-files/';

// Create a zip archive of the update files
$zip = new ZipArchive;
$zipFilename = 'update-files.zip';
if ($zip->open($updateFilesPath . $zipFilename, ZipArchive::CREATE) === TRUE) {
    // Read the update files list
    $updateFilesList = json_decode(file_get_contents('update-files-list.json'), true);

    // Add individual files to the zip archive
    foreach ($updateFilesList['files'] as $file) {
        $zip->addFile($file, $file);
    }

    // Add entire folders to the zip archive
    foreach ($updateFilesList['folders'] as $folder) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));
        foreach ($files as $file) {
            if (!$file->isDir()) {
                $relativePath = substr($file->getPathname(), strlen($folder));
                $zip->addFile($file->getPathname(), $folder . $relativePath);
            }
        }
    }

    $zip->close();
} else {
    die("Failed to create update zip file.\n");
}

// Sign the update file
$signature = '';
openssl_sign(file_get_contents($updateFilesPath . $zipFilename), $signature, $privateKey, OPENSSL_ALGO_SHA256);

// Save the signature to a file
file_put_contents($updateFilesPath . 'update-files.sig', $signature);

echo "Update files signed successfully.\n";
