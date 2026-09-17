<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Borrower's Card - {{ $borrower->name }}</title>
    <style>
        @page {
            size: letter landscape;
            margin: 10mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: #111;
            background: #f3f4f6;
            font-family: "Times New Roman", Times, serif;
        }

        .print-toolbar {
            padding: 14px;
            text-align: center;
            background: #0b2e59;
        }

        .print-toolbar button {
            padding: 10px 18px;
            color: #0b2e59;
            background: #f4b400;
            border: 0;
            border-radius: 6px;
            font: 700 14px Arial, sans-serif;
            cursor: pointer;
        }

        .card-sheet {
            width: 10.5in;
            min-height: 7.7in;
            margin: 18px auto;
            padding: .32in .36in .28in;
            background: #fff;
            box-shadow: 0 18px 45px rgba(0, 0, 0, .18);
        }

        .card-header {
            display: grid;
            grid-template-columns: 1fr 98px 1.12fr;
            align-items: start;
            gap: 18px;
        }

        .borrower-lines {
            padding-top: 76px;
            font-size: 19px;
            font-weight: 700;
            line-height: 1.52;
        }

        .line-field {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 8px;
            align-items: end;
        }

        .line-field span:last-child {
            min-height: 23px;
            border-bottom: 2px solid #333;
            font-weight: 400;
        }

        .institution {
            text-align: center;
        }

        .institution img {
            width: 82px;
            height: 82px;
            object-fit: contain;
            margin-bottom: 8px;
        }

        .institution h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            text-decoration: underline;
            text-transform: uppercase;
            line-height: 1.08;
        }

        .institution .address {
            margin: 6px 0 11px;
            font-size: 12px;
            line-height: 1.16;
        }

        .institution h2,
        .institution h3 {
            margin: 0;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 1.12;
        }

        .institution h2 {
            font-size: 19px;
        }

        .institution h3 {
            font-size: 20px;
        }

        .right-lines {
            padding-top: 124px;
            font-size: 19px;
            font-weight: 700;
            line-height: 1.52;
        }

        .borrow-table {
            width: 100%;
            margin-top: 22px;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 13px;
        }

        .borrow-table th,
        .borrow-table td {
            border: 1.7px solid #333;
            padding: 5px 6px;
            vertical-align: top;
        }

        .borrow-table th {
            height: 54px;
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            line-height: 1.06;
        }

        .borrow-table td {
            height: 45px;
            font-size: 12px;
            line-height: 1.25;
        }

        .date-col { width: 11%; }
        .due-col { width: 10%; }
        .accession-col { width: 10%; }
        .description-col { width: 38%; }
        .received-col { width: 9%; }
        .returned-col { width: 9%; }
        .remarks-col { width: 13%; }

        .form-box {
            width: 190px;
            margin-top: 26px;
            border: 2px solid #333;
            padding: 10px 12px;
            font-size: 12px;
            line-height: 1.45;
        }

        .form-row {
            display: grid;
            grid-template-columns: 92px 1fr;
            gap: 8px;
        }

        @media print {
            body {
                background: #fff;
            }

            .print-toolbar {
                display: none;
            }

            .card-sheet {
                width: auto;
                min-height: 0;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="print-toolbar">
        <button type="button" onclick="window.print()">Print Borrower Card</button>
    </div>

    <main class="card-sheet">
        <header class="card-header">
            <section class="borrower-lines">
                <div class="line-field"><span>Name :</span><span>{{ $borrower->name }}</span></div>
                <div class="line-field"><span>ID # :</span><span>{{ $borrower->id_number }}</span></div>
                <div class="line-field"><span>Contact Number:</span><span>{{ $borrower->contact_number }}</span></div>
            </section>

            <section class="institution">
                <img src="{{ asset('images/logomml.webp') }}" alt="MMACI Logo">
                <h1>Merchant Marine Academy of Caraga, Inc.</h1>
                <p class="address">
                    North Montilla Boulevard, Brgy. Ong-Yiu, Butuan City, 8600<br>
                    Tel. No.: (085) 817 0476 Mobile No.: (+63) 917 105 9644 (Globe)<br>
                    E-mail Address: mmaci2018.btuan@gmail.com
                </p>
                <h2>Library System</h2>
                <h3>Faculty Borrower's Card</h3>
            </section>

            <section class="right-lines">
                <div class="line-field"><span>Department :</span><span>{{ $borrower->department }}</span></div>
                <div class="line-field"><span>Semester :</span><span>{{ $borrower->semester }}</span></div>
                <div class="line-field"><span>Email Address:</span><span>{{ $borrower->email }}</span></div>
            </section>
        </header>

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
                    $rows = $borrower->borrowings->take(8);
                    $emptyRows = max(0, 8 - $rows->count());
                @endphp

                @foreach($rows as $borrowing)
                    <tr>
                        <td>{{ optional($borrowing->date_borrowed)->format('m/d/Y') }}</td>
                        <td>{{ optional($borrowing->due_date)->format('m/d/Y') }}</td>
                        <td>{{ $borrowing->accession_number }}</td>
                        <td>{{ $borrowing->bibliographical_description }}</td>
                        <td>{{ $borrowing->received_by }}</td>
                        <td>{{ $borrowing->returned_by }}</td>
                        <td>{{ $borrowing->remarks }}</td>
                    </tr>
                @endforeach

                @for($i = 0; $i < $emptyRows; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <section class="form-box">
            <div class="form-row"><span>Form No.:</span><strong>QF-SOF-LRC-BRB-03</strong></div>
            <div class="form-row"><span>Revised Status:</span><strong>03</strong></div>
            <div class="form-row"><span>Revision No.:</span><strong>00</strong></div>
            <div class="form-row"><span>Date Approved:</span><strong>09 February 2023</strong></div>
            <div class="form-row"><span>Date effective:</span><strong>16 December 2025</strong></div>
        </section>
    </main>
</body>
</html>
