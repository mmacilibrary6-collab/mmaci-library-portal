<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Borrower's Card - {{ $borrower->name }}</title>

    <style>
        /*
         * IMPORTANT:
         * Keep @page margin at 0.
         * The actual printable margins are created inside .sheet.
         * This prevents Chrome/Edge from reserving the outer page-margin area
         * normally used for date, title, URL, and page-number print headers.
         */
        @page {
            size: Letter landscape;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            color: #111;
            background: #ececec;
            font-family: "Times New Roman", Times, serif;
        }

        .print-toolbar {
            padding: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: #0b315e;
            font-family: Arial, sans-serif;
        }

        .print-toolbar button {
            min-height: 42px;
            padding: 0 20px;
            color: #0b315e;
            background: #ffbd00;
            border: 0;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .print-note {
            margin: 0;
            color: rgba(255,255,255,.82);
            font-size: 11px;
        }

        /*
         * Screen preview:
         * Letter landscape is 11in x 8.5in.
         */
        .sheet {
            width: 11in;
            min-height: 8.5in;
            margin: 18px auto;
            padding: 0.42in 0.45in 0.38in;
            background: #fff;
            box-shadow: 0 12px 32px rgba(0,0,0,.14);
        }

        /* =========================
           HEADER
        ========================== */

        .header-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .header-table > tbody > tr > td {
            padding: 0;
        }

        .header-left,
        .header-right {
            width: 29%;
            vertical-align: bottom;
            padding-bottom: 0.04in !important;
        }

        .header-center {
            width: 42%;
            padding: 0 0.14in !important;
            text-align: center;
            vertical-align: top !important;
        }

        .school-logo {
            width: 0.70in;
            height: 0.70in;
            display: block;
            margin: 0 auto 0.04in;
            object-fit: contain;
        }

        .school-name {
            margin: 0;
            font-size: 15pt;
            font-weight: 700;
            line-height: 1.02;
            text-transform: uppercase;
        }

        .school-address {
            margin: 0.05in 0 0.08in;
            font-size: 7.5pt;
            line-height: 1.18;
        }

        .library-title {
            margin: 0;
            font-size: 12.5pt;
            font-weight: 700;
            line-height: 1.05;
            text-transform: uppercase;
        }

        .card-title {
            margin: 0.02in 0 0;
            font-size: 13.8pt;
            font-weight: 700;
            line-height: 1.05;
            text-transform: uppercase;
        }

        .person-info {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 10.2pt;
        }

        .person-info td {
            height: 0.29in;
            padding: 0;
            vertical-align: bottom;
        }

        .person-info .label {
            width: 1.08in;
            padding-right: 0.06in;
            font-weight: 700;
            white-space: nowrap;
        }

        .header-right .person-info .label {
            width: 1.08in;
        }

        .person-info .value {
            padding: 0 0.04in 0.02in;
            border-bottom: 1px solid #222;
            font-weight: 400;
            white-space: nowrap;
            overflow: hidden;
        }

        /* =========================
           BORROWING TABLE
        ========================== */

        .borrow-table {
            width: 100%;
            margin-top: 0.13in;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .borrow-table th,
        .borrow-table td {
            border: 1px solid #222;
        }

        .borrow-table th {
            height: 0.44in;
            padding: 0.03in;
            text-align: center;
            vertical-align: middle;
            font-size: 9.8pt;
            font-weight: 700;
            line-height: 1.03;
        }

        .borrow-table td {
            height: 0.60in;
            padding: 0.04in 0.045in;
            vertical-align: top;
            font-size: 8pt;
            line-height: 1.12;
            overflow-wrap: anywhere;
        }

        .date-col { width: 10.5%; }
        .due-col { width: 10%; }
        .accession-col { width: 10%; }
        .description-col { width: 38%; }
        .received-col { width: 9%; }
        .returned-col { width: 9%; }
        .remarks-col { width: 13.5%; }

        /* =========================
           FORM INFORMATION BOX
        ========================== */

        .form-box {
            width: 3.05in;
            margin-top: 0.12in;
            padding: 0.08in 0.10in;
            border: 1px solid #222;
            font-size: 8pt;
            line-height: 1.35;
        }

        .form-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .form-table td {
            padding: 0.012in 0;
            vertical-align: top;
        }

        .form-table .form-label {
            width: 1.05in;
            padding-right: 0.08in;
            white-space: nowrap;
        }

        .form-table .form-value {
            font-weight: 700;
            white-space: nowrap;
        }

        /* =========================
           PRINT
        ========================== */

        @media print {
            html,
            body {
                width: 11in;
                height: 8.5in;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
            }

            .print-toolbar {
                display: none !important;
            }

            .sheet {
                width: 11in;
                min-height: 8.5in;
                margin: 0 !important;

                /*
                 * These are the REAL visible print margins.
                 * They replace @page margins.
                 */
                padding: 0.42in 0.45in 0.38in !important;

                box-shadow: none !important;
                background: #fff !important;
            }

            .header-table,
            .borrow-table,
            .form-box {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    <div class="print-toolbar">
        <button type="button" onclick="printBorrowerCard()">
            Print Borrower Card
        </button>

        <p class="print-note">
            Letter · Landscape
        </p>
    </div>

    <main class="sheet">

        <table class="header-table">
            <tbody>
                <tr>

                    <td class="header-left">
                        <table class="person-info">
                            <tbody>
                                <tr>
                                    <td class="label">Name :</td>
                                    <td class="value">{{ $borrower->name }}</td>
                                </tr>

                                <tr>
                                    <td class="label">ID # :</td>
                                    <td class="value">{{ $borrower->id_number }}</td>
                                </tr>

                                <tr>
                                    <td class="label">Contact Number :</td>
                                    <td class="value">{{ $borrower->contact_number ?: '' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>

                    <td class="header-center">
                        <img
                            src="{{ asset('images/logomml.webp') }}"
                            alt="MMACI Logo"
                            class="school-logo">

                        <h1 class="school-name">
                            Merchant Marine Academy of Caraga, Inc.
                        </h1>

                        <div class="school-address">
                            North Montilla Boulevard, Brgy. Ong-Yiu, Butuan City, 8600<br>
                            Tel. No.: (085) 817 0476 Mobile No.: (+63) 917 105 9644 (Globe)<br>
                            E-mail Address: mmaci2018.btuan@gmail.com
                        </div>

                        <h2 class="library-title">Library System</h2>
                        <h3 class="card-title">Faculty Borrower's Card</h3>
                    </td>

                    <td class="header-right">
                        <table class="person-info">
                            <tbody>
                                <tr>
                                    <td class="label">Department :</td>
                                    <td class="value">{{ $borrower->department ?: '' }}</td>
                                </tr>

                                <tr>
                                    <td class="label">Semester :</td>
                                    <td class="value">{{ $borrower->semester ?: '' }}</td>
                                </tr>

                                <tr>
                                    <td class="label">Email Address :</td>
                                    <td class="value">{{ $borrower->email ?: '' }}</td>
                                </tr>
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
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <div class="form-box">
            <table class="form-table">
                <tbody>
                    <tr>
                        <td class="form-label">Form No.:</td>
                        <td class="form-value">QF-SOF-LRC-BRB-03</td>
                    </tr>

                    <tr>
                        <td class="form-label">Revised Status:</td>
                        <td class="form-value">03</td>
                    </tr>

                    <tr>
                        <td class="form-label">Revision No.:</td>
                        <td class="form-value">00</td>
                    </tr>

                    <tr>
                        <td class="form-label">Date Approved:</td>
                        <td class="form-value">09 February 2023</td>
                    </tr>

                    <tr>
                        <td class="form-label">Date effective:</td>
                        <td class="form-value">16 December 2025</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

    <script>
        function printBorrowerCard() {
            const originalTitle = document.title;

            /*
             * Chrome/Edge may use document.title as the center print header.
             * Temporarily blank it before opening the print dialog.
             */
            document.title = ' ';

            window.print();

            /*
             * Restore the normal browser-tab title after printing.
             */
            setTimeout(function () {
                document.title = originalTitle;
            }, 500);
        }

        window.addEventListener('afterprint', function () {
            if (!document.title.trim()) {
                document.title = "Faculty Borrower's Card - {{ addslashes($borrower->name) }}";
            }
        });
    </script>

</body>
</html>
