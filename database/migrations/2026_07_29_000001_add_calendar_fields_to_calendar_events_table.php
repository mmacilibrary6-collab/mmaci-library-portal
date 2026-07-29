<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            if (! Schema::hasColumn('calendar_events', 'title')) {
                $table->string('title')->nullable()->after('id');
            }

            if (! Schema::hasColumn('calendar_events', 'description')) {
                $table->text('description')->nullable()->after('title');
            }

            if (! Schema::hasColumn('calendar_events', 'event_date')) {
                $table->date('event_date')->nullable()->after('description');
            }

            if (! Schema::hasColumn('calendar_events', 'start_time')) {
                $table->time('start_time')->nullable()->after('event_date');
            }

            if (! Schema::hasColumn('calendar_events', 'end_time')) {
                $table->time('end_time')->nullable()->after('start_time');
            }

            if (! Schema::hasColumn('calendar_events', 'location')) {
                $table->string('location')->nullable()->after('end_time');
            }

            if (! Schema::hasColumn('calendar_events', 'image')) {
                $table->string('image')->nullable()->after('location');
            }

            if (! Schema::hasColumn('calendar_events', 'status')) {
                $table->string('status')->default('published')->after('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            $columns = [
                'title',
                'description',
                'event_date',
                'start_time',
                'end_time',
                'location',
                'image',
                'status',
            ];

            $existing = array_filter(
                $columns,
                fn (string $column): bool => Schema::hasColumn('calendar_events', $column)
            );

            if ($existing !== []) {
                $table->dropColumn($existing);
            }
        });
    }
};
