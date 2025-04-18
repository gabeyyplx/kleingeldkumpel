<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Account;
use App\FixedPositionPeriod;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('value', 10, 2);
            $table->enum('type', FixedPositionPeriod::values());
            $table->date('date');
            $table->boolean('through_fixed_position')->default(false);
            $table->foreignIdFor(Category::class)->constrained();
            $table->foreignIdFor(Account::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
