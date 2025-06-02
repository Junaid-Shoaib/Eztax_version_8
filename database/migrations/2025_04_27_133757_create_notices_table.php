<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('tax_authority');
            $table->string('tax_office');
            $table->string('notice_heading');
            $table->string('commissioner')->nullable();
            $table->string('tax_year');
            $table->boolean('status')->default(0);
            $table->date('receiving_date');
            $table->date('due_date')->nullable();
            $table->date('hearing_date')->nullable();
            $table->string('notice_name')->nullable();
            $table->string('notice_path')->nullable();
            $table->string('reply_name')->nullable();
            $table->string('reply_path')->nullable();
            $table->string('order_name')->nullable();
            $table->string('order_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notices');
    }
}
