<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Zahzah\LaravelSupport\Concerns\NowYouSeeMe;
use Zahzah\ModuleEmployee\Enums\Employee\EmployeeStatus;
use Zahzah\ModuleEmployee\Models\Employee\Employee;
use Zahzah\ModulePeople\Models\People\People;
use Zahzah\ModuleProfession\Models\Profession\Profession;

return new class extends Migration
{
    use NowYouSeeMe;

    private $__table;

    public function __construct(){
        $this->__table = app(config('database.models.Employee', Employee::class));
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $table_name = $this->__table->getTable();
        if (!$this->isTableExists()){
            Schema::create($table_name, function (Blueprint $table) {
                $people     = app(config('database.models.People', People::class));
                $profession = app(config('database.models.Profession', Profession::class));

                $table->id();
                $table->foreignIdFor($people::class)
                      ->nullable(false)->index()
                      ->cascadeOnUpdate()->restrictOnDelete();
                $table->unsignedTinyInteger('status')->comment('see '.EmployeeStatus::class)
                      ->default(EmployeeStatus::DRAFT->value)
                      ->nullable(false);
                $table->foreignIdFor($profession::class)
                      ->nullable(false)->index()
                      ->cascadeOnUpdate()->restrictOnDelete();
                $table->unsignedBigInteger('sallary')->default(0)
                      ->nullable(false);
                $table->json('props')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
