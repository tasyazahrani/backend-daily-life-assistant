<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('quotes', function (Blueprint $table) {
        if (!Schema::hasColumn('quotes', 'quote_date')) {
            $table->date('quote_date')->nullable()->after('author');
        }

        // Jangan tambahkan is_favorite jika sudah ada
        if (!Schema::hasColumn('quotes', 'is_favorite')) {
            $table->boolean('is_favorite')->default(false)->after('quote_date');
        }
    });
}



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotes', function (Blueprint $table) {
            //
        });
    }
};
