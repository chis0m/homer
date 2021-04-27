<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->integer('propertable_id')->unsigned();
            $table->string('propertable_type');
            $table->string('title');
            $table->string('slug');
            $table->string('purpose')->nullable();
            $table->integer('bedroom');
            $table->integer('bathroom');
            $table->integer('kitchen');
            $table->integer('toilet');
            $table->integer('size')->nullable();
            $table->boolean('furnished')->nullable();
            $table->boolean('serviced')->nullable();
            $table->boolean('newly_built')->nullable();
            $table->decimal('price', 15);
            $table->longText('description')->nullable();
            $table->string('status')->default('active');
            $table->integer('notification_count')->default(0);
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
}
