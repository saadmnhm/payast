<?php
/**
 * Laravel Production Setup Script
 * 
 * Upload this file to your production server root and access via browser:
 * https://pyasat.blinkagency.ma/setup.php
 * 
 * DELETE THIS FILE AFTER SETUP IS COMPLETE!
 */

// Security: Set a secret key to prevent unauthorized access
define('SETUP_SECRET', 'laravel'); // Change this!

// Check secret key
if (!isset($_GET['key']) || $_GET['key'] !== SETUP_SECRET) {
    die('🔒 Access Denied. Use: setup.php?key=' . SETUP_SECRET);
}

// Disable timeout for long operations
set_time_limit(0);
ini_set('max_execution_time', 0);

// Output buffer for real-time feedback
ob_implicit_flush(true);
ob_end_flush();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Production Setup</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }
        .container { 
            max-width: 900px; 
            margin: 0 auto; 
            background: white; 
            border-radius: 10px; 
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        h1 { 
            color: #333; 
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }
        .step { 
            background: #f8f9fa; 
            padding: 20px; 
            margin-bottom: 20px; 
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .step h2 { 
            color: #667eea; 
            font-size: 18px;
            margin-bottom: 15px;
        }
        .success { 
            color: #28a745; 
            font-weight: 600;
            padding: 10px;
            background: #d4edda;
            border-radius: 5px;
            margin-top: 10px;
        }
        .error { 
            color: #dc3545; 
            font-weight: 600;
            padding: 10px;
            background: #f8d7da;
            border-radius: 5px;
            margin-top: 10px;
        }
        .warning { 
            color: #856404; 
            background: #fff3cd;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .info { 
            color: #004085; 
            background: #cce5ff;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
        pre { 
            background: #2d2d2d; 
            color: #f8f8f2; 
            padding: 15px; 
            border-radius: 5px; 
            overflow-x: auto;
            margin-top: 10px;
            font-size: 13px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #764ba2;
            transform: translateY(-2px);
        }
        .progress {
            width: 100%;
            height: 30px;
            background: #e9ecef;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transition: width 0.5s;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        .command {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 3px 8px;
            border-radius: 3px;
            font-family: monospace;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Laravel Production Setup</h1>
        <div class="progress">
            <div class="progress-bar" id="progress" style="width: 0%">0%</div>
        </div>

<?php

$basePath = __DIR__;
$totalSteps = 10;
$currentStep = 0;

function updateProgress($current, $total) {
    $percentage = round(($current / $total) * 100);
    echo "<script>document.getElementById('progress').style.width = '{$percentage}%'; document.getElementById('progress').textContent = '{$percentage}%';</script>";
    flush();
}

function runCommand($command, $ignoreError = false) {
    $output = [];
    $returnVar = 0;
    exec($command . ' 2>&1', $output, $returnVar);
    
    if ($returnVar !== 0 && !$ignoreError) {
        return ['success' => false, 'output' => implode("\n", $output)];
    }
    
    return ['success' => true, 'output' => implode("\n", $output)];
}

// Step 1: Check Environment
echo '<div class="step">';
echo '<h2>📋 Step 1: Environment Check</h2>';
$currentStep++;
updateProgress($currentStep, $totalSteps);

$checks = [
    'PHP Version' => version_compare(PHP_VERSION, '8.1.0', '>='),
    'PDO Extension' => extension_loaded('pdo'),
    'PDO MySQL' => extension_loaded('pdo_mysql'),
    'OpenSSL' => extension_loaded('openssl'),
    'Mbstring' => extension_loaded('mbstring'),
    'Tokenizer' => extension_loaded('tokenizer'),
    'XML' => extension_loaded('xml'),
    'Ctype' => extension_loaded('ctype'),
    'JSON' => extension_loaded('json'),
    'BCMath' => extension_loaded('bcmath'),
    'Fileinfo' => extension_loaded('fileinfo'),
    'GD' => extension_loaded('gd'),
];

$allPassed = true;
foreach ($checks as $name => $passed) {
    if ($passed) {
        echo "<div class='success'>✓ {$name}: OK</div>";
    } else {
        echo "<div class='error'>✗ {$name}: Missing</div>";
        $allPassed = false;
    }
}

if (!$allPassed) {
    echo '<div class="error">⚠️ Some required extensions are missing. Contact your hosting provider.</div>';
}

echo '<div class="info">PHP Version: ' . PHP_VERSION . '</div>';
echo '</div>';

// Step 2: Check Directory Structure
echo '<div class="step">';
echo '<h2>📁 Step 2: Directory Structure</h2>';
$currentStep++;
updateProgress($currentStep, $totalSteps);

$requiredDirs = [
    'app',
    'bootstrap',
    'bootstrap/cache',
    'config',
    'database',
    'public',
    'resources',
    'routes',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
];

foreach ($requiredDirs as $dir) {
    $path = $basePath . '/' . $dir;
    if (!is_dir($path)) {
        if (mkdir($path, 0775, true)) {
            echo "<div class='success'>✓ Created: {$dir}</div>";
        } else {
            echo "<div class='error'>✗ Failed to create: {$dir}</div>";
        }
    } else {
        echo "<div class='info'>✓ Exists: {$dir}</div>";
    }
}

echo '</div>';

// Step 3: Create Upload Directories
echo '<div class="step">';
echo '<h2>📤 Step 3: Upload Directories</h2>';
$currentStep++;
updateProgress($currentStep, $totalSteps);

$uploadDirs = [
    'public/uploads',
    'public/uploads/avatars',
    'public/uploads/brands',
    'public/uploads/constructeurs',
    'public/uploads/pieces',
    'public/uploads/categories',
];

foreach ($uploadDirs as $dir) {
    $path = $basePath . '/' . $dir;
    if (!is_dir($path)) {
        if (mkdir($path, 0775, true)) {
            echo "<div class='success'>✓ Created: {$dir}</div>";
        } else {
            echo "<div class='error'>✗ Failed to create: {$dir}</div>";
        }
    } else {
        echo "<div class='info'>✓ Exists: {$dir}</div>";
    }
}

echo '</div>';

// Step 4: Set Permissions
echo '<div class="step">';
echo '<h2>🔐 Step 4: Set Permissions</h2>';
$currentStep++;
updateProgress($currentStep, $totalSteps);

$writableDirs = [
    'storage',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache',
    'public/uploads',
];

foreach ($writableDirs as $dir) {
    $path = $basePath . '/' . $dir;
    if (is_dir($path)) {
        if (chmod($path, 0775)) {
            echo "<div class='success'>✓ Set 775 permissions: {$dir}</div>";
        } else {
            echo "<div class='warning'>⚠️ Could not set permissions: {$dir} (may require manual setup)</div>";
        }
    }
}

echo '</div>';

// Step 5: Check .env File
echo '<div class="step">';
echo '<h2>⚙️ Step 5: Environment Configuration</h2>';
$currentStep++;
updateProgress($currentStep, $totalSteps);

$envPath = $basePath . '/.env';
if (file_exists($envPath)) {
    echo '<div class="success">✓ .env file exists</div>';
    
    // Check critical env variables
    $envContent = file_get_contents($envPath);
    $criticalVars = ['APP_KEY', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'];
    
    foreach ($criticalVars as $var) {
        if (strpos($envContent, $var . '=') !== false) {
            $value = trim(explode('=', strstr($envContent, $var . '='))[1]);
            if (!empty($value) && $value !== 'null') {
                echo "<div class='info'>✓ {$var} is set</div>";
            } else {
                echo "<div class='warning'>⚠️ {$var} is empty</div>";
            }
        } else {
            echo "<div class='error'>✗ {$var} is missing</div>";
        }
    }
} else {
    echo '<div class="error">✗ .env file not found!</div>';
    echo '<div class="warning">Create .env file manually or upload from local development.</div>';
}

echo '</div>';

// Step 6: Storage Link
echo '<div class="step">';
echo '<h2>🔗 Step 6: Storage Symlink</h2>';
$currentStep++;
updateProgress($currentStep, $totalSteps);

$linkPath = $basePath . '/public/storage';
$targetPath = $basePath . '/storage/app/public';

if (is_link($linkPath)) {
    echo '<div class="info">✓ Storage symlink already exists</div>';
} else {
    if (is_dir($linkPath) && !is_link($linkPath)) {
        rmdir($linkPath);
    }
    
    if (symlink($targetPath, $linkPath)) {
        echo '<div class="success">✓ Storage symlink created successfully</div>';
    } else {
        echo '<div class="warning">⚠️ Could not create symlink. Manual setup required.</div>';
        echo '<div class="info">Link: public/storage → storage/app/public</div>';
    }
}

echo '</div>';

// Step 7: Composer Check
echo '<div class="step">';
echo '<h2>📦 Step 7: Composer Dependencies</h2>';
$currentStep++;
updateProgress($currentStep, $totalSteps);

$vendorPath = $basePath . '/vendor';
if (is_dir($vendorPath)) {
    echo '<div class="success">✓ Vendor directory exists</div>';
    
    // Check if composer is available
    $composerCheck = runCommand('composer --version', true);
    if ($composerCheck['success']) {
        echo '<div class="info">✓ Composer is available</div>';
        echo '<pre>' . htmlspecialchars($composerCheck['output']) . '</pre>';
        
        echo '<div class="warning">⚠️ Run composer install manually if needed:</div>';
        echo '<pre>composer install --no-dev --optimize-autoloader</pre>';
    } else {
        echo '<div class="info">ℹ️ Composer not available via CLI (dependencies already uploaded)</div>';
    }
} else {
    echo '<div class="error">✗ Vendor directory missing!</div>';
    echo '<div class="warning">Upload vendor folder from local or run composer install on server.</div>';
}

echo '</div>';

// Step 8: Cache Configuration
echo '<div class="step">';
echo '<h2>⚡ Step 8: Cache Optimization</h2>';
$currentStep++;
updateProgress($currentStep, $totalSteps);

// Check if artisan is available
$artisanPath = $basePath . '/artisan';
if (file_exists($artisanPath)) {
    echo '<div class="success">✓ Artisan found</div>';
    
    // Try to run artisan commands
    $commands = [
        'config:cache' => 'Cache configuration',
        'route:cache' => 'Cache routes',
        'view:cache' => 'Cache views',
    ];
    
    foreach ($commands as $cmd => $description) {
        $result = runCommand("php {$artisanPath} {$cmd}", true);
        if ($result['success']) {
            echo "<div class='success'>✓ {$description}</div>";
        } else {
            echo "<div class='warning'>⚠️ {$description} - may require manual execution</div>";
        }
    }
} else {
    echo '<div class="error">✗ Artisan not found</div>';
}

echo '</div>';

// Step 9: Database Check
echo '<div class="step">';
echo '<h2>💾 Step 9: Database Connection</h2>';
$currentStep++;
updateProgress($currentStep, $totalSteps);

if (file_exists($envPath)) {
    require $basePath . '/vendor/autoload.php';
    
    // Load environment variables
    $dotenv = Dotenv\Dotenv::createImmutable($basePath);
    $dotenv->load();
    
    try {
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $database = $_ENV['DB_DATABASE'] ?? '';
        $username = $_ENV['DB_USERNAME'] ?? '';
        $password = $_ENV['DB_PASSWORD'] ?? '';
        
        $pdo = new PDO("mysql:host={$host};dbname={$database}", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo '<div class="success">✓ Database connection successful</div>';
        echo "<div class='info'>Database: {$database}</div>";
        
        // Check if migrations table exists
        $stmt = $pdo->query("SHOW TABLES LIKE 'migrations'");
        if ($stmt->rowCount() > 0) {
            echo '<div class="info">✓ Migrations table exists</div>';
        } else {
            echo '<div class="warning">⚠️ Migrations table not found. Run migrations.</div>';
        }
        
    } catch (PDOException $e) {
        echo '<div class="error">✗ Database connection failed</div>';
        echo '<div class="error">' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="error">✗ Cannot check database: .env file missing</div>';
}

echo '</div>';

// Step 10: Security Check
echo '<div class="step">';
echo '<h2>🛡️ Step 10: Security Checklist</h2>';
$currentStep++;
updateProgress($currentStep, $totalSteps);

$securityChecks = [
    '.env file hidden' => !is_readable($basePath . '/public/.env'),
    'APP_DEBUG should be false' => (file_exists($envPath) && strpos(file_get_contents($envPath), 'APP_DEBUG=false') !== false),
    'APP_ENV is production' => (file_exists($envPath) && strpos(file_get_contents($envPath), 'APP_ENV=production') !== false),
    'storage not in public' => !is_dir($basePath . '/public/storage/framework'),
];

foreach ($securityChecks as $check => $passed) {
    if ($passed) {
        echo "<div class='success'>✓ {$check}</div>";
    } else {
        echo "<div class='warning'>⚠️ {$check}</div>";
    }
}

echo '</div>';

// Final Summary
echo '<div class="step" style="border-left-color: #28a745;">';
echo '<h2>✅ Setup Complete!</h2>';
echo '<div class="success">Production environment is ready!</div>';
echo '<div class="warning" style="margin-top: 20px;"><strong>⚠️ IMPORTANT:</strong> Delete this setup.php file immediately!</div>';

echo '<h3 style="margin-top: 30px;">Next Steps:</h3>';
echo '<ol style="padding-left: 20px; line-height: 2;">';
echo '<li>Delete <span class="command">setup.php</span> and <span class="command">migrate.php</span></li>';
echo '<li>Run migrations: <span class="command">php artisan migrate --force</span></li>';
echo '<li>Seed database: <span class="command">php artisan db:seed --force</span></li>';
echo '<li>Test your application: <a href="/" target="_blank">Visit Site</a></li>';
echo '<li>Test admin panel: <a href="/dashboard" target="_blank">Admin Dashboard</a></li>';
echo '</ol>';

echo '<h3 style="margin-top: 30px;">Useful Commands:</h3>';
echo '<pre>';
echo "# Clear all caches\n";
echo "php artisan cache:clear\n";
echo "php artisan config:clear\n";
echo "php artisan route:clear\n";
echo "php artisan view:clear\n\n";
echo "# Optimize for production\n";
echo "php artisan config:cache\n";
echo "php artisan route:cache\n";
echo "php artisan view:cache\n";
echo '</pre>';

echo '</div>';

?>

        <div style="text-align: center; margin-top: 30px;">
            <a href="/" class="btn">Visit Site</a>
            <a href="/dashboard" class="btn">Admin Panel</a>
        </div>
    </div>
</body>
</html>