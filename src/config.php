<?php

// If environment variables are not set, fallback to these defaults
define('DB_HOST', getenv('DB_HOST') ?: 'db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: 'rootpassword');
define('DB_NAME', getenv('DB_NAME') ?: 'vacation_db');