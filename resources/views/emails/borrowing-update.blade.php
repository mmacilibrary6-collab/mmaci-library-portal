@php
    $notice = match ($event) {
        'approved' => ['label' => 'Request approved', 'title' => 'Your next read awaits.', 'intro' => 'Your borrowing request has been approved. Please visit the library to collect your book.', 'next' => 'Library staff will confirm your loan dates when your book is released.', 'color' => '#246653', 'background' => '#eaf5ef'],
        'rejected' => ['label' => 'Request update', 'title' => 'An update on your request.', 'intro' => 'Your borrowing request was not approved. Our library staff can help you explore other available books.', 'next' => 'Please contact the library for assistance or to ask about another available book.', 'color' => '#76552c', 'background' => '#faf1e3'],
        'due' => ['label' => 'Due today', 'title' => 'A friendly return reminder.', 'intro' => 'Your borrowed book is due today. Thank you for helping keep our collection available to everyone.', 'next' => 'Please return your book by the end of library hours, or contact library staff if you need assistance.', 'color' => '#76552c', 'background' => '#faf1e3'],
        default => ['label' => 'Overdue', 'title' => 'Let’s get your book back.', 'intro' => 'Your borrowed book is overdue. Returning it promptly helps another reader begin their next chapter.', 'next' => 'Please return your book to the library as soon as possible, or contact library staff for assistance.', 'color' => '#9a3e3e', 'background' => '#faeded'],
    };
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MMACI Library borrowing update</title>
</head>
<body style="margin:0;padding:0;background-color:#eef2f6;color:#243b53;font-family:Arial,Helvetica,sans-serif;-webkit-text-size-adjust:100%;">
    <div style="display:none;font-size:1px;line-height:1px;color:#eef2f6;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;">{{ $notice['label'] }} — {{ $borrowing->bibliographical_description }}. {{ $notice['next'] }}</div>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#eef2f6;">
        <tr><td align="center" style="padding:32px 12px;">
            <!--[if mso]><table role="presentation" width="600" align="center"><tr><td><![endif]-->
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:600px;background-color:#ffffff;border:1px solid #dfe6ee;border-radius:16px;overflow:hidden;">
                <tr><td style="padding:28px 30px;background-color:#102f54;border-radius:15px 15px 0 0;">
                    <p style="margin:0 0 6px;color:#f0c66b;font-size:11px;font-weight:bold;letter-spacing:3px;text-transform:uppercase;">Read. Discover. Grow.</p>
                    <p style="margin:0;color:#ffffff;font-size:25px;line-height:32px;font-weight:bold;">MMACI Library</p>
                    <p style="margin:5px 0 0;color:#c8d5e5;font-size:12px;line-height:20px;">Library Services Office</p>
                </td></tr>
                <tr><td height="4" style="height:4px;background-color:#e8ba57;font-size:0;line-height:0;">&nbsp;</td></tr>
                <tr><td style="padding:32px 30px 0;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0"><tr><td style="padding:7px 12px;border-radius:6px;background-color:{{ $notice['background'] }};color:{{ $notice['color'] }};font-size:11px;font-weight:bold;letter-spacing:1px;text-transform:uppercase;">{{ $notice['label'] }}</td></tr></table>
                    <h1 style="margin:20px 0 22px;font-family:Georgia,'Times New Roman',serif;font-size:32px;line-height:39px;font-weight:normal;color:#102f54;">{{ $notice['title'] }}</h1>
                    <p style="margin:0 0 12px;font-size:15px;line-height:25px;">Hello <strong>{{ $borrowing->borrower->name }}</strong>,</p>
                    <p style="margin:0;font-size:15px;line-height:25px;color:#526477;">{{ $notice['intro'] }}</p>
                </td></tr>
                <tr><td style="padding:26px 30px;">
                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f5f7fa;border:1px solid #e3e9f0;border-radius:10px;">
                        <tr><td style="padding:22px;overflow-wrap:anywhere;word-break:break-word;">
                            <p style="margin:0 0 9px;font-size:10px;line-height:16px;letter-spacing:2px;font-weight:bold;color:#708197;text-transform:uppercase;">Your book</p>
                            <p style="margin:0 0 18px;font-family:Georgia,'Times New Roman',serif;font-size:22px;line-height:30px;color:#102f54;">{{ $borrowing->bibliographical_description }}</p>
                            <p style="margin:0;padding-top:14px;border-top:1px solid #dde5ee;font-size:12px;line-height:23px;color:#526477;">Request reference: <strong style="color:#243b53;">#{{ $borrowing->id }}</strong></p>
                            @if($borrowing->accession_number)
                                <p style="margin:0;font-size:12px;line-height:23px;color:#526477;">Accession number: <strong style="color:#243b53;">{{ $borrowing->accession_number }}</strong></p>
                            @endif
                            @if(in_array($event, ['due', 'overdue'], true))
                                <p style="margin:10px 0 0;font-size:13px;line-height:23px;color:{{ $notice['color'] }};">Due date: <strong>{{ $borrowing->due_date?->format('F d, Y') }}</strong></p>
                            @endif
                        </td></tr>
                    </table>
                </td></tr>
                <tr><td style="padding:0 30px 30px;">
                    <p style="margin:0 0 8px;font-size:12px;font-weight:bold;letter-spacing:1px;color:#102f54;text-transform:uppercase;">What happens next</p>
                    <p style="margin:0 0 25px;font-size:14px;line-height:24px;color:#526477;">{{ $notice['next'] }}</p>
                    <p style="margin:0;font-size:14px;line-height:23px;color:#526477;">Warm regards,<br><strong style="color:#102f54;">Your MMACI Library team</strong></p>
                </td></tr>
                <tr><td style="padding:20px 30px;background-color:#f8fafc;border-top:1px solid #e7edf3;border-radius:0 0 15px 15px;">
                    <p style="margin:0;font-size:11px;line-height:19px;color:#78879a;">This is an update about your library borrowing record.<br>For questions about your request, please contact the Library Services Office.</p>
                </td></tr>
            </table>
            <!--[if mso]></td></tr></table><![endif]-->
            <p style="margin:18px 0 0;font-size:11px;line-height:18px;color:#8290a2;">MMACI &nbsp;&middot;&nbsp; Library Services Office</p>
        </td></tr>
    </table>
</body>
</html>
