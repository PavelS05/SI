<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCarrierFieldsToLoadsTable extends Migration
{
    public function up()
    {
        Schema::table('loads', function (Blueprint $table) {
            $table->string('equipment_type')->nullable()->after('carrier_rate');
            $table->string('driver_name')->nullable()->after('equipment_type');
            $table->string('driver_contact')->nullable()->after('driver_name');
        });
    }

    public function down()
    {
        Schema::table('loads', function (Blueprint $table) {
            $table->dropColumn(['equipment_type', 'driver_name', 'driver_contact']);
        });
    }
}