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
        Schema::create('invoices', function (Blueprint $table) {
        $table->id();
        $table->foreignId('section_id')->after('id')->constrained('sections')->cascadeOnDelete();
        $table->string('invoice_number');
        $table->date('invoice_date');
        $table->date('due_date');
        $table->string('product');
        $table->decimal('amount_collection',8,2)->nullable();;
        $table->decimal('amount_commission',8,2)->nullable();
        $table->decimal('discount', 8, 2);
        $table->decimal('rate_vat', 5, 2);
        $table->decimal('value_vat', 8, 2);
        $table->decimal('total', 10, 2);
        $table->string('status', 50);
        $table->unsignedTinyInteger('value_status');
        $table->text('note')->nullable();
        $table->date('payment_date')->nullable();
        $table->softDeletes();
        $table->timestamps();
        // $table->enum("status",['مدفوعة','غير مدفوعة','مدفوعة جزئيا'])->after('total')->default('غير مدفوعة');
        // $table->enum("value_status",[1,2,3])->after('status')->default(2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
