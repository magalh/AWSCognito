<?php
// This action verifies that events are properly registered

if (!$this->CheckPermission(AWSCognito::MANAGE_PERM)) {
    echo "Permission denied";
    return;
}

echo "<h3>Verifying Events for AWSCognito Module</h3>";

// Check system events
$db = cmsms()->GetDb();
$query = "SELECT * FROM " . cms_db_prefix() . "events WHERE originator = ? AND event_name IN (?, ?, ?)";
$events = $db->GetArray($query, array('Core', 'LoginPre', 'LoginPost', 'LogoutPost'));

echo "<h4>System Events:</h4>";
echo "<pre>";
print_r($events);
echo "</pre>";

// Check event handlers
$query = "SELECT * FROM " . cms_db_prefix() . "event_handlers WHERE module_name = ?";
$handlers = $db->GetArray($query, array('AWSCognito'));

echo "<h4>Event Handlers:</h4>";
echo "<pre>";
print_r($handlers);
echo "</pre>";

// Check event files
$eventFiles = [
    'event.Core.LoginPre.php',
    'event.Core.LoginPost.php',
    'event.Core.LogoutPost.php'
];

echo "<h4>Event Files:</h4>";
echo "<ul>";
foreach ($eventFiles as $file) {
    $path = $this->GetModulePath() . '/' . $file;
    if (file_exists($path)) {
        echo "<li style='color:green'>$file exists</li>";
    } else {
        echo "<li style='color:red'>$file MISSING</li>";
    }
}
echo "</ul>";

echo "<p>If any events are missing, please upgrade the module to version 1.2.0.</p>";
echo "<p><a href='admin/moduleinterface.php?module=CMSEventManager'>Go to Event Manager</a></p>";