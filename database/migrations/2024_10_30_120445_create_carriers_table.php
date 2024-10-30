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
    Schema::create('carriers', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('name')->nullable();
        $table->string('dbo')->nullable();
        $table->string('mc')->nullable();
        $table->string('contact_name')->nullable();
        $table->string('phone')->nullable();
        $table->string('email')->nullable();
        $table->bigInteger('insurance')->nullable();
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carriers');
    }
};
