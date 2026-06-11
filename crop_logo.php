<?php
$imagePath = 'public/images/logo.png';
if (!file_exists($imagePath)) {
    die("Logo file not found.\n");
}

$img = imagecreatefrompng($imagePath);
if (!$img) {
    die("Failed to load image.\n");
}

$width = imagesx($img);
$height = imagesy($img);

$top = $height;
$bottom = 0;
$left = $width;
$right = 0;

// Scan for non-transparent pixels
for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        $color = imagecolorat($img, $x, $y);
        $alpha = ($color >> 24) & 0x7F; // 127 is fully transparent in PHP GD
        if ($alpha < 110) { // Not fully transparent (with safety buffer)
            if ($x < $left) $left = $x;
            if ($x > $right) $right = $x;
            if ($y < $top) $top = $y;
            if ($y > $bottom) $bottom = $y;
        }
    }
}

// Add a 5px safety padding around the logo
$padding = 5;
$left = max(0, $left - $padding);
$top = max(0, $top - $padding);
$right = min($width - 1, $right + $padding);
$bottom = min($height - 1, $bottom + $padding);

$newWidth = $right - $left + 1;
$newHeight = $bottom - $top + 1;

if ($newWidth > 0 && $newHeight > 0 && ($newWidth < $width || $newHeight < $height)) {
    $cropped = imagecreatetruecolor($newWidth, $newHeight);
    
    // Preserve transparency
    imagealphablending($cropped, false);
    imagesavealpha($cropped, true);
    
    imagecopy($cropped, $img, 0, 0, $left, $top, $newWidth, $newHeight);
    
    // Save copy and overwrite original
    copy($imagePath, 'public/images/logo_backup.png'); // Keep a backup
    imagepng($cropped, $imagePath);
    echo "SUCCESS: Cropped logo from {$width}x{$height} to {$newWidth}x{$newHeight}.\n";
} else {
    echo "NO_CHANGE: Image already cropped or detection did not find trimming candidates.\n";
}
?>
