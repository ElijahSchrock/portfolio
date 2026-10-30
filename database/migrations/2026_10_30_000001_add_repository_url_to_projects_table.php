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
            $table->string('repository_url', 2048)->nullable();
        });

        DB::table('projects')->where('seed_key', 'neo-runner')->update([
            'repository_url' => 'https://github.com/ElijahSchrock/Neo-Runner',
        ]);
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('repository_url');
        });
    }
};
