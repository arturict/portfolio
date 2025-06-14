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
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        });

        // Update existing projects to assign them to the first user
        // This is safe for production setup since we're removing example projects anyway
        $firstUser = \App\Models\User::first();
        if ($firstUser) {
            \App\Models\Project::whereNull('user_id')->update(['user_id' => $firstUser->id]);
        }

        // Make user_id required after assigning existing projects
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
