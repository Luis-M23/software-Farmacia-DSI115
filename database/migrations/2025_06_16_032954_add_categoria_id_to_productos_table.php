<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('productos', function (Blueprint $table) {
        $table->foreignId('categoria_id')->nullable()->constrained()->onDelete('set null');
        $table->dropColumn('categoria'); // ⚠️ Solo si ya no usarás el campo anterior
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            //
        });
    }
};
