<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->syncTable(
            'calendar_events',
            function (): void {
                Schema::create('calendar_events', function (Blueprint $table) {
                    $table->id();
                    $table->string('title');
                    $table->text('description')->nullable();
                    $table->date('event_date');
                    $table->date('event_end_date')->nullable();
                    $table->time('start_time')->nullable();
                    $table->time('end_time')->nullable();
                    $table->string('location')->nullable();
                    $table->longText('image')->nullable();
                    $table->enum('status', ['draft', 'published', 'cancelled'])->default('published');
                    $table->timestamps();
                });
            },
            [
                'title' => fn (Blueprint $table) => $table->string('title')->nullable(),
                'description' => fn (Blueprint $table) => $table->text('description')->nullable(),
                'event_date' => fn (Blueprint $table) => $table->date('event_date')->nullable(),
                'event_end_date' => fn (Blueprint $table) => $table->date('event_end_date')->nullable(),
                'start_time' => fn (Blueprint $table) => $table->time('start_time')->nullable(),
                'end_time' => fn (Blueprint $table) => $table->time('end_time')->nullable(),
                'location' => fn (Blueprint $table) => $table->string('location')->nullable(),
                'image' => fn (Blueprint $table) => $table->longText('image')->nullable(),
                'status' => fn (Blueprint $table) => $table->string('status')->nullable(),
            ]
        );

        $this->syncTable(
            'new_arrivals',
            function (): void {
                Schema::create('new_arrivals', function (Blueprint $table) {
                    $table->id();
                    $table->string('title');
                    $table->string('author')->nullable();
                    $table->string('isbn', 50)->nullable();
                    $table->string('category')->nullable();
                    $table->enum('resource_type', ['printed', 'ebook'])->default('printed');
                    $table->year('publication_year')->nullable();
                    $table->string('publisher')->nullable();
                    $table->text('description')->nullable();
                    $table->string('cover_image')->nullable();
                    $table->string('file_url', 500)->nullable();
                    $table->string('access_url', 500)->nullable();
                    $table->enum('availability_status', ['available', 'borrowed', 'reference_only', 'unavailable'])->default('available');
                    $table->date('arrival_date')->nullable();
                    $table->boolean('is_featured')->default(false);
                    $table->timestamps();
                    $table->text('image')->nullable();
                });
            },
            [
                'title' => fn (Blueprint $table) => $table->string('title')->nullable(),
                'author' => fn (Blueprint $table) => $table->string('author')->nullable(),
                'isbn' => fn (Blueprint $table) => $table->string('isbn', 50)->nullable(),
                'category' => fn (Blueprint $table) => $table->string('category')->nullable(),
                'resource_type' => fn (Blueprint $table) => $table->string('resource_type')->nullable(),
                'publication_year' => fn (Blueprint $table) => $table->year('publication_year')->nullable(),
                'publisher' => fn (Blueprint $table) => $table->string('publisher')->nullable(),
                'description' => fn (Blueprint $table) => $table->text('description')->nullable(),
                'cover_image' => fn (Blueprint $table) => $table->string('cover_image')->nullable(),
                'file_url' => fn (Blueprint $table) => $table->string('file_url', 500)->nullable(),
                'access_url' => fn (Blueprint $table) => $table->string('access_url', 500)->nullable(),
                'availability_status' => fn (Blueprint $table) => $table->string('availability_status')->nullable(),
                'arrival_date' => fn (Blueprint $table) => $table->date('arrival_date')->nullable(),
                'is_featured' => fn (Blueprint $table) => $table->boolean('is_featured')->default(false),
                'image' => fn (Blueprint $table) => $table->text('image')->nullable(),
            ]
        );

        $this->syncTable(
            'ebook_programs',
            function (): void {
                Schema::create('ebook_programs', function (Blueprint $table) {
                    $table->id();
                    $table->string('title');
                    $table->text('description')->nullable();
                    $table->timestamps();
                    $table->unsignedInteger('sort_order')->default(0);
                    $table->boolean('status')->default(true);
                    $table->boolean('is_active')->default(true);
                    $table->string('icon')->nullable();
                    $table->text('image')->nullable();
                });
            },
            [
                'title' => fn (Blueprint $table) => $table->string('title')->nullable(),
                'description' => fn (Blueprint $table) => $table->text('description')->nullable(),
                'sort_order' => fn (Blueprint $table) => $table->unsignedInteger('sort_order')->default(0),
                'status' => fn (Blueprint $table) => $table->boolean('status')->default(true),
                'is_active' => fn (Blueprint $table) => $table->boolean('is_active')->default(true),
                'icon' => fn (Blueprint $table) => $table->string('icon')->nullable(),
                'image' => fn (Blueprint $table) => $table->text('image')->nullable(),
            ]
        );

        $this->syncTable(
            'ebook_folders',
            function (): void {
                Schema::create('ebook_folders', function (Blueprint $table) {
                    $table->id();
                    $table->timestamps();
                    $table->foreignId('ebook_program_id')->nullable()->constrained('ebook_programs')->nullOnDelete();
                    $table->string('title')->default('');
                    $table->text('description')->nullable();
                    $table->text('drive_link')->nullable();
                    $table->unsignedInteger('sort_order')->default(0);
                    $table->boolean('status')->default(true);
                });
            },
            [
                'ebook_program_id' => fn (Blueprint $table) => $table->foreignId('ebook_program_id')->nullable(),
                'title' => fn (Blueprint $table) => $table->string('title')->default(''),
                'description' => fn (Blueprint $table) => $table->text('description')->nullable(),
                'drive_link' => fn (Blueprint $table) => $table->text('drive_link')->nullable(),
                'sort_order' => fn (Blueprint $table) => $table->unsignedInteger('sort_order')->default(0),
                'status' => fn (Blueprint $table) => $table->boolean('status')->default(true),
            ]
        );

        $this->syncTable(
            'galleries',
            function (): void {
                Schema::create('galleries', function (Blueprint $table) {
                    $table->id();
                    $table->string('title');
                    $table->text('description')->nullable();
                    $table->longText('image')->nullable();
                    $table->unsignedInteger('sort_order')->default(0);
                    $table->boolean('is_active')->default(true);
                    $table->date('event_date')->nullable();
                    $table->string('location')->nullable();
                    $table->enum('status', ['draft', 'published'])->default('published');
                    $table->boolean('is_featured')->default(false);
                    $table->timestamps();
                });
            },
            [
                'title' => fn (Blueprint $table) => $table->string('title')->nullable(),
                'description' => fn (Blueprint $table) => $table->text('description')->nullable(),
                'image' => fn (Blueprint $table) => $table->longText('image')->nullable(),
                'sort_order' => fn (Blueprint $table) => $table->unsignedInteger('sort_order')->default(0),
                'is_active' => fn (Blueprint $table) => $table->boolean('is_active')->default(true),
                'event_date' => fn (Blueprint $table) => $table->date('event_date')->nullable(),
                'location' => fn (Blueprint $table) => $table->string('location')->nullable(),
                'status' => fn (Blueprint $table) => $table->string('status')->nullable(),
                'is_featured' => fn (Blueprint $table) => $table->boolean('is_featured')->default(false),
            ]
        );

        $this->syncTable(
            'ask_librarians',
            function (): void {
                Schema::create('ask_librarians', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('email');
                    $table->string('contact_number', 30)->nullable();
                    $table->string('subject');
                    $table->text('message');
                    $table->text('reply')->nullable();
                    $table->timestamp('replied_at')->nullable();
                    $table->enum('status', ['pending', 'read', 'replied', 'closed'])->default('pending');
                    $table->timestamps();
                });
            },
            [
                'name' => fn (Blueprint $table) => $table->string('name')->nullable(),
                'email' => fn (Blueprint $table) => $table->string('email')->nullable(),
                'contact_number' => fn (Blueprint $table) => $table->string('contact_number', 30)->nullable(),
                'subject' => fn (Blueprint $table) => $table->string('subject')->nullable(),
                'message' => fn (Blueprint $table) => $table->text('message')->nullable(),
                'reply' => fn (Blueprint $table) => $table->text('reply')->nullable(),
                'replied_at' => fn (Blueprint $table) => $table->timestamp('replied_at')->nullable(),
                'status' => fn (Blueprint $table) => $table->string('status')->nullable(),
            ]
        );

        $this->syncTable(
            'visiting_users',
            function (): void {
                Schema::create('visiting_users', function (Blueprint $table) {
                    $table->id();
                    $table->string('full_name');
                    $table->string('email')->nullable();
                    $table->string('contact_number', 30);
                    $table->string('institution')->nullable();
                    $table->enum('visitor_type', ['student', 'teacher', 'researcher', 'alumni', 'government_employee', 'private_employee', 'other'])->default('other');
                    $table->text('purpose');
                    $table->date('visit_date');
                    $table->time('visit_time')->nullable();
                    $table->string('valid_id_type', 100)->nullable();
                    $table->string('valid_id_number', 100)->nullable();
                    $table->enum('status', ['pending', 'approved', 'declined', 'completed', 'cancelled'])->default('pending');
                    $table->text('admin_notes')->nullable();
                    $table->timestamps();
                });
            },
            [
                'full_name' => fn (Blueprint $table) => $table->string('full_name')->nullable(),
                'email' => fn (Blueprint $table) => $table->string('email')->nullable(),
                'contact_number' => fn (Blueprint $table) => $table->string('contact_number', 30)->nullable(),
                'institution' => fn (Blueprint $table) => $table->string('institution')->nullable(),
                'visitor_type' => fn (Blueprint $table) => $table->string('visitor_type')->nullable(),
                'purpose' => fn (Blueprint $table) => $table->text('purpose')->nullable(),
                'visit_date' => fn (Blueprint $table) => $table->date('visit_date')->nullable(),
                'visit_time' => fn (Blueprint $table) => $table->time('visit_time')->nullable(),
                'valid_id_type' => fn (Blueprint $table) => $table->string('valid_id_type', 100)->nullable(),
                'valid_id_number' => fn (Blueprint $table) => $table->string('valid_id_number', 100)->nullable(),
                'status' => fn (Blueprint $table) => $table->string('status')->nullable(),
                'admin_notes' => fn (Blueprint $table) => $table->text('admin_notes')->nullable(),
            ]
        );
    }

    public function down(): void
    {
    }

    /**
     * Sync a table schema across fresh and existing databases.
     *
     * @param  array<string, \Closure(Blueprint): void>  $columns
     */
    private function syncTable(string $tableName, \Closure $createTable, array $columns): void
    {
        if (! Schema::hasTable($tableName)) {
            $createTable();

            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName, $columns): void {
            foreach ($columns as $columnName => $columnDefinition) {
                if (! Schema::hasColumn($tableName, $columnName)) {
                    $columnDefinition($table);
                }
            }
        });
    }
};
