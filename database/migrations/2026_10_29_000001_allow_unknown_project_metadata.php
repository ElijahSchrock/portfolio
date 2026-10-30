<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('other_tech')->nullable()->change();
            $table->string('year_created')->nullable()->change();
        });
    }

    public function down(): void
    {
        foreach (['other_tech', 'year_created'] as $column) {
            DB::table('projects')->whereNull($column)->update([$column => '']);
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->string('other_tech')->nullable(false)->change();
            $table->string('year_created')->nullable(false)->change();
        });
    }
};
