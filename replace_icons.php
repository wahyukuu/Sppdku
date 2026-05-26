<?php

$icon_map = [
    'fa-user-plus' => 'user-plus',
    'fa-user-shield' => 'shield',
    'fa-user-tie' => 'briefcase',
    'fa-user' => 'user',
    'fa-users' => 'users',
    'fa-pen-to-square' => 'edit',
    'fa-trash-can' => 'trash-2',
    'fa-trash' => 'trash-2',
    'fa-arrow-left' => 'arrow-left',
    'fa-save' => 'save',
    'fa-plus-circle' => 'plus-circle',
    'fa-plus' => 'plus',
    'fa-calendar-check' => 'calendar-check',
    'fa-print' => 'printer',
    'fa-plane-departure' => 'plane-takeoff',
    'fa-chart-pie' => 'pie-chart',
    'fa-wallet' => 'wallet',
    'fa-receipt' => 'receipt',
    'fa-file-lines' => 'file-text',
    'fa-file-invoice' => 'file-spreadsheet',
    'fa-right-from-bracket' => 'log-out',
    'fa-bars' => 'menu',
    'fa-bell' => 'bell',
    'fa-gear' => 'settings',
    'fa-magnifying-glass' => 'search',
    'fa-eye-slash' => 'eye-off',
    'fa-eye' => 'eye',
    'fa-check' => 'check',
    'fa-xmark' => 'x',
    'fa-envelope' => 'mail',
    'fa-lock' => 'lock',
    'fa-file-pdf' => 'file-text'
];

function process_file($filepath, $icon_map) {
    $content = file_get_contents($filepath);
    if ($content === false) return;
    
    $new_content = preg_replace_callback(
        '/<i\s+class=\"([^\"]*?fa-[^\"]*?)\"\s*>\s*<\/i>/i',
        function ($matches) use ($icon_map) {
            $class_str = $matches[1];
            $lucide_icon = 'circle'; // default
            
            foreach ($icon_map as $fa => $lu) {
                if (strpos($class_str, $fa) !== false) {
                    $lucide_icon = $lu;
                    break;
                }
            }
            
            $classes = explode(' ', $class_str);
            $other_classes = [];
            $exclude = ['fa', 'fas', 'far', 'fab', 'fa-solid', 'fa-regular'];
            
            foreach ($classes as $cls) {
                $cls = trim($cls);
                if ($cls === '') continue;
                if (!str_starts_with($cls, 'fa-') && !in_array($cls, $exclude)) {
                    $other_classes[] = $cls;
                }
            }
            
            $class_attr = implode(' ', $other_classes);
            if ($class_attr) {
                return "<i data-lucide=\"$lucide_icon\" class=\"$class_attr\"></i>";
            } else {
                return "<i data-lucide=\"$lucide_icon\"></i>";
            }
        },
        $content
    );
    
    if ($new_content !== null && $new_content !== $content) {
        file_put_contents($filepath, $new_content);
        echo "Updated $filepath\n";
    }
}

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('d:/Xampp1/htdocs/sppdku/app/Views'));

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        process_file($file->getPathname(), $icon_map);
    }
}
echo "Done\n";

?>
