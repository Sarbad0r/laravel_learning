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

        if (!Schema::hasTable('delete_table')) {
            Schema::create('delete_table', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('user_id')->nullable();

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('set null');

                $table->string('string')->nullable();
                $table->integer('integer')->nullable();
                $table->boolean('boolean')->nullable();
                $table->double('double')->nullable();
                $table->dateTime('dateTime')->nullable();
                $table->date('date')->nullable();
                $table->time('time')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delete_table');
    }
};
