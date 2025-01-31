<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::create('waste_reports', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->string('photo');
      $table->string('location');
      $table->decimal('latitude', 10, 8)->nullable();
      $table->decimal('longitude', 11, 8)->nullable();
      $table->text('description')->nullable();
      $table->enum('status', ['pending', 'processed', 'completed'])->default('pending');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('waste_reports');
  }
};
