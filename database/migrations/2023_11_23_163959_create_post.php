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
        Schema::create('post', function (Blueprint $table) {
            $table->string('id');
            $table->string('user_id');
            $table->string('title');
            $table->bigInteger('monthly_rent_cost');
            $table->string('type');
            $table->double('area');
            $table->string('rent_status');
            $table->string('address');
            $table->string('description');
            $table->double('rating');
            $table->string('owner_name');
            $table->string('owner_phone_number');
            $table->jsonb('image');
            $table->string('cover_image');
            $table->jsonb('additional_infomation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
