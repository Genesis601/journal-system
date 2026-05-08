<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('file_public_id')->nullable()->after('file_path');
        });

        Schema::table('journals', function (Blueprint $table) {
            $table->string('cover_public_id')->nullable()->after('cover_image');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('file_public_id');
        });

        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn('cover_public_id');
        });
    }
};