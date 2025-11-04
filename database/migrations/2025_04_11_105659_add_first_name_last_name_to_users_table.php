<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('id')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
        });

        // Migrate existing data
        DB::table('users')->whereNotNull('name')->cursor()->each(function ($user) {
            $nameParts = explode(' ', $user->name, 2);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';
            
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'first_name' => $firstName,
                    'last_name' => $lastName
                ]);
        });

        // Optionally, you can remove the name column after migration
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn('name');
        // });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore the name column if it was removed
            // $table->string('name')->after('id')->nullable();
            
            // Migrate data back to name column
            DB::table('users')->whereNotNull('first_name')->cursor()->each(function ($user) {
                $fullName = trim($user->first_name . ' ' . $user->last_name);
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['name' => $fullName]);
            });
            
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
        });
    }
};