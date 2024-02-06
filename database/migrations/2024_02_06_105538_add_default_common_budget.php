<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $currentDate = date("Y-m-d");
        $datePlusOneMonth = date('Y-m-d', strtotime('+1 month', strtotime($currentDate)));
        DB::table('budgets')->insert([
            'user_id' => 1,
            'name' => 'Rent',
            'start_date' => $currentDate,
            'end_date' => $datePlusOneMonth,
            'limit' => 2000,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('id', 1)->delete();
    }
};
