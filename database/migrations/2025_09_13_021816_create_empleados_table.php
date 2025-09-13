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
        Schema::create('empleados', function (Blueprint $table) {
            $table->unsignedInteger('empleado_id',$autoIncrement = true);
            $table->string('nombre',65);
            $table->string('dui',10);
            $table->string('email',65);
            $table->string('telefono',10);
            $table->string('direccion',125);
            $table->string('cargo',25);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
