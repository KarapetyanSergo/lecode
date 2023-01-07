<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrScanHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('qr_scan_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qr_id')
            ->constrained('qr_codes')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('scanned_by')
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('qr_scan_histories');
    }
}
