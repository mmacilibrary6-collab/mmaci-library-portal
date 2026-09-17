<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><title>MMACI Library borrowing update</title></head>
<body style="font-family:Arial,sans-serif;color:#18385f;line-height:1.6;max-width:600px;margin:24px auto;padding:24px;">
    <h1 style="font-size:24px;">MMACI Library Services Office</h1>
    <p>Hello {{ $borrowing->borrower->name }},</p>
    @if($event === 'approved')
        <p>Your borrowing request has been <strong>approved</strong>. Please visit the library to collect your book. Library staff will confirm your loan dates when the book is released.</p>
    @elseif($event === 'rejected')
        <p>Your borrowing request was <strong>not approved</strong>. Please contact the library for assistance or to ask about another available book.</p>
    @elseif($event === 'due')
        <p>Your borrowed book is <strong>due today</strong>. Please return it to the library by the end of library hours, or contact library staff if you need assistance.</p>
    @else
        <p>Your borrowed book is <strong>overdue</strong>. Please return it to the library as soon as possible, or contact library staff for assistance.</p>
    @endif
    <p><strong>Book:</strong> {{ $borrowing->bibliographical_description }}<br>
       <strong>Request reference:</strong> #{{ $borrowing->id }}
       @if($borrowing->accession_number)<br><strong>Accession number:</strong> {{ $borrowing->accession_number }}@endif
       @if(in_array($event, ['due', 'overdue'], true))<br><strong>Due date:</strong> {{ $borrowing->due_date->format('F d, Y') }}@endif
    </p>
    <p>Thank you,<br>MMACI Library Services Office</p>
</body>
</html>
