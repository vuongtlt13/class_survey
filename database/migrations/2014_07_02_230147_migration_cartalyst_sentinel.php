<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MigrationCartalystSentinel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('code');
            $table->boolean('completed')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        Schema::create('persistences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('code');
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->unique('code');
        });

        Schema::create('reminders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('code');
            $table->boolean('completed')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('name');
            $table->text('permissions')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->unique('slug');
        });

        Schema::create('role_users', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->primary(['user_id', 'role_id']);
        });

        Schema::create('throttle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('type');
            $table->string('ip')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index('user_id');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('password');
            $table->string('email')->nullable();
            $table->text('permissions')->nullable();
            $table->string('name')->nullable();
            $table->string('id_number')->nullable();
            $table->string('address', 500)->nullable();
            $table->timestamps();
            $table->integer('type');
            $table->boolean('is_active')->default(1);
            $table->boolean('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('last_login')->nullable();

            $table->engine = 'InnoDB';

            $table->unique('email');
            $table->unique('username');
            $table->unique('phone');
        });

        Schema::create('lecturers', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('degree')->nullable();
            $table->string('code')->nullable();

            $table->engine = 'InnoDB';

            $table->foreign('id')->references('id')->on('users');
        });

        Schema::create('students', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('khoahoc')->nullable();
            $table->string('major', 400)->nullable();

            $table->engine = 'InnoDB';

            $table->foreign('id')->references('id')->on('users');
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->string('code');
            $table->string('name');
            $table->integer('sotinchi');

            $table->engine = 'InnoDB';

            $table->primary('code');
        });

        Schema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('is_default');
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        Schema::create('titles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content');

            $table->engine = 'InnoDB';
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('title_id');
            $table->string('content');

            $table->engine = 'InnoDB';
            $table->foreign('title_id')->references('id')->on('titles');
        });

        Schema::create('template_question', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('template_id');

            $table->engine = 'InnoDB';
            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('template_id')->references('id')->on('templates');
            $table->unique(array('question_id', 'template_id'));
        });

        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('class_code');
            $table->string('subject_code');
            $table->unsignedInteger('lecturer_id');
            $table->string('school_year');
            $table->boolean('term');
            $table->unsignedInteger('template_id')->nullable();
            $table->timestamps();
            $table->string('note', 1000)->nullable();
            $table->boolean('is_done')->default(0);

            $table->engine = 'InnoDB';
            $table->foreign('subject_code')->references('code')->on('subjects');
            $table->foreign('lecturer_id')->references('id')->on('lecturers');
            $table->foreign('template_id')->references('id')->on('templates');
            $table->unique(array('school_year', 'term', 'class_code'));
        });

        Schema::create('class_student', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('class_id');

            $table->engine = 'InnoDB';
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('class_id')->references('id')->on('classes');
        });

        Schema::create('class_student_question', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('class_student_id');
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('score')->default(0);

            $table->engine = 'InnoDB';
            $table->foreign('class_student_id')->references('id')->on('class_student');
            $table->foreign('question_id')->references('id')->on('questions');
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start_date_1')->nullable();
            $table->date('start_date_2')->nullable();
            $table->date('end_date_1')->nullable();
            $table->date('end_date_2')->nullable();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activations');
        Schema::dropIfExists('persistences');
        Schema::dropIfExists('reminders');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_users');
        Schema::dropIfExists('throttle');


        Schema::dropIfExists('surveys');
        Schema::dropIfExists('surveytemplate_question');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('subject_class_student');
        Schema::dropIfExists('subject_classes');
        Schema::dropIfExists('students');
        Schema::dropIfExists('lecturers');

        Schema::dropIfExists('users');
        Schema::dropIfExists('titles');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('survey_templates');
    }
}
