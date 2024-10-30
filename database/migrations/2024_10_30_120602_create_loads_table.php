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
    Schema::create('loads', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('load_number')->unique(); // Format A#######
        $table->string('sales')->nullable();
        $table->string('dispatcher')->nullable();
        $table->string('costumer')->nullable();
        $table->bigInteger('costumer_rate')->nullable();
        $table->string('carrier')->nullable();
        $table->bigInteger('carrier_rate')->nullable();
        $table->string('service')->nullable();
        $table->string('shipper_name')->nullable();
        $table->string('shipper_address')->nullable();
        $table->date('pu_date')->nullable();
        $table->string('po')->nullable();
        $table->string('pu_appt')->nullable();
        $table->string('receiver_name')->nullable();
        $table->string('receiver_address')->nullable();
        $table->date('del_date')->nullable();
        $table->string('del')->nullable();
        $table->string('del_appt')->nullable();
        $table->string('status')->default('new');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loads');
    }
};
