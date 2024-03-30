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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreignId('pic_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('title', 255);
            $table->text('description');
            $table->datetime('due_at');
            $table->datetime('finished_at')->nullable();
            $table->string('estimation', 20);
            $table->string('priority', 20);
            $table->string('effort', 20);
            $table->string('status', 20);
            $table->string('file', 2048)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
