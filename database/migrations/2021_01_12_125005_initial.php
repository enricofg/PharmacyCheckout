<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Initial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('tipo_user', ['C', 'F'])->default('C');   // Cliente; Farmaceutico
        });

        Schema::create('medicamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome')->unique();
            $table->boolean('generico')->default(0);
            $table->decimal('preco', 9, 2);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('receitas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('users');
            $table->date('data');
            $table->decimal('total', 9, 2);
            $table->enum('estado_receita', ['A', 'F', 'R'])->default('A');
            // Aberta, Fechada, Recusada
            $table->unsignedBigInteger('farmaceutico_id')->unsigned()->nullable();
            $table->foreign('farmaceutico_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('medicamento_receita', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('receita_id')->unsigned();
            $table->unsignedBigInteger('medicamento_id')->unsigned();
            $table->foreign('receita_id')->references('id')->on('receitas');
            $table->foreign('medicamento_id')->references('id')->on('medicamentos');
            $table->integer('qtd')->default(1);
            $table->decimal('preco_un', 9, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
