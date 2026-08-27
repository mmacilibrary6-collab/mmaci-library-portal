<?php

return [
    'visitor_log_retention_days' => env('VISITOR_LOG_RETENTION_DAYS', 90),
    'visitor_log_dedupe_seconds' => env('VISITOR_LOG_DEDUPE_SECONDS', 30),
];
