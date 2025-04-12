<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Account;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fixed_positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('value', 10, 2);
            $table->enum('type', ['income', 'expense']);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamp('last_applied')->nullable();
            $table->enum('period', ['monthly', 'every 2 months', 'quarterly', 'every 6 months', 'annually']);
            $table->boolean('active')->default(true);
            $table->foreignIdFor(Category::class)->constrained();
            $table->foreignIdFor(Account::class)->constrained();
            $table->timestamps();
        });
    }

    /**^
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_positions');
    }
};
