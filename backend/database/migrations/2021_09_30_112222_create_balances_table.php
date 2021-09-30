<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalancesTable extends Migration
{
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignId('wallet_id')->constrained('wallets');
            $table->string('income_type')->default('other');
            $table->decimal('amount');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('balances');
    }
}