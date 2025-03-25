<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Hanafalah\LaravelSupport\Concerns\NowYouSeeMe;
use Hanafalah\ModuleEmployee\Enums\Employee\EmployeeStatus;
use Hanafalah\ModuleEmployee\Models\Employee\Employee;
use Hanafalah\ModulePeople\Models\People\People;
use Hanafalah\ModuleProfession\Models\Profession\Profession;

return new class extends Migration
{
    use NowYouSeeMe;

    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.Employee', Employee::class));
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $table_name = $this->__table->getTable();
        if (!$this->isTableExists()) {
            Schema::create($table_name, function (Blueprint $table) {
                $people     = app(config('database.models.People', People::class));
                $profession = app(config('database.models.Profession', Profession::class));

                $table->id();

                $table->foreignIdFor($people::class)
                    ->nullable(false)->index()
                    ->cascadeOnUpdate()->restrictOnDelete();

                $table->foreignIdFor($profession::class)
                    ->nullable(false)->index()
                    ->cascadeOnUpdate()->restrictOnDelete();

                $table->string('hired_at',50)->nullable();

                $table->string('profile',255)->nullable();

                $table->enum('status',EmployeeStatus::cases())
                    ->default(EmployeeStatus::DRAFT->value)
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
