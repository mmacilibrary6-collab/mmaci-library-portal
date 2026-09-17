<!DOCTYPE html>
<html lang="en">
<head>
    @php
        $storedType = strtolower($borrower->borrower_type ?? '');
        $requestedType = strtolower(request('type', ''));
        $cardType = in_array($requestedType, ['student', 'faculty'], true)
            ? $requestedType
            : (in_array($storedType, ['student', 'faculty'], true) ? $storedType : 'student');

        $cardTitle = $cardType === 'faculty'
            ? "Faculty Borrower's Card"
            : "Student Borrower's Card";
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cardTitle }} - {{ $borrower->name }}</title>

    <style>
        @page{size:Letter landscape;margin:0}
        *{box-sizing:border-box}
        html,body{margin:0;padding:0}
        body{color:#111;background:#ececec;font-family:"Times New Roman",Times,serif}
        .print-toolbar{
            min-height:64px;padding:10px 18px;display:flex;align-items:center;justify-content:center;
            gap:12px;background:#0b315e;font-family:Arial,sans-serif;
        }
        .toolbar-label{color:#fff;font-size:12px;font-weight:700}
        .card-type-control{
            height:42px;padding:0 12px;color:#0b315e;background:#fff;border:1px solid rgba(255,255,255,.75);
            border-radius:8px;font-size:13px;font-weight:700;outline:none;cursor:pointer;
        }
        .print-button{
            min-height:42px;padding:0 20px;color:#0b315e;background:#ffbd00;border:0;border-radius:8px;
            font-size:13px;font-weight:700;cursor:pointer;
        }
        .sheet{
            width:11in;min-height:8.5in;margin:18px auto;padding:.42in .45in .38in;
            background:#fff;box-shadow:0 12px 32px rgba(0,0,0,.14);
        }
        .header-table{width:100%;border-collapse:collapse;table-layout:fixed}
        .header-table>tbody>tr>td{padding:0}
        .header-left,.header-right{width:29%;vertical-align:bottom;padding-bottom:.04in!important}
        .header-center{width:42%;padding:0 .14in!important;text-align:center;vertical-align:top!important}
        .school-logo{width:.70in;height:.70in;display:block;margin:0 auto .04in;object-fit:contain}
        .school-name{margin:0;font-size:15pt;font-weight:700;line-height:1.02;text-transform:uppercase}
        .school-address{margin:.05in 0 .08in;font-size:7.5pt;line-height:1.18}

        .school-email {
            color: #0066cc;
            text-decoration: underline;
            text-underline-offset: 1px;
        }

        .library-title{margin:0;font-size:12.5pt;font-weight:700;line-height:1.05;text-transform:uppercase}
        .card-title{margin:.02in 0 0;font-size:13.8pt;font-weight:700;line-height:1.05;text-transform:uppercase}
        .person-info{width:100%;border-collapse:collapse;table-layout:fixed;font-size:10.8pt}
        .person-info td{height:.29in;padding:0;vertical-align:bottom}
        .person-info .label{width:1.08in;padding-right:.06in;font-weight:700;white-space:nowrap}
        .header-left .person-info .label{width:1.36in}
        .header-right .person-info .label{width:1.08in}
        .person-info .value{
            padding:0 .04in .02in;border-bottom:1px solid #222;font-weight:400;white-space:nowrap;overflow:hidden;
        }
        .borrow-table{width:100%;margin-top:.13in;border-collapse:collapse;table-layout:fixed}
        .borrow-table th,.borrow-table td{border:1px solid #222}
        .borrow-table th{
            height:.44in;padding:.03in;text-align:center;vertical-align:middle;font-size:9.8pt;
            font-weight:700;line-height:1.03;
        }
        .borrow-table td{
            height:.60in;padding:.055in .06in;vertical-align:middle;font-size:10pt;
            line-height:1.18;overflow-wrap:anywhere;
        }
        .borrow-table tbody td:nth-child(1),
        .borrow-table tbody td:nth-child(2),
        .borrow-table tbody td:nth-child(3),
        .borrow-table tbody td:nth-child(5),
        .borrow-table tbody td:nth-child(6){text-align:center;font-size:9.6pt}
        .borrow-table tbody td:nth-child(4){text-align:left;font-size:10.2pt;line-height:1.22}
        .borrow-table tbody td:nth-child(7){font-size:9.5pt;line-height:1.18}
        .date-col{width:10.5%}.due-col{width:10%}.accession-col{width:10%}.description-col{width:38%}
        .received-col{width:9%}.returned-col{width:9%}.remarks-col{width:13.5%}
        .form-box{
            width:3.05in;margin-top:.12in;padding:.08in .10in;border:1px solid #222;
            font-size:9pt;line-height:1.38;
        }
        .form-table{width:100%;border-collapse:collapse;table-layout:fixed}
        .form-table td{padding:.012in 0;vertical-align:top}
        .form-table .form-label{width:1.05in;padding-right:.08in;white-space:nowrap}
        .form-table .form-value{font-weight:700;white-space:nowrap}
        @media print{
            html,body{
                width:11in;height:8.5in;margin:0!important;padding:0!important;background:#fff!important;
            }
            .print-toolbar{display:none!important}
            .sheet{
                width:11in;min-height:8.5in;margin:0!important;padding:.42in .45in .38in!important;
                box-shadow:none!important;background:#fff!important;
            }
            .header-table,.borrow-table,.form-box{break-inside:avoid;page-break-inside:avoid}
        }
    </style>
</head>
<body>
    <div class="print-toolbar">
        <span class="toolbar-label">Card Type:</span>

        <select id="cardType" class="card-type-control" onchange="changeCardType(this.value)">
            <option value="student" {{ $cardType === 'student' ? 'selected' : '' }}>Student</option>
            <option value="faculty" {{ $cardType === 'faculty' ? 'selected' : '' }}>Faculty</option>
        </select>

        <button type="button" class="print-button" onclick="printBorrowerCard()">
            Print Borrower Card
        </button>
    </div>

    <main class="sheet">
        <table class="header-table">
            <tbody>
                <tr>
                    <td class="header-left">
                        <table class="person-info">
                            <tbody>
                                <tr><td class="label">Name :</td><td class="value">{{ $borrower->name }}</td></tr>
                                <tr><td class="label">ID # :</td><td class="value">{{ $borrower->id_number }}</td></tr>
                                <tr><td class="label">Contact Number :</td><td class="value">{{ $borrower->contact_number ?: '' }}</td></tr>
                            </tbody>
                        </table>
                    </td>

                    <td class="header-center">
                        <img src="{{ asset('images/logomml.webp') }}" alt="MMACI Logo" class="school-logo">

                        <h1 class="school-name">Merchant Marine Academy of Caraga, Inc.</h1>

                        <div class="school-address">
                            North Montilla Boulevard, Brgy. Ong-Yiu, Butuan City, 8600<br>
                            Tel. No.: (085) 817 0476 Mobile No.: (+63) 917 105 9644 (Globe)<br>
                            E-mail Address: <span class="school-email">mmaci2018.bxu@gmail.com</span>
                        </div>

                        <h2 class="library-title">Library System</h2>
                        <h3 class="card-title">{{ strtoupper($cardTitle) }}</h3>
                    </td>

                    <td class="header-right">
                        <table class="person-info">
                            <tbody>
                                <tr><td class="label">Department :</td><td class="value">{{ $borrower->department ?: '' }}</td></tr>
                                <tr><td class="label">Semester :</td><td class="value">{{ $borrower->semester ?: '' }}</td></tr>
                                <tr><td class="label">Email Address :</td><td class="value">{{ $borrower->email ?: '' }}</td></tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="borrow-table">
            <thead>
                <tr>
                    <th class="date-col">Date<br>Borrowed</th>
                    <th class="due-col">DUE<br>DATE</th>
                    <th class="accession-col">Accession<br>#</th>
                    <th class="description-col">Bibliographical Description of Book</th>
                    <th class="received-col">Received<br>by</th>
                    <th class="returned-col">Returned<br>By</th>
                    <th class="remarks-col">Remarks</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $rows = $borrower->borrowings->take(5);
                    $emptyRows = max(0, 5 - $rows->count());
                @endphp

                @foreach($rows as $borrowing)
                    <tr>
                        <td>{{ optional($borrowing->date_borrowed)->format('m/d/Y') }}</td>
                        <td>{{ optional($borrowing->due_date)->format('m/d/Y') }}</td>
                        <td>{{ $borrowing->accession_number }}</td>
                        <td>{{ $borrowing->bibliographical_description }}</td>
                        <td>{{ $borrowing->received_by ?: '' }}</td>
                        <td>{{ $borrowing->returned_by ?: '' }}</td>
                        <td>{{ $borrowing->remarks ?: '' }}</td>
                    </tr>
                @endforeach

                @for($i = 0; $i < $emptyRows; $i++)
                    <tr>
                        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <div class="form-box">
            <table class="form-table">
                <tbody>
                    <tr><td class="form-label">Form No.:</td><td class="form-value">QF-SOF-LRC-BRB-03</td></tr>
                    <tr><td class="form-label">Revised Status:</td><td class="form-value">03</td></tr>
                    <tr><td class="form-label">Revision No.:</td><td class="form-value">00</td></tr>
                    <tr><td class="form-label">Date Approved:</td><td class="form-value">09 February 2023</td></tr>
                    <tr><td class="form-label">Date effective:</td><td class="form-value">16 December 2025</td></tr>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        function changeCardType(type) {
            const url = new URL(window.location.href);
            url.searchParams.set('type', type);
            window.location.href = url.toString();
        }

        function printBorrowerCard() {
            const originalTitle = document.title;
            document.title = ' ';
            window.print();

            setTimeout(function () {
                document.title = originalTitle;
            }, 500);
        }

        window.addEventListener('afterprint', function () {
            if (!document.title.trim()) {
                document.title = @json($cardTitle . ' - ' . $borrower->name);
            }
        });
    </script>
</body>
</html>
