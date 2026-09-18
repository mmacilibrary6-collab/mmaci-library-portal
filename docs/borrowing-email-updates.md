# Borrowing requests and email updates

Public requests require borrower information, an email address, and a book title.
They do not accept an accession number. Staff assign a copy in Edit Record before
approving the request. Rejection does not require a copy assignment.

Approval and rejection send through the existing Laravel mail configuration as
soon as the action succeeds. The borrowing action stays saved if SMTP fails.
Pending messages are stored in `borrowing_email_updates` and retried hourly.
The record page displays delivery status. Existing borrowers without an email
address need an address added in Edit Record before updates can be delivered.

Released, unreturned books receive one reminder on the due date and one overdue
reminder after that date. Each reminder is tracked per loan and due date.
Returned books, unreleased requests, and obsolete reminders are skipped.
Dates use the application's configured timezone (`config/app.php`).

## Borrowing limits and renewals

Students may have 3 released, unreturned books at once, for up to 2 days per loan.
Other / Specify borrowers use the same limits and must provide a custom label.
Staff can edit that label; it appears in borrower details, Excel exports, and the
printed card title. Public repeat requests do not overwrite a saved custom label.
Faculty may have 10, for up to 1 calendar month per loan. Month-end dates clamp to
the final day of the following month. Overdue loans count toward the book limit;
pending, approved, returned, and rejected requests do not. Capacity is checked
when submitting a request, approving it, and releasing the book. Release checks
hold a borrower row lock so concurrent releases cannot exceed the limit.

Staff can use **Renew Book** on a released record up to twice. Each renewal adds
one loan period to the current due date, or to today if overdue. Repeated stale
submissions cannot consume another renewal. The existing reminder process skips
obsolete reminders and uses the new due date. Loan dates cannot be edited after
release; use the renewal action instead. Borrower classification cannot change
while the borrower has active loans. Fines are handled outside this system.

The renewal-count migration must be deployed before using Renew Book. Existing
records start at zero because the system previously had no renewal history.

The custom-borrower-type migration adds the Other option and its label column.
Released By remains blank at approval and must be entered manually at release;
the signed-in administrator is not filled in automatically.

## Deployment

Run the database migrations before using the updated forms:

```sh
php artisan migrate --force
```

The Laravel scheduler registers `borrowings:send-updates` hourly. On a server
already running `php artisan schedule:run` every minute, no additional worker is
needed. Alternatively, on this Windows/XAMPP host, run the following from an
elevated PowerShell to register the dedicated hourly task:

```powershell
powershell -ExecutionPolicy Bypass -File scripts/install-borrowing-reminders.ps1
```

The Windows task is named `MMACI Library Borrowing Email Updates`, runs as SYSTEM,
and uses the project PHP executable and working directory. The host and database
must be available for scheduled delivery. Use one scheduling method per host.

To run a delivery check immediately (sends real emails using configured SMTP):

```sh
php artisan borrowings:send-updates
```

Tests use fake mail and an isolated in-memory database:

```sh
php artisan test --filter=BorrowingWorkflowTest
```
