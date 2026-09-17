$ErrorActionPreference = 'Stop'

$portalRoot = (Resolve-Path (Join-Path $PSScriptRoot '..')).Path
$artisanPath = Join-Path $portalRoot 'artisan'
$phpExecutable = (Get-Command php -ErrorAction Stop).Source
$taskName = 'MMACI Library Borrowing Email Updates'

$action = New-ScheduledTaskAction -Execute $phpExecutable `
    -Argument ('"{0}" borrowings:send-updates' -f $artisanPath) `
    -WorkingDirectory $portalRoot
$trigger = New-ScheduledTaskTrigger -Once -At (Get-Date).AddMinutes(5) `
    -RepetitionInterval (New-TimeSpan -Hours 1)
$settings = New-ScheduledTaskSettingsSet -StartWhenAvailable `
    -AllowStartIfOnBatteries -DontStopIfGoingOnBatteries `
    -MultipleInstances IgnoreNew -ExecutionTimeLimit (New-TimeSpan -Minutes 30)

Register-ScheduledTask -TaskName $taskName -Action $action -Trigger $trigger `
    -Settings $settings -User 'SYSTEM' -RunLevel Highest `
    -Description 'Send borrower due-date reminders and retry pending approval/rejection emails through the portal SMTP configuration.' `
    -Force | Select-Object TaskName, State
