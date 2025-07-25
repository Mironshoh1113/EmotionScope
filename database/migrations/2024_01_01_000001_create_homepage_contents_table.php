<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('homepage_contents', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('uz');
            $table->text('ru');
            $table->text('en');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('homepage_contents');
    }
}; 