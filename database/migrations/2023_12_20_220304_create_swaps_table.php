<?php

use App\Models\Student;
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
        Schema::create('swaps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class);
            $table->date('date');
            $table->integer('pet_bottles')->nullable()->default(0);
            $table->integer('packaging_of_cleaning_materials')->nullable()->default(0);
            $table->integer('tetra_pak')->nullable()->default(0);
            $table->integer('aluminum_cans')->nullable()->default(0);
            $table->integer('green_coin')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('swaps');
    }
};
