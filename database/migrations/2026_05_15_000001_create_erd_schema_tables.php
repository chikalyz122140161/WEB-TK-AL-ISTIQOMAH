<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // Drop tabel lama yang konflik (dari skema sebelumnya)
        $this->dropOldTables();

        // Buat tabel baru sesuai ERD
        $this->createUser();
        $this->createClass();
        $this->createAcademicTerm();
        $this->createClassTerm();
        $this->createStudent();
        $this->createParent();
        $this->createStudentFile();
        $this->createStudentEnrollment();
        $this->createPresence();
        $this->createSubject();
        $this->createClassTermSubject();
        $this->createExtracurricular();
        $this->createExtracurricularAssessment();
        $this->createClassTermExtracurricular();
        $this->createCounseling();
        $this->createCounselingAssessment();
        $this->createClassTermCounseling();
        $this->createClassSchedule();
        $this->createActivitySchedule();
        $this->createReport();
        $this->createReportSubject();
        $this->createReportSubjectImage();
        $this->createReportExtracurricular();
        $this->createReportExtracurricularScore();
        $this->createReportCounseling();
        $this->createReportCounselingScore();
        $this->createPrivateCounselingSchedule();

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach ([
            'private_counseling_schedule',
            'report_counseling_score', 'report_counseling',
            'report_extracurricular_score', 'report_extracurricular',
            'report_subject_image', 'report_subject', 'report',
            'activity_schedule', 'class_schedule',
            'class_term_counseling', 'counseling_assessment', 'counseling',
            'class_term_extracurricular', 'extracurricular_assessment', 'extracurricular',
            'class_term_subject', 'subject',
            'presence', 'student_enrollment',
            'student_file', 'parent', 'student',
            'class_term', 'academic_term', 'class', 'user',
        ] as $table) {
            Schema::dropIfExists($table);
        }

        Schema::enableForeignKeyConstraints();
    }

    /* ───────────────── Drop old tables ───────────────── */
    private function dropOldTables(): void
    {
        // Hanya drop tabel dari skema lama yang konflik / tidak terpakai lagi.
        // JANGAN drop:
        // - sessions/cache/jobs (dipakai framework)
        // - registrations & dokumen_pendaftaran (masih dipakai flow pendaftaran publik)
        foreach ([
            'semester_reports',
            'notifications', 'chats', 'schedules', 'reports',
            'attendances', 'students', 'users',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }

    /* ───────────────── Core entities ───────────────── */
    private function createUser(): void
    {
        Schema::create('user', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('name');
            $t->string('email')->unique();
            $t->timestamp('email_verified_at')->nullable();
            $t->string('password');
            $t->string('phone')->nullable();
            $t->enum('role', ['admin', 'guru', 'orangtua']);
            $t->enum('status', ['pending', 'aktif', 'nonaktif'])->default('aktif');
            $t->boolean('isGraduate')->default(false);
            $t->string('remember_token', 100)->nullable();
            $t->timestamps();
            $t->softDeletes();
        });
    }

    private function createClass(): void
    {
        Schema::create('class', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('name');
            $t->integer('maximum')->default(20);
            $t->timestamps();
            $t->softDeletes();
        });
    }

    private function createAcademicTerm(): void
    {
        Schema::create('academic_term', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('academic_year'); // e.g. '2025/2026'
            $t->enum('semester', ['ganjil', 'genap']);
            $t->timestamps();
            $t->softDeletes();
        });
    }

    private function createClassTerm(): void
    {
        Schema::create('class_term', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('class_id');
            $t->uuid('academic_term_id');
            $t->boolean('isPass')->default(false);
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('class_id')->references('id')->on('class')->cascadeOnDelete();
            $t->foreign('academic_term_id')->references('id')->on('academic_term')->cascadeOnDelete();
        });
    }

    private function createStudent(): void
    {
        Schema::create('student', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('user_id')->nullable();
            $t->string('name');
            $t->enum('gender', ['L', 'P']);
            $t->string('nis')->nullable();
            $t->string('nisn')->nullable();
            $t->string('pob')->nullable();
            $t->date('dob')->nullable();
            $t->string('nik')->nullable();
            $t->longText('address')->nullable();
            $t->string('phone')->nullable();
            $t->enum('religion', ['islam', 'kristen', 'katolik', 'hindu', 'budha', 'konghucu'])->default('islam');
            $t->integer('birth_order')->nullable();
            $t->integer('siblings_count')->nullable();
            $t->string('ethnicity')->nullable();
            $t->string('illness_history')->nullable();
            $t->decimal('weight', 5, 2)->nullable();
            $t->decimal('height', 5, 2)->nullable();
            $t->string('nickname')->nullable();

            // ── Legacy compat fields (dipakai controller lama, akan dihapus setelah migrasi penuh) ──
            $t->string('kelas')->nullable();          // legacy: kelas siswa (sebelum class_term ada)
            $t->uuid('parent_id')->nullable();        // legacy: FK ke user (orangtua)
            $t->string('nama_ayah')->nullable();
            $t->string('pekerjaan_ayah')->nullable();
            $t->string('nama_ibu')->nullable();
            $t->string('pekerjaan_ibu')->nullable();
            $t->string('tempat_lahir')->nullable();   // alias pob
            $t->date('birth_date')->nullable();       // alias dob
            $t->string('telepon')->nullable();        // alias phone
            $t->string('nomor_induk')->nullable();    // alias nis

            $t->timestamps();
            $t->softDeletes();

            $t->foreign('user_id')->references('id')->on('user')->nullOnDelete();
        });
    }

    private function createParent(): void
    {
        Schema::create('parent', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('student_id');
            $t->enum('category', ['ayah', 'ibu', 'wali']);
            $t->string('name');
            $t->string('work')->nullable();
            $t->string('education')->nullable();
            $t->string('pob')->nullable();
            $t->date('dob')->nullable();
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('student_id')->references('id')->on('student')->cascadeOnDelete();
        });
    }

    private function createStudentFile(): void
    {
        Schema::create('student_file', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('student_id');
            $t->enum('type', ['kk', 'akta', 'foto', 'ktp_ortu', 'lainnya']);
            $t->string('path')->nullable();
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('student_id')->references('id')->on('student')->cascadeOnDelete();
        });
    }

    private function createStudentEnrollment(): void
    {
        Schema::create('student_enrollment', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('student_id');
            $t->uuid('class_term_id');
            $t->enum('status', ['aktif', 'naik', 'tinggal', 'lulus', 'pindah'])->default('aktif');
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('student_id')->references('id')->on('student')->cascadeOnDelete();
            $t->foreign('class_term_id')->references('id')->on('class_term')->cascadeOnDelete();
        });
    }

    private function createPresence(): void
    {
        Schema::create('presence', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('student_class_id'); // student_enrollment.id
            $t->date('date');
            $t->enum('attendance', ['hadir', 'izin', 'sakit', 'alpa']);
            $t->text('description')->nullable();
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('student_class_id')->references('id')->on('student_enrollment')->cascadeOnDelete();
        });
    }

    /* ───────────────── Subjects / Ekskul / Konseling ───────────────── */
    private function createSubject(): void
    {
        Schema::create('subject', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('name');
            $t->timestamps();
            $t->softDeletes();
        });
    }

    private function createClassTermSubject(): void
    {
        Schema::create('class_term_subject', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('class_term_id');
            $t->uuid('subject_id');
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('class_term_id')->references('id')->on('class_term')->cascadeOnDelete();
            $t->foreign('subject_id')->references('id')->on('subject')->cascadeOnDelete();
        });
    }

    private function createExtracurricular(): void
    {
        Schema::create('extracurricular', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('name');
            $t->timestamps();
            $t->softDeletes();
        });
    }

    private function createExtracurricularAssessment(): void
    {
        Schema::create('extracurricular_assessment', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('extracurricular_id');
            $t->string('name');
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('extracurricular_id')->references('id')->on('extracurricular')->cascadeOnDelete();
        });
    }

    private function createClassTermExtracurricular(): void
    {
        Schema::create('class_term_extracurricular', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('class_term_id');
            $t->uuid('extracurricular_id');
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('class_term_id')->references('id')->on('class_term')->cascadeOnDelete();
            $t->foreign('extracurricular_id')->references('id')->on('extracurricular')->cascadeOnDelete();
        });
    }

    private function createCounseling(): void
    {
        Schema::create('counseling', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('name');
            $t->timestamps();
            $t->softDeletes();
        });
    }

    private function createCounselingAssessment(): void
    {
        Schema::create('counseling_assessment', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('counseling_id');
            $t->string('name');
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('counseling_id')->references('id')->on('counseling')->cascadeOnDelete();
        });
    }

    private function createClassTermCounseling(): void
    {
        Schema::create('class_term_counseling', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('class_term_id');
            $t->uuid('counseling_id');
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('class_term_id')->references('id')->on('class_term')->cascadeOnDelete();
            $t->foreign('counseling_id')->references('id')->on('counseling')->cascadeOnDelete();
        });
    }

    /* ───────────────── Schedules ───────────────── */
    private function createClassSchedule(): void
    {
        Schema::create('class_schedule', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('class_term_id');
            $t->string('name');
            $t->integer('day'); // 1=Senin, ... 7=Minggu
            $t->string('hour');
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('class_term_id')->references('id')->on('class_term')->cascadeOnDelete();
        });
    }

    private function createActivitySchedule(): void
    {
        Schema::create('activity_schedule', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('class_term_id');
            $t->string('name');
            $t->date('date');
            $t->string('hour');
            $t->string('location')->nullable();
            $t->string('description')->nullable();
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('class_term_id')->references('id')->on('class_term')->cascadeOnDelete();
        });
    }

    /* ───────────────── Reports ───────────────── */
    private function createReport(): void
    {
        Schema::create('report', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('student_enrollment_id');
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('student_enrollment_id')->references('id')->on('student_enrollment')->cascadeOnDelete();
        });
    }

    private function createReportSubject(): void
    {
        Schema::create('report_subject', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('report_id');
            $t->uuid('subject_id');
            $t->string('description', 1000)->nullable();
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('report_id')->references('id')->on('report')->cascadeOnDelete();
            $t->foreign('subject_id')->references('id')->on('subject')->cascadeOnDelete();
        });
    }

    private function createReportSubjectImage(): void
    {
        Schema::create('report_subject_image', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('report_subject_id');
            $t->string('description')->nullable(); // path/url gambar
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('report_subject_id')->references('id')->on('report_subject')->cascadeOnDelete();
        });
    }

    private function createReportExtracurricular(): void
    {
        Schema::create('report_extracurricular', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('report_id');
            $t->uuid('extracurricular_id');
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('report_id')->references('id')->on('report')->cascadeOnDelete();
            $t->foreign('extracurricular_id')->references('id')->on('extracurricular')->cascadeOnDelete();
        });
    }

    private function createReportExtracurricularScore(): void
    {
        Schema::create('report_extracurricular_score', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('report_extracurricular_id');
            $t->uuid('extracurricular_assessment_id');
            $t->enum('level', ['BB', 'MB', 'BSH', 'BSB']);
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('report_extracurricular_id', 'fk_rext_score_rext')
                ->references('id')->on('report_extracurricular')->cascadeOnDelete();
            $t->foreign('extracurricular_assessment_id', 'fk_rext_score_assess')
                ->references('id')->on('extracurricular_assessment')->cascadeOnDelete();
        });
    }

    private function createReportCounseling(): void
    {
        Schema::create('report_counseling', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('report_id');
            $t->uuid('counseling_id');
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('report_id')->references('id')->on('report')->cascadeOnDelete();
            $t->foreign('counseling_id')->references('id')->on('counseling')->cascadeOnDelete();
        });
    }

    private function createReportCounselingScore(): void
    {
        Schema::create('report_counseling_score', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('report_counseling_id');
            $t->uuid('counseling_assessment_id');
            $t->enum('level', ['BB', 'MB', 'BSH', 'BSB']);
            $t->integer('week');
            $t->date('date');
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('report_counseling_id', 'fk_rcon_score_rcon')
                ->references('id')->on('report_counseling')->cascadeOnDelete();
            $t->foreign('counseling_assessment_id', 'fk_rcon_score_assess')
                ->references('id')->on('counseling_assessment')->cascadeOnDelete();
        });
    }

    /* ───────────────── Private Counseling Schedule ───────────────── */
    private function createPrivateCounselingSchedule(): void
    {
        Schema::create('private_counseling_schedule', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('student_id');
            $t->uuid('teacher_id');
            $t->uuid('class_term_id');
            $t->enum('status', ['pending', 'disetujui', 'ditolak', 'selesai', 'batal'])->default('pending');
            $t->date('date');
            $t->time('start_hour');
            $t->time('end_hour');
            $t->string('topic');
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('student_id')->references('id')->on('student')->cascadeOnDelete();
            $t->foreign('teacher_id')->references('id')->on('user')->cascadeOnDelete();
            $t->foreign('class_term_id')->references('id')->on('class_term')->cascadeOnDelete();
        });
    }
};
