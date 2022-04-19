<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		// users
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('url', 30);
            $table->string('use_type', 20);
			$table->string('user_id', 10);
			$table->string('page_id', 20)->nullable();
			$table->boolean('checked')->default(false)->nullable();
			$table->boolean('has_error')->default(false)->nullable();
			$table->boolean('is_secured')->default(false)->nullable();
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
        Schema::dropIfExists('domains');
    }
}