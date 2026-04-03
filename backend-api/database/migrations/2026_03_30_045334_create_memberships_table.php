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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->foreignId('membership_plan_id')->constrained('membership_plans')->restrictOnDelete();
            $table->foreignId('subscribed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('renewed_from_membership_id')->nullable()->constrained('memberships')->nullOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('active');
            $table->boolean('auto_renew')->default(false);
            $table->timestamp('last_payment_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['member_id', 'status']);
            $table->index(['start_date', 'end_date']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
