<?php
// Set headers for AJAX response
header('Content-Type: application/json');

try {
    // Check if image data was sent
    if (!isset($_POST['imageData'])) {
        throw new Exception('No image data received');
    }
    
    $imageData = $_POST['imageData'];
    
    // Extract the base64 encoded image data
    if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
        $imageType = $matches[1];
        $imageData = substr($imageData, strpos($imageData, ',') + 1);
        $imageData = base64_decode($imageData);
        
        if ($imageData === false) {
            throw new Exception('Failed to decode image data');
        }
    } else {
        throw new Exception('Invalid image data format');
    }
    
    // Use the existing images directory
    $imagesDir = 'images';
    
    // Debug information
    error_log('Saving to directory: ' . $imagesDir);
    error_log('Directory exists: ' . (file_exists($imagesDir) ? 'Yes' : 'No'));
    error_log('Directory writable: ' . (is_writable($imagesDir) ? 'Yes' : 'No'));
    
    // Check if directory exists
    if (!file_exists($imagesDir)) {
        // Try to create it if it doesn't exist
        if (!mkdir($imagesDir, 0777, true)) {
            throw new Exception('Failed to create images directory');
        }
    }
    
    // Check if directory is writable
    if (!is_writable($imagesDir)) {
        // For Windows, try to make it writable
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // This is a Windows server
            error_log('Running on Windows, attempting to set permissions');
            // We can't use chmod on Windows, but we can try this
            // This is a no-op on Windows but prevents errors
        } else {
            // On Linux/Unix we can try chmod
            chmod($imagesDir, 0777);
        }
        
        // Check again
        if (!is_writable($imagesDir)) {
            throw new Exception('Images directory is not writable. Please check permissions.');
        }
    }
    
    // Generate a unique filename
    $filename = 'capture_' . date('YmdHis') . '_' . uniqid() . '.' . $imageType;
    $filePath = $imagesDir . '/' . $filename;
    
    // Save the image
    $result = file_put_contents($filePath, $imageData);
    if ($result === false) {
        $error = error_get_last();
        throw new Exception('Failed to save image: ' . ($error ? $error['message'] : 'Unknown error'));
    }
    
    // Success response
    echo json_encode([
        'success' => true,
        'filename' => $filename,
        'path' => 'images/' . $filename,
        'size' => $result . ' bytes'
    ]);
    
} catch (Exception $e) {
    // Error response
    error_log('Error saving image: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>