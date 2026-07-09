<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->decimal('note', 4, 2)->nullable()->after('statut'); // Ex: 17.50 / 20
            $table->text('commentaire')->nullable()->after('note');
        });
    }

    public function down(): void
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->dropColumn(['note', 'commentaire']);
        });
    }
};
