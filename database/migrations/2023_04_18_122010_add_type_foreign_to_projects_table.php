<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            // Aggiungo la colonna type_id alla table projects che contiene una foreign key
            // * METODO LUNGO
            // $table->unsignedBigInteger('type_id')->nullable();
            // $table->foreign('type_id')->references('id')->on('types');

             // * METODO BREVE
            $table->foreignId('type_id')->after('id')->nullable()->constrained()->nullOnDelete();

            // ? Se non aggiungessi alla fine il metodo nullOnDelete() su phpMyAdmin nella relation view tra le due table, dovrei impostare ON DELETE = SET NULL così da poter eliminare una foreign key dalla tabella anche dopo averla associata all'elemento di un'altra tabella
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            // Elimino la foreign key
            $table->dropForeign('projects_type_id_foreign');
            // Elimino la colonna type_id
            $table->dropColumn('type_id');
        });
    }
};