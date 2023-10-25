<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Reference\AhliSuruhanjayaController;
use App\Http\Controllers\Reference\BahagianController;
use App\Http\Controllers\Reference\CutiAwamController;
use App\Http\Controllers\Reference\DaerahController;
use App\Http\Controllers\Reference\JelasUrusanController;
use App\Http\Controllers\Reference\JenisOkuJKMController;
use App\Http\Controllers\Reference\JenisSkimController;
use App\Http\Controllers\Reference\JKKCController;
use App\Http\Controllers\Reference\KelayakanSetarafController;
use App\Http\Controllers\Reference\KetuaPerkhidmatanController;
use App\Http\Controllers\Reference\KlasifikasiPerkhidmatanController;
use App\Http\Controllers\Reference\KodPelbagaiController;
use App\Http\Controllers\Reference\KumpulanJKKController;
use App\Http\Controllers\Reference\KumpulanSSMController;
use App\Http\Controllers\Reference\NegaraController;
use App\Http\Controllers\Reference\NegeriJPNController;
use App\Http\Controllers\Reference\PenajaController;
use App\Http\Controllers\Reference\RulingController;
use App\Http\Controllers\Reference\SalaryGradeDetailsController;
use App\Http\Controllers\Reference\SebabTolakController;
use App\Http\Controllers\Reference\SenaraiCutiController;
use App\Http\Controllers\Reference\SkimPerkhidmatanController;
use App\Http\Controllers\Reference\StatusController;
use App\Http\Controllers\Reference\SuruhanjayaController;
use App\Http\Controllers\Reference\TawaranKursusController;
use App\Http\Controllers\Reference\ZonTelefonController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GroupRoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\CheckEmailController;
use App\Http\Controllers\Reference\AreaInterviewCentreController;
use App\Http\Controllers\Security\MenuController;
use App\Http\Controllers\Reference\StateController;
use App\Http\Controllers\Reference\ReligionController;
use App\Http\Controllers\Reference\MaritalStatusController;
use App\Http\Controllers\Reference\DepartmentMinistryController;
use App\Http\Controllers\Reference\EligibilityController;
use App\Http\Controllers\Reference\SkimController;
use App\Http\Controllers\Reference\InstitutionController;
use App\Http\Controllers\Reference\SpecializationController;
use App\Http\Controllers\Reference\QualificationController;
use App\Http\Controllers\Reference\RaceController;
use App\Http\Controllers\Reference\GenderController;
use App\Http\Controllers\Reference\InterviewCentreController;
use App\Http\Controllers\Reference\JenisBekasTenteraPolisController;
use App\Http\Controllers\Reference\JobController;
use App\Http\Controllers\Reference\LanguageController;
use App\Http\Controllers\Reference\LevelJKKController;
use App\Http\Controllers\Reference\MatriculationController;
use App\Http\Controllers\Reference\MatriculationCourseController;
use App\Http\Controllers\Reference\MatriculationSubjectController;
use App\Http\Controllers\Reference\PenaltyController;
use App\Http\Controllers\Reference\Pengalaman9Controller;
use App\Http\Controllers\Reference\PositionLevelController;
use App\Http\Controllers\Reference\RankController;
use App\Http\Controllers\Reference\SalaryGradeController;
use App\Http\Controllers\Reference\SubjectController;
use App\Http\Controllers\Reference\TalentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('test-ts', [App\Http\Controllers\TestController::class, 'updateTimesheet']);
// Route::get('test-chart', [FinanceController::class, 'manpowerChart']);

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('emptyresponse', function () {
    return response()->json(['title' => ' ']);
})->name('emptyResponse');

Auth::routes();
Route::controller(LoginController::class)->group(function () {
    // Syntax
    // Route::get('name of link', 'name of function')

    Route::get('logout', 'logout')->name('logout.get');

    Route::prefix('auth/google')->group(function () {
        Route::get('/', 'redirectToProvider')->name('google.redirect');
        Route::get('auth/google/callback', 'handleProviderCallback')->name('google.callback');
    });

});

Route::get('reload-captcha', [CaptchaController::class, 'reloadCaptcha'])->name('reload.captcha');

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('/check-email-blocked/{email}', [CheckEmailController::class, 'checkEmailBlocked'])->name('check-email-blocked');

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

Route::get('inbox', [InboxController::class, 'index'])->name('inbox');

Route::controller(StatisticsController::class)->group(function () {
    Route::get('statistics', 'index')->name('statistics');
    Route::post('statistics', 'generateChart')->name('statistics.generate');
});

Route::prefix('profile')->group(function () {
    Route::get('view', [ProfileController::class, 'view'])->name('profile-view');
    Route::post('update', [ProfileController::class, 'update'])->name('profile-update');
    Route::post('update-password-first', [ProfileController::class, 'updatePasswordFirst'])->name('profile-update-password-first');
});

Route::prefix('admin')->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);

    Route::get('internalUser',[UserController::class,'index'])->name('admin.internalUser');
    Route::get('externalUser',[UserController::class,'index'])->name('admin.externalUser');
    Route::get('getUser/{userId}', [UserController::class,'getUser'])->name('user.getUser');
    Route::post('update-password', [UserController::class,'updatePassword'])->name('updatePassword');
    Route::post('deleteUser/{userId}', [UserController::class, 'deleteUser'])->name('user.delete');

    Route::get('edit/{roleId}', [RoleController::class,'getRole'])->name('role.kemaskini');
    Route::get('edittingRole/{roleId}', [RoleController::class, 'getRole'])->name('role.editting');
    Route::get('view-role/{roleId}', [RoleController::class,'viewForm'])->name('roles.view');

    Route::post('getMenu', [RoleController::class, 'getMenu'])->name('role.getMenu');
    Route::post('getNextMenu', [RoleController::class, 'getNextMenu'])->name('role.getNextMenu');
    Route::get('editRole/{roleId}', [RoleController::class, 'editRole'])->name('role.editRole');
    Route::post('updateRole/{roleId}', [RoleController::class, 'updateRole'])->name('role.updateRole');
    Route::post('delete-role/{roleId}', [RoleController::class,'deleteRole'])->name('roles.delete');

    Route::prefix('group_role')->group(function () {
        Route::get('/', [GroupRoleController::class, 'index'])->name('admin.group-role');

        Route::get('edit/{roleId}', [GroupRoleController::class, 'edit'])->name('admin.group-role.edit');
        Route::get('getRole/{roleId}', [GroupRoleController::class, 'getRole'])->name('admin.group-role.getRole');
        Route::post('addUserRole', [GroupRoleController::class, 'storeUserRole'])->name('admin.group-role.addUserRole');
        Route::post('removeUser/{userId}', [GroupRoleController::class, 'removeUserRole'])->name('admin.group-role.removeUserRole');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/', [SettingsController::class, 'update'])->name('admin.settings');
        Route::prefix('save')->group(function () {
            Route::post('/', [SettingsController::class, 'settings_save'])->name('admin.settings.save');
        });
        Route::prefix('checkemail')->group(function () {
            Route::post('/', [SettingsController::class, 'checkEmail'])->name('admin.settings.checkemail');
        });
        Route::get('picture/{filename}', [SettingsController::class, 'picture'])->name('settings.picture');

        Route::prefix('log')->group(function () {
            Route::get('index', [ActivityLogController::class, 'index'])->name('admin-log-index');
            Route::get('view/{logID}', [ActivityLogController::class, 'view'])->name('admin-log-view');
        });

    });

    Route::prefix('reference')->group(function () {
        Route::prefix('negeri')->group(function () {
            Route::get('/', [StateController::class, 'index'])->name('admin.reference.state');
            Route::post('create', [StateController::class, 'store'])->name('admin.reference.state.store');
            Route::get('edit/{stateId}', [StateController::class, 'edit'])->name('admin.reference.state.edit');
            Route::post('update/{stateId}', [StateController::class, 'update'])->name('admin.reference.state.update');
            Route::post('toggleActive/{stateId}', [StateController::class, 'toggleActive'])->name('admin.reference.state.toggleActive');
            Route::post('delete/{stateId}', [StateController::class, 'deleteItem'])->name('admin.reference.state.delete');

        });

        Route::prefix('agama')->group(function () {
            Route::get('/', [ReligionController::class, 'index'])->name('admin.reference.religion');
            Route::post('create', [ReligionController::class, 'store'])->name('admin.reference.religion.store');
            Route::get('edit/{religionId}', [ReligionController::class, 'edit'])->name('admin.reference.religion.edit');
            Route::post('update/{religionId}', [ReligionController::class, 'update'])->name('admin.reference.religion.update');
            Route::post('toggleActive/{religionId}', [ReligionController::class, 'toggleActive'])->name('admin.reference.religion.toggleActive');
            Route::post('delete/{religionId}', [ReligionController::class, 'deleteItem'])->name('admin.reference.religion.delete');
        });

        Route::prefix('taraf_perkahwinan')->group(function () {
            Route::get('/', [MaritalStatusController::class, 'index'])->name('admin.reference.marital-status');
            Route::post('create', [MaritalStatusController::class, 'store'])->name('admin.reference.marital-status.store');
            Route::get('edit/{maritalStatusId}', [MaritalStatusController::class, 'edit'])->name('admin.reference.marital-status.edit');
            Route::post('update/{maritalStatusId}', [MaritalStatusController::class, 'update'])->name('admin.reference.marital-status.update');
            Route::post('toggleActive/{maritalStatusId}', [MaritalStatusController::class, 'toggleActive'])->name('admin.reference.marital-status.toggleActive');
            Route::post('delete/{maritalStatusId}', [MaritalStatusController::class, 'deleteItem'])->name('admin.reference.marital-status.delete');

        });

        Route::prefix('kementerian')->group(function () {
            Route::get('/', [DepartmentMinistryController::class, 'index'])->name('admin.reference.department-ministry');
            Route::post('create', [DepartmentMinistryController::class, 'store'])->name('admin.reference.department-ministry.store');
            Route::get('edit/{departmentMinistryId}', [DepartmentMinistryController::class, 'edit'])->name('admin.reference.department-ministry.edit');
            Route::post('update/{departmentMinistryId}', [DepartmentMinistryController::class, 'update'])->name('admin.reference.department-ministry.update');
            Route::post('toggleActive/{departmentMinistryId}', [DepartmentMinistryController::class, 'toggleActive'])->name('admin.reference.department-ministry.toggleActive');
            Route::post('delete/{departmentMinistryId}', [DepartmentMinistryController::class, 'deleteItem'])->name('admin.reference.department-ministry.delete');
        });

        Route::prefix('skim')->group(function () {
            Route::get('/', [SkimController::class, 'index'])->name('admin.reference.skim');
            Route::post('create', [SkimController::class, 'store'])->name('admin.reference.skim.store');
            Route::get('edit/{skimId}', [SkimController::class, 'edit'])->name('admin.reference.skim.edit');
            Route::post('update/{skimId}', [SkimController::class, 'update'])->name('admin.reference.skim.update');
            Route::post('toggleActive/{skimId}', [SkimController::class, 'toggleActive'])->name('admin.reference.skim.toggleActive');
            Route::post('delete/{skimId}', [SkimController::class, 'deleteItem'])->name('admin.reference.skim.delete');
        });

        Route::prefix('institusi')->group(function () {
            Route::get('/', [InstitutionController::class, 'index'])->name('admin.reference.institution');
            Route::post('create', [InstitutionController::class, 'store'])->name('admin.reference.institution.store');
            Route::get('edit/{institutionId}', [InstitutionController::class, 'edit'])->name('admin.reference.institution.edit');
            Route::post('update/{institutionId}', [InstitutionController::class, 'update'])->name('admin.reference.institution.update');
            Route::post('toggleActive/{institutionId}', [InstitutionController::class, 'toggleActive'])->name('admin.reference.institution.toggleActive');
            Route::get('getChild', [InstitutionController::class, 'getCategoriesByParent'])->name('admin.reference.institution.getChild');
            Route::post('delete/{institutionId}', [InstitutionController::class, 'deleteItem'])->name('admin.reference.institution.delete');
        });

        Route::prefix('pengkhususan')->group(function () {
            Route::get('/', [SpecializationController::class, 'index'])->name('admin.reference.specialization');
            Route::post('create', [SpecializationController::class, 'store'])->name('admin.reference.specialization.store');
            Route::get('edit/{specializationId}', [SpecializationController::class, 'edit'])->name('admin.reference.specialization.edit');
            Route::post('update/{specializationId}', [SpecializationController::class, 'update'])->name('admin.reference.specialization.update');
            Route::post('toggleActive/{specializationId}', [SpecializationController::class, 'toggleActive'])->name('admin.reference.specialization.toggleActive');
            Route::get('getChild', [SpecializationController::class, 'getCategoriesByParent'])->name('admin.reference.specialization.getChild');
            Route::post('delete/{specializationId}', [SpecializationController::class, 'deleteItem'])->name('admin.reference.specialization.delete');
        });

        Route::prefix('kelulusan')->group(function () {
            Route::get('/', [QualificationController::class, 'index'])->name('admin.reference.qualification');
            Route::post('create', [QualificationController::class, 'store'])->name('admin.reference.qualification.store');
            Route::get('edit/{qualificationId}', [QualificationController::class, 'edit'])->name('admin.reference.qualification.edit');
            Route::post('update/{qualificationId}', [QualificationController::class, 'update'])->name('admin.reference.qualification.update');
            Route::post('toggleActive/{qualificationId}', [QualificationController::class, 'toggleActive'])->name('admin.reference.qualification.toggleActive');
            Route::post('delete/{qualificationId}', [QualificationController::class, 'deleteItem'])->name('admin.reference.qualification.delete');
        });

        Route::prefix('keturunan')->group(function () {
            Route::get('/', [RaceController::class, 'index'])->name('admin.reference.race');
            Route::post('create', [RaceController::class, 'store'])->name('admin.reference.race.store');
            Route::get('edit/{raceId}', [RaceController::class, 'edit'])->name('admin.reference.race.edit');
            Route::post('update/{raceId}', [RaceController::class, 'update'])->name('admin.reference.race.update');
            Route::post('toggleActive/{raceId}', [RaceController::class, 'toggleActive'])->name('admin.reference.race.toggleActive');
            Route::post('delete/{raceId}', [RaceController::class, 'deleteItem'])->name('admin.reference.race.delete');
        });

        Route::prefix('jantina')->group(function () {
            Route::get('/', [GenderController::class, 'index'])->name('admin.reference.gender');
            Route::post('create', [GenderController::class, 'store'])->name('admin.reference.gender.store');
            Route::get('edit/{genderId}', [GenderController::class, 'edit'])->name('admin.reference.gender.edit');
            Route::post('update/{genderId}', [GenderController::class, 'update'])->name('admin.reference.gender.update');
            Route::post('toggleActive/{genderId}', [GenderController::class, 'toggleActive'])->name('admin.reference.gender.toggleActive');
            Route::post('delete/{genderId}', [GenderController::class, 'deleteItem'])->name('admin.reference.gender.delete');
        });

        Route::prefix('pekerjaan')->group(function () {
            Route::get('/', [JobController::class, 'index'])->name('admin.reference.job');
            Route::post('create', [JobController::class, 'store'])->name('admin.reference.job.store');
            Route::get('edit/{jobId}', [JobController::class, 'edit'])->name('admin.reference.job.edit');
            Route::post('update/{jobId}', [JobController::class, 'update'])->name('admin.reference.job.update');
            Route::post('toggleActive/{jobId}', [JobController::class, 'toggleActive'])->name('admin.reference.job.toggleActive');
        });

        Route::prefix('bahasa')->group(function () {
            Route::get('/', [LanguageController::class, 'index'])->name('admin.reference.language');
            Route::post('create', [LanguageController::class, 'store'])->name('admin.reference.language.store');
            Route::get('edit/{languageId}', [LanguageController::class, 'edit'])->name('admin.reference.language.edit');
            Route::post('update/{languageId}', [LanguageController::class, 'update'])->name('admin.reference.language.update');
            Route::post('toggleActive/{languageId}', [LanguageController::class, 'toggleActive'])->name('admin.reference.language.toggleActive');
            Route::post('delete/{languageId}', [LanguageController::class, 'deleteItem'])->name('admin.reference.language.delete');
        });

        Route::prefix('matrikulasi')->group(function () {
            Route::get('/', [MatriculationController::class, 'index'])->name('admin.reference.matriculation');
            Route::post('create', [MatriculationController::class, 'store'])->name('admin.reference.matriculation.store');
            Route::get('edit/{matriculationId}', [MatriculationController::class, 'edit'])->name('admin.reference.matriculation.edit');
            Route::post('update/{matriculationId}', [MatriculationController::class, 'update'])->name('admin.reference.matriculation.update');
            Route::post('toggleActive/{matriculationId}', [MatriculationController::class, 'toggleActive'])->name('admin.reference.matriculation.toggleActive');
            Route::post('delete/{matriculationId}', [MatriculationController::class, 'deleteItem'])->name('admin.reference.matriculation.delete');
        });

        Route::prefix('jurusan_matrikulasi')->group(function () {
            Route::get('/', [MatriculationCourseController::class, 'index'])->name('admin.reference.matriculation-course');
            Route::post('create', [MatriculationCourseController::class, 'store'])->name('admin.reference.matriculation-course.store');
            Route::get('edit/{matriculationCourseId}', [MatriculationCourseController::class, 'edit'])->name('admin.reference.matriculation-course.edit');
            Route::post('update/{matriculationCourseId}', [MatriculationCourseController::class, 'update'])->name('admin.reference.matriculation-course.update');
            Route::post('toggleActive/{matriculationCourseId}', [MatriculationCourseController::class, 'toggleActive'])->name('admin.reference.matriculation-course.toggleActive');
            Route::post('delete/{matriculationCourseId}', [MatriculationCourseController::class, 'deleteItem'])->name('admin.reference.matriculation-course.delete');
        });

        Route::prefix('subjek_matrikulasi')->group(function () {
            Route::get('/', [MatriculationSubjectController::class, 'index'])->name('admin.reference.matriculation-subject');
            Route::post('create', [MatriculationSubjectController::class, 'store'])->name('admin.reference.matriculation-subject.store');
            Route::get('edit/{matriculationSubjectId}', [MatriculationSubjectController::class, 'edit'])->name('admin.reference.matriculation-subject.edit');
            Route::post('update/{matriculationSubjectId}', [MatriculationSubjectController::class, 'update'])->name('admin.reference.matriculation-subject.update');
            Route::post('toggleActive/{matriculationSubjectId}', [MatriculationSubjectController::class, 'toggleActive'])->name('admin.reference.matriculation-subject.toggleActive');
            Route::post('delete/{matriculationSubjectId}', [MatriculationSubjectController::class, 'deleteItem'])->name('admin.reference.matriculation-subject.delete');
        });

        Route::prefix('taraf_jawatan')->group(function () {
            Route::get('/', [PositionLevelController::class, 'index'])->name('admin.reference.position-level');
            Route::post('create', [PositionLevelController::class, 'store'])->name('admin.reference.position-level.store');
            Route::get('edit/{positionLevelId}', [PositionLevelController::class, 'edit'])->name('admin.reference.position-level.edit');
            Route::post('update/{positionLevelId}', [PositionLevelController::class, 'update'])->name('admin.reference.position-level.update');
            Route::post('toggleActive/{positionLevelId}', [PositionLevelController::class, 'toggleActive'])->name('admin.reference.position-level.toggleActive');
            Route::post('delete/{positionLevelId}', [PositionLevelController::class, 'deleteItem'])->name('admin.reference.position-level.delete');
        });

        Route::prefix('pangkat')->group(function () {
            Route::get('/', [RankController::class, 'index'])->name('admin.reference.rank');
            Route::post('create', [RankController::class, 'store'])->name('admin.reference.rank.store');
            Route::get('edit/{rankId}', [RankController::class, 'edit'])->name('admin.reference.rank.edit');
            Route::post('update/{rankId}', [RankController::class, 'update'])->name('admin.reference.rank.update');
            Route::post('toggleActive/{rankId}', [RankController::class, 'toggleActive'])->name('admin.reference.rank.toggleActive');
            Route::post('delete/{rankId}', [RankController::class, 'deleteItem'])->name('admin.reference.rank.delete');
        });

        Route::prefix('matapelajaran')->group(function () {
            Route::get('/', [SubjectController::class, 'index'])->name('admin.reference.subject');
            Route::post('create', [SubjectController::class, 'store'])->name('admin.reference.subject.store');
            Route::get('edit/{subjectId}', [SubjectController::class, 'edit'])->name('admin.reference.subject.edit');
            Route::post('update/{subjectId}', [SubjectController::class, 'update'])->name('admin.reference.subject.update');
            Route::post('toggleActive/{subjectId}', [SubjectController::class, 'toggleActive'])->name('admin.reference.subject.toggleActive');
            Route::post('delete/{subjectId}', [SubjectController::class, 'deleteItem'])->name('admin.reference.subject.delete');
        });

        Route::prefix('bakat')->group(function () {
            Route::get('/', [TalentController::class, 'index'])->name('admin.reference.talent');
            Route::post('create', [TalentController::class, 'store'])->name('admin.reference.talent.store');
            Route::get('edit/{talentId}', [TalentController::class, 'edit'])->name('admin.reference.talent.edit');
            Route::post('update/{talentId}', [TalentController::class, 'update'])->name('admin.reference.talent.update');
            Route::post('toggleActive/{talentId}', [TalentController::class, 'toggleActive'])->name('admin.reference.talent.toggleActive');
            Route::post('delete/{talentId}', [TalentController::class, 'deleteItem'])->name('admin.reference.talent.delete');
        });

        Route::prefix('gred_gaji')->group(function () {
            Route::get('/', [SalaryGradeController::class, 'index'])->name('admin.reference.salary-grade');
            Route::post('create', [SalaryGradeController::class, 'store'])->name('admin.reference.salary-grade.store');
            Route::get('edit/{salaryGradeId}', [SalaryGradeController::class, 'edit'])->name('admin.reference.salary-grade.edit');
            Route::post('update/{salaryGradeId}', [SalaryGradeController::class, 'update'])->name('admin.reference.salary-grade.update');
            Route::post('toggleActive/{salaryGradeId}', [SalaryGradeController::class, 'toggleActive'])->name('admin.reference.salary-grade.toggleActive');
            Route::get('getList/{salaryGradeId}', [SalaryGradeController::class, 'getListGredDetails'])->name('admin.reference.salary-grade.getList');
            Route::post('delete/{salaryGradeId}', [SalaryGradeController::class, 'deleteItem'])->name('admin.reference.salary-grade.delete');
        });

        Route::prefix('tingkatan_JKK')->group(function () {
            Route::get('/', [LevelJKKController::class, 'index'])->name('admin.reference.level-JKK');
            Route::post('create', [LevelJKKController::class, 'store'])->name('admin.reference.level-JKK.store');
            Route::get('edit/{levelJKKId}', [LevelJKKController::class, 'edit'])->name('admin.reference.level-JKK.edit');
            Route::post('update/{levelJKKId}', [LevelJKKController::class, 'update'])->name('admin.reference.level-JKK.update');
            Route::post('toggleActive/{levelJKKId}', [LevelJKKController::class, 'toggleActive'])->name('admin.reference.level-JKK.toggleActive');
            Route::post('delete/{levelJKKId}', [LevelJKKController::class, 'deleteItem'])->name('admin.reference.level-JKK.delete');
        });

        Route::prefix('kawasan_pusat_temuduga')->group(function () {
            Route::get('/', [AreaInterviewCentreController::class, 'index'])->name('admin.reference.area-interview-centre');
            Route::post('create', [AreaInterviewCentreController::class, 'store'])->name('admin.reference.area-interview-centre.store');
            Route::get('edit/{areaInterviewCentreId}', [AreaInterviewCentreController::class, 'edit'])->name('admin.reference.area-interview-centre.edit');
            Route::post('update/{areaInterviewCentreId}', [AreaInterviewCentreController::class, 'update'])->name('admin.reference.area-interview-centre.update');
            Route::post('toggleActive/{areaInterviewCentreId}', [AreaInterviewCentreController::class, 'toggleActive'])->name('admin.reference.area-interview-centre.toggleActive');
        });

        Route::prefix('tatatertib')->group(function () {
            Route::get('/', [PenaltyController::class, 'index'])->name('admin.reference.penalty');
            Route::post('create', [PenaltyController::class, 'store'])->name('admin.reference.penalty.store');
            Route::get('edit/{penaltyId}', [PenaltyController::class, 'edit'])->name('admin.reference.penalty.edit');
            Route::post('update/{penaltyId}', [PenaltyController::class, 'update'])->name('admin.reference.penalty.update');
            Route::post('toggleActive/{penaltyId}', [PenaltyController::class, 'toggleActive'])->name('admin.reference.penalty.toggleActive');
            Route::post('delete/{penaltyId}', [PenaltyController::class, 'deleteItem'])->name('admin.reference.penalty.delete');
        });

        Route::prefix('butiran_gred_gaji')->group(function () {
            Route::get('/', [SalaryGradeDetailsController::class, 'index'])->name('admin.reference.salary-grade-details');
            Route::post('create', [SalaryGradeDetailsController::class, 'store'])->name('admin.reference.salary-grade-details.store');
            Route::get('edit/{salaryGradeDetailsId}', [SalaryGradeDetailsController::class, 'edit'])->name('admin.reference.salary-grade-details.edit');
            Route::post('update/{salaryGradeDetailsId}', [SalaryGradeDetailsController::class, 'update'])->name('admin.reference.salary-grade-details.update');
            Route::post('toggleActive/{salaryGradeDetailsId}', [SalaryGradeDetailsController::class, 'toggleActive'])->name('admin.reference.salary-grade-details.toggleActive');
            Route::get('getChild', [SalaryGradeDetailsController::class, 'getCategoriesByParent'])->name('admin.reference.salary-grade-details.getChild');
            Route::post('delete/{salaryGradeDetailsId}', [SalaryGradeDetailsController::class, 'deleteItem'])->name('admin.reference.salary-grade-details.delete');
        });

        Route::prefix('pusat_temuduga')->group(function () {
            Route::get('/', [InterviewCentreController::class, 'index'])->name('admin.reference.interview-centre');
            Route::post('create', [InterviewCentreController::class, 'store'])->name('admin.reference.interview-centre.store');
            Route::get('edit/{interviewCentreId}', [InterviewCentreController::class, 'edit'])->name('admin.reference.interview-centre.edit');
            Route::post('update/{interviewCentreId}', [InterviewCentreController::class, 'update'])->name('admin.reference.interview-centre.update');
            Route::post('toggleActive/{interviewCentreId}', [InterviewCentreController::class, 'toggleActive'])->name('admin.reference.interview-centre.toggleActive');
            Route::post('delete/{interviewCentreId}', [InterviewCentreController::class, 'deleteItem'])->name('admin.reference.interview-centre.delete');
        });

        Route::prefix('kelayakan')->group(function () {
            Route::get('/', [EligibilityController::class, 'index'])->name('admin.reference.eligibility');
            Route::post('create', [EligibilityController::class, 'store'])->name('admin.reference.eligibility.store');
            Route::get('edit/{eligibilityId}', [EligibilityController::class, 'edit'])->name('admin.reference.eligibility.edit');
            Route::post('update/{eligibilityId}', [EligibilityController::class, 'update'])->name('admin.reference.eligibility.update');
            Route::post('toggleActive/{eligibilityId}', [EligibilityController::class, 'toggleActive'])->name('admin.reference.eligibility.toggleActive');
            Route::post('delete/{eligibilityId}', [EligibilityController::class, 'deleteItem'])->name('admin.reference.eligibility.delete');
        });

        Route::prefix('kod_pelbagai')->group(function () {
            Route::get('/', [KodPelbagaiController::class, 'index'])->name('admin.reference.kodpelbagai');
            Route::post('create', [KodPelbagaiController::class, 'store'])->name('admin.reference.kodpelbagai.store');
            Route::get('edit/{kodpelbagaiId}', [KodPelbagaiController::class, 'edit'])->name('admin.reference.kodpelbagai.edit');
            Route::post('update/{kodpelbagaiId}', [KodPelbagaiController::class, 'update'])->name('admin.reference.kodpelbagai.update');
            Route::post('toggleActive/{kodpelbagaiId}', [KodPelbagaiController::class, 'toggleActive'])->name('admin.reference.kodpelbagai.toggleActive');
            Route::post('delete/{kodpelbagaiId}', [KodPelbagaiController::class, 'deleteItem'])->name('admin.reference.kodpelbagai.delete');
        });

        Route::prefix('bekas_tentera_polis')->group(function () {
            Route::get('/', [JenisBekasTenteraPolisController::class, 'index'])->name('admin.reference.bekastentera');
            Route::post('create', [JenisBekasTenteraPolisController::class, 'store'])->name('admin.reference.bekastentera.store');
            Route::get('edit/{bekastenteraId}', [JenisBekasTenteraPolisController::class, 'edit'])->name('admin.reference.bekastentera.edit');
            Route::post('update/{bekastenteraId}', [JenisBekasTenteraPolisController::class, 'update'])->name('admin.reference.bekastentera.update');
            Route::post('toggleActive/{bekastenteraId}', [JenisBekasTenteraPolisController::class, 'toggleActive'])->name('admin.reference.bekastentera.toggleActive');
            Route::post('delete/{bekastenteraId}', [JenisBekasTenteraPolisController::class, 'deleteItem'])->name('admin.reference.bekastentera.delete');
        });

        Route::prefix('bahagian')->group(function () {
            Route::get('/', [BahagianController::class, 'index'])->name('admin.reference.bahagian');
            Route::post('create', [BahagianController::class, 'store'])->name('admin.reference.bahagian.store');
            Route::get('edit/{bahagianId}', [BahagianController::class, 'edit'])->name('admin.reference.bahagian.edit');
            Route::post('update/{bahagianId}', [BahagianController::class, 'update'])->name('admin.reference.bahagian.update');
            Route::post('toggleActive/{bahagianId}', [BahagianController::class, 'toggleActive'])->name('admin.reference.bahagian.toggleActive');
            Route::post('delete/{bahagianId}', [BahagianController::class, 'deleteItem'])->name('admin.reference.bahagian.delete');
        });

        Route::prefix('daerah')->group(function () {
            Route::get('/', [DaerahController::class, 'index'])->name('admin.reference.daerah');
            Route::post('create', [DaerahController::class, 'store'])->name('admin.reference.daerah.store');
            Route::get('edit/{daerahId}', [DaerahController::class, 'edit'])->name('admin.reference.daerah.edit');
            Route::post('update/{daerahId}', [DaerahController::class, 'update'])->name('admin.reference.daerah.update');
            Route::post('toggleActive/{daerahId}', [DaerahController::class, 'toggleActive'])->name('admin.reference.daerah.toggleActive');
            Route::get('getChild', [DaerahController::class, 'getCategoriesByParent'])->name('admin.reference.daerah.getChild');
            Route::post('delete/{daerahId}', [DaerahController::class, 'deleteItem'])->name('admin.reference.daerah.delete');
        });

        Route::prefix('senarai_cuti')->group(function () {
            Route::get('/', [SenaraiCutiController::class, 'index'])->name('admin.reference.senaraicuti');
            Route::post('create', [SenaraiCutiController::class, 'store'])->name('admin.reference.senaraicuti.store');
            Route::get('edit/{senaraicutiId}', [SenaraiCutiController::class, 'edit'])->name('admin.reference.senaraicuti.edit');
            Route::post('update/{senaraicutiId}', [SenaraiCutiController::class, 'update'])->name('admin.reference.senaraicuti.update');
            Route::post('toggleActive/{senaraicutiId}', [SenaraiCutiController::class, 'toggleActive'])->name('admin.reference.senaraicuti.toggleActive');
            Route::post('delete/{senaraicutiId}', [SenaraiCutiController::class, 'deleteItem'])->name('admin.reference.senaraicuti.delete');
        });

        Route::prefix('cuti_awam')->group(function () {
            Route::get('/', [CutiAwamController::class, 'index'])->name('admin.reference.cutiawam');
            Route::post('create', [CutiAwamController::class, 'store'])->name('admin.reference.cutiawam.store');
            Route::get('edit/{cutiawamId}', [CutiAwamController::class, 'edit'])->name('admin.reference.cutiawam.edit');
            Route::post('update/{cutiawamId}', [CutiAwamController::class, 'update'])->name('admin.reference.cutiawam.update');
            Route::post('toggleActive/{cutiawamId}', [CutiAwamController::class, 'toggleActive'])->name('admin.reference.cutiawam.toggleActive');
            Route::get('getChild', [CutiAwamController::class, 'getCategoriesByParent'])->name('admin.reference.cutiawam.getChild');
            Route::post('delete/{cutiawamId}', [CutiAwamController::class, 'deleteItem'])->name('admin.reference.cutiawam.delete');
        });

        Route::prefix('suruhanjaya')->group(function () {
            Route::get('/', [SuruhanjayaController::class, 'index'])->name('admin.reference.suruhanjaya');
            Route::post('create', [SuruhanjayaController::class, 'store'])->name('admin.reference.suruhanjaya.store');
            Route::get('edit/{suruhanjayaId}', [SuruhanjayaController::class, 'edit'])->name('admin.reference.suruhanjaya.edit');
            Route::post('update/{suruhanjayaId}', [SuruhanjayaController::class, 'update'])->name('admin.reference.suruhanjaya.update');
            Route::post('toggleActive/{suruhanjayaId}', [SuruhanjayaController::class, 'toggleActive'])->name('admin.reference.suruhanjaya.toggleActive');
            Route::post('delete/{suruhanjayaId}', [SuruhanjayaController::class, 'deleteItem'])->name('admin.reference.suruhanjaya.delete');
        });

        Route::prefix('penaja')->group(function () {
            Route::get('/', [PenajaController::class, 'index'])->name('admin.reference.penaja');
            Route::post('create', [PenajaController::class, 'store'])->name('admin.reference.penaja.store');
            Route::get('edit/{penajaId}', [PenajaController::class, 'edit'])->name('admin.reference.penaja.edit');
            Route::post('update/{penajaId}', [PenajaController::class, 'update'])->name('admin.reference.penaja.update');
            Route::post('toggleActive/{penajaId}', [PenajaController::class, 'toggleActive'])->name('admin.reference.penaja.toggleActive');
            Route::post('delete/{penajaId}', [PenajaController::class, 'deleteItem'])->name('admin.reference.penaja.delete');
        });

        Route::prefix('status')->group(function () {
            Route::get('/', [StatusController::class, 'index'])->name('admin.reference.status');
            Route::post('create', [StatusController::class, 'store'])->name('admin.reference.status.store');
            Route::get('edit/{statusId}', [StatusController::class, 'edit'])->name('admin.reference.status.edit');
            Route::post('update/{statusId}', [StatusController::class, 'update'])->name('admin.reference.status.update');
            Route::post('toggleActive/{statusId}', [StatusController::class, 'toggleActive'])->name('admin.reference.status.toggleActive');
            Route::post('delete/{statusId}', [StatusController::class, 'deleteItem'])->name('admin.reference.status.delete');
        });

        Route::prefix('sebab_tolak')->group(function () {
            Route::get('/', [SebabTolakController::class, 'index'])->name('admin.reference.sebabtolak');
            Route::post('create', [SebabTolakController::class, 'store'])->name('admin.reference.sebabtolak.store');
            Route::get('edit/{sebabtolakId}', [SebabTolakController::class, 'edit'])->name('admin.reference.sebabtolak.edit');
            Route::post('update/{sebabtolakId}', [SebabTolakController::class, 'update'])->name('admin.reference.sebabtolak.update');
            Route::post('toggleActive/{sebabtolakId}', [SebabTolakController::class, 'toggleActive'])->name('admin.reference.sebabtolak.toggleActive');
            Route::post('delete/{sebabtolakId}', [SebabTolakController::class, 'deleteItem'])->name('admin.reference.sebabtolak.delete');
        });

        Route::prefix('zon_telefon')->group(function () {
            Route::get('/', [ZonTelefonController::class, 'index'])->name('admin.reference.zontelefon');
            Route::post('create', [ZonTelefonController::class, 'store'])->name('admin.reference.zontelefon.store');
            Route::get('edit/{zontelefonId}', [ZonTelefonController::class, 'edit'])->name('admin.reference.zontelefon.edit');
            Route::post('update/{zontelefonId}', [ZonTelefonController::class, 'update'])->name('admin.reference.zontelefon.update');
            Route::post('toggleActive/{zontelefonId}', [ZonTelefonController::class, 'toggleActive'])->name('admin.reference.zontelefon.toggleActive');
            Route::post('delete/{zontelefonId}', [ZonTelefonController::class, 'deleteItem'])->name('admin.reference.zontelefon.delete');
        });

        Route::prefix('kelayakan_setaraf')->group(function () {
            Route::get('/', [KelayakanSetarafController::class, 'index'])->name('admin.reference.kelayakansetaraf');
            Route::post('create', [KelayakanSetarafController::class, 'store'])->name('admin.reference.kelayakansetaraf.store');
            Route::get('edit/{kelayakansetarafId}', [KelayakanSetarafController::class, 'edit'])->name('admin.reference.kelayakansetaraf.edit');
            Route::post('update/{kelayakansetarafId}', [KelayakanSetarafController::class, 'update'])->name('admin.reference.kelayakansetaraf.update');
            Route::post('toggleActive/{kelayakansetarafId}', [KelayakanSetarafController::class, 'toggleActive'])->name('admin.reference.kelayakansetaraf.toggleActive');
            Route::post('delete/{kelayakansetarafId}', [KelayakanSetarafController::class, 'deleteItem'])->name('admin.reference.kelayakansetaraf.delete');
        });

        Route::prefix('ketua_perkhidmatan')->group(function () {
            Route::get('/', [KetuaPerkhidmatanController::class, 'index'])->name('admin.reference.ketuaperkhidmatan');
            Route::post('create', [KetuaPerkhidmatanController::class, 'store'])->name('admin.reference.ketuaperkhidmatan.store');
            Route::get('edit/{ketuaperkhidmatanId}', [KetuaPerkhidmatanController::class, 'edit'])->name('admin.reference.ketuaperkhidmatan.edit');
            Route::post('update/{ketuaperkhidmatanId}', [KetuaPerkhidmatanController::class, 'update'])->name('admin.reference.ketuaperkhidmatan.update');
            Route::post('toggleActive/{ketuaperkhidmatanId}', [KetuaPerkhidmatanController::class, 'toggleActive'])->name('admin.reference.ketuaperkhidmatan.toggleActive');
            Route::post('delete/{ketuaperkhidmatanId}', [KetuaPerkhidmatanController::class, 'deleteItem'])->name('admin.reference.ketuaperkhidmatan.delete');
        });

        Route::prefix('kumpulan_JKK')->group(function () {
            Route::get('/', [KumpulanJKKController::class, 'index'])->name('admin.reference.kumpulanjkk');
            Route::post('create', [KumpulanJKKController::class, 'store'])->name('admin.reference.kumpulanjkk.store');
            Route::get('edit/{kumpulanjkkId}', [KumpulanJKKController::class, 'edit'])->name('admin.reference.kumpulanjkk.edit');
            Route::post('update/{kumpulanjkkId}', [KumpulanJKKController::class, 'update'])->name('admin.reference.kumpulanjkk.update');
            Route::post('toggleActive/{kumpulanjkkId}', [KumpulanJKKController::class, 'toggleActive'])->name('admin.reference.kumpulanjkk.toggleActive');
            Route::post('delete/{kumpulanjkkId}', [KumpulanJKKController::class, 'deleteItem'])->name('admin.reference.kumpulanjkk.delete');
        });

        Route::prefix('negara')->group(function () {
            Route::get('/', [NegaraController::class, 'index'])->name('admin.reference.negara');
            Route::post('create', [NegaraController::class, 'store'])->name('admin.reference.negara.store');
            Route::get('edit/{negaraId}', [NegaraController::class, 'edit'])->name('admin.reference.negara.edit');
            Route::post('update/{negaraId}', [NegaraController::class, 'update'])->name('admin.reference.negara.update');
            Route::post('toggleActive/{negaraId}', [NegaraController::class, 'toggleActive'])->name('admin.reference.negara.toggleActive');
            Route::post('delete/{negaraId}', [NegaraController::class, 'deleteItem'])->name('admin.reference.negara.delete');
        });

        Route::prefix('kumpulan_SSM')->group(function () {
            Route::get('/', [KumpulanSSMController::class, 'index'])->name('admin.reference.kumpulanssm');
            Route::post('create', [KumpulanSSMController::class, 'store'])->name('admin.reference.kumpulanssm.store');
            Route::get('edit/{kumpulanssmId}', [KumpulanSSMController::class, 'edit'])->name('admin.reference.kumpulanssm.edit');
            Route::post('update/{kumpulanssmId}', [KumpulanSSMController::class, 'update'])->name('admin.reference.kumpulanssm.update');
            Route::post('toggleActive/{kumpulanssmId}', [KumpulanSSMController::class, 'toggleActive'])->name('admin.reference.kumpulanssm.toggleActive');
            Route::post('delete/{kumpulanssmId}', [KumpulanSSMController::class, 'deleteItem'])->name('admin.reference.kumpulanssm.delete');
        });

        Route::prefix('tawaran_kursus')->group(function () {
            Route::get('/', [TawaranKursusController::class, 'index'])->name('admin.reference.tawarankursus');
            Route::post('create', [TawaranKursusController::class, 'store'])->name('admin.reference.tawarankursus.store');
            Route::get('edit/{tawarankursusId}', [TawaranKursusController::class, 'edit'])->name('admin.reference.tawarankursus.edit');
            Route::post('update/{tawarankursusId}', [TawaranKursusController::class, 'update'])->name('admin.reference.tawarankursus.update');
            Route::post('toggleActive/{tawarankursusId}', [TawaranKursusController::class, 'toggleActive'])->name('admin.reference.tawarankursus.toggleActive');
            Route::post('delete/{tawarankursusId}', [TawaranKursusController::class, 'deleteItem'])->name('admin.reference.tawarankursus.delete');
        });

        Route::prefix('ruling')->group(function () {
            Route::get('/', [RulingController::class, 'index'])->name('admin.reference.ruling');
            Route::post('create', [RulingController::class, 'store'])->name('admin.reference.ruling.store');
            Route::get('edit/{rulingId}', [RulingController::class, 'edit'])->name('admin.reference.ruling.edit');
            Route::post('update/{rulingId}', [RulingController::class, 'update'])->name('admin.reference.ruling.update');
            Route::post('toggleActive/{rulingId}', [RulingController::class, 'toggleActive'])->name('admin.reference.ruling.toggleActive');
            Route::post('delete/{rulingId}', [RulingController::class, 'deleteItem'])->name('admin.reference.ruling.delete');
        });

        Route::prefix('negeri_jpn')->group(function () {
            Route::get('/', [NegeriJPNController::class, 'index'])->name('admin.reference.negerijpn');
            Route::post('create', [NegeriJPNController::class, 'store'])->name('admin.reference.negerijpn.store');
            Route::get('edit/{negerijpnId}', [NegeriJPNController::class, 'edit'])->name('admin.reference.negerijpn.edit');
            Route::post('update/{negerijpnId}', [NegeriJPNController::class, 'update'])->name('admin.reference.negerijpn.update');
            Route::post('toggleActive/{negerijpnId}', [NegeriJPNController::class, 'toggleActive'])->name('admin.reference.negerijpn.toggleActive');
            Route::get('getChild', [NegeriJPNController::class, 'getCategoriesByParent'])->name('admin.reference.negerijpn.getChild');
            Route::post('delete/{negerijpnId}', [NegeriJPNController::class, 'deleteItem'])->name('admin.reference.negerijpn.delete');
        });

        Route::prefix('skim_perkhidmatan')->group(function () {
            Route::get('/', [SkimPerkhidmatanController::class, 'index'])->name('admin.reference.skimperkhidmatan');
            Route::post('create', [SkimPerkhidmatanController::class, 'store'])->name('admin.reference.skimperkhidmatan.store');
            Route::get('edit/{skimperkhidmatanId}', [SkimPerkhidmatanController::class, 'edit'])->name('admin.reference.skimperkhidmatan.edit');
            Route::post('update/{skimperkhidmatanId}', [SkimPerkhidmatanController::class, 'update'])->name('admin.reference.skimperkhidmatan.update');
            Route::post('toggleActive/{skimperkhidmatanId}', [SkimPerkhidmatanController::class, 'toggleActive'])->name('admin.reference.skimperkhidmatan.toggleActive');
            Route::post('delete/{skimperkhidmatanId}', [SkimPerkhidmatanController::class, 'deleteItem'])->name('admin.reference.skimperkhidmatan.delete');
        });

        Route::prefix('sub_oku')->group(function () {
            Route::get('/', [JenisOkuJKMController::class, 'index'])->name('admin.reference.jenisoku');
            Route::post('create', [JenisOkuJKMController::class, 'store'])->name('admin.reference.jenisoku.store');
            Route::get('edit/{jenisokuId}', [JenisOkuJKMController::class, 'edit'])->name('admin.reference.jenisoku.edit');
            Route::post('update/{jenisokuId}', [JenisOkuJKMController::class, 'update'])->name('admin.reference.jenisoku.update');
            Route::post('toggleActive/{jenisokuId}', [JenisOkuJKMController::class, 'toggleActive'])->name('admin.reference.jenisoku.toggleActive');
            Route::post('delete/{jenisokuId}', [JenisOkuJKMController::class, 'deleteItem'])->name('admin.reference.jenisoku.delete');
        });

        Route::prefix('jelas_urusan')->group(function () {
            Route::get('/', [JelasUrusanController::class, 'index'])->name('admin.reference.jelasurusan');
            Route::post('create', [JelasUrusanController::class, 'store'])->name('admin.reference.jelasurusan.store');
            Route::get('edit/{jelasurusanId}', [JelasUrusanController::class, 'edit'])->name('admin.reference.jelasurusan.edit');
            Route::post('update/{jelasurusanId}', [JelasUrusanController::class, 'update'])->name('admin.reference.jelasurusan.update');
            Route::post('toggleActive/{jelasurusanId}', [JelasUrusanController::class, 'toggleActive'])->name('admin.reference.jelasurusan.toggleActive');
            Route::post('delete/{jelasurusanId}', [JelasUrusanController::class, 'deleteItem'])->name('admin.reference.jelasurusan.delete');
        });

        Route::prefix('klasifikasi_perkhidmatan')->group(function () {
            Route::get('/', [KlasifikasiPerkhidmatanController::class, 'index'])->name('admin.reference.klasifikasiperkhidmatan');
            Route::post('create', [KlasifikasiPerkhidmatanController::class, 'store'])->name('admin.reference.klasifikasiperkhidmatan.store');
            Route::get('edit/{klasifikasiperkhidmatanId}', [KlasifikasiPerkhidmatanController::class, 'edit'])->name('admin.reference.klasifikasiperkhidmatan.edit');
            Route::post('update/{klasifikasiperkhidmatanId}', [KlasifikasiPerkhidmatanController::class, 'update'])->name('admin.reference.klasifikasiperkhidmatan.update');
            Route::post('toggleActive/{klasifikasiperkhidmatanId}', [KlasifikasiPerkhidmatanController::class, 'toggleActive'])->name('admin.reference.klasifikasiperkhidmatan.toggleActive');
            Route::post('delete/{klasifikasiperkhidmatanId}', [KlasifikasiPerkhidmatanController::class, 'deleteItem'])->name('admin.reference.klasifikasiperkhidmatan.delete');
        });

        Route::prefix('skim_kumpulan_perkhidmatan_c')->group(function () {
            Route::get('/', [JKKCController::class, 'index'])->name('admin.reference.jkkc');
            Route::post('create', [JKKCController::class, 'store'])->name('admin.reference.jkkc.store');
            Route::get('edit/{jkkcId}', [JKKCController::class, 'edit'])->name('admin.reference.jkkc.edit');
            Route::post('update/{jkkcId}', [JKKCController::class, 'update'])->name('admin.reference.jkkc.update');
            Route::post('toggleActive/{jkkcId}', [JKKCController::class, 'toggleActive'])->name('admin.reference.jkkc.toggleActive');
            Route::post('delete/{jkkcId}', [JKKCController::class, 'deleteItem'])->name('admin.reference.jkkc.delete');
        });

        Route::prefix('ahli_suruhanjaya')->group(function () {
            Route::get('/', [AhliSuruhanjayaController::class, 'index'])->name('admin.reference.ahlisuruhanjaya');
            Route::post('create', [AhliSuruhanjayaController::class, 'store'])->name('admin.reference.ahlisuruhanjaya.store');
            Route::get('edit/{ahlisuruhanjayaId}', [AhliSuruhanjayaController::class, 'edit'])->name('admin.reference.ahlisuruhanjaya.edit');
            Route::post('update/{ahlisuruhanjayaId}', [AhliSuruhanjayaController::class, 'update'])->name('admin.reference.ahlisuruhanjaya.update');
            Route::post('toggleActive/{ahlisuruhanjayaId}', [AhliSuruhanjayaController::class, 'toggleActive'])->name('admin.reference.ahlisuruhanjaya.toggleActive');
            Route::post('delete/{ahlisuruhanjayaId}', [AhliSuruhanjayaController::class, 'deleteItem'])->name('admin.reference.ahlisuruhanjaya.delete');
        });

        Route::prefix('pengalaman_9')->group(function () {
            Route::get('/', [Pengalaman9Controller::class, 'index'])->name('admin.reference.pengalaman9');
            Route::post('create', [Pengalaman9Controller::class, 'store'])->name('admin.reference.pengalaman9.store');
            Route::get('edit/{pengalaman9Id}', [Pengalaman9Controller::class, 'edit'])->name('admin.reference.pengalaman9.edit');
            Route::post('update/{pengalaman9Id}', [Pengalaman9Controller::class, 'update'])->name('admin.reference.pengalaman9.update');
            Route::post('toggleActive/{pengalaman9Id}', [Pengalaman9Controller::class, 'toggleActive'])->name('admin.reference.pengalaman9.toggleActive');
            Route::post('delete/{pengalaman9Id}', [Pengalaman9Controller::class, 'deleteItem'])->name('admin.reference.pengalaman9.delete');
        });

        Route::prefix('jenis_skim')->group(function () {
            Route::get('/', [JenisSkimController::class, 'index'])->name('admin.reference.jenisskim');
            Route::post('create', [JenisSkimController::class, 'store'])->name('admin.reference.jenisskim.store');
            Route::get('edit/{jenisskimId}', [JenisSkimController::class, 'edit'])->name('admin.reference.jenisskim.edit');
            Route::post('update/{jenisskimId}', [JenisSkimController::class, 'update'])->name('admin.reference.jenisskim.update');
            Route::post('toggleActive/{jenisskimId}', [JenisSkimController::class, 'toggleActive'])->name('admin.reference.jenisskim.toggleActive');
            Route::post('delete/{jenisskimId}', [JenisSkimController::class, 'deleteItem'])->name('admin.reference.jenisskim.delete');
        });

    });

    Route::prefix('security')->group(function () {
        Route::prefix('menu')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('admin.security.menu');
            Route::get('create', [MenuController::class, 'create'])->name('admin.security.menu.create');
            Route::post('store', [MenuController::class, 'store'])->name('admin.security.menu.store');
            Route::get('edit/{menuId}', [MenuController::class, 'edit'])->name('admin.security.menu.edit');
            Route::post('update/{menuId}', [MenuController::class, 'update'])->name('admin.security.menu.update');
            Route::post('link', [MenuController::class, 'menuLink'])->name('admin.security.menu.link');
        });

        Route::get('access', [SecurityController::class, 'accessIndex'])->name('admin.security.access');

        Route::get('sequence', [SecurityController::class, 'sequenceIndex'])->name('admin.security.sequence');
    });

    Route::prefix('log')->group(function () {
        Route::get('/', [LogController::class, 'index'])->name('admin.log');
        Route::get('{id}', [LogController::class, 'view'])->name('admin.log.view');
    });

    Route::prefix('general')->group(function () {
        Route::resource('announcement', AnnouncementController::class);
        Route::resource('faq', FaqController::class);
        Route::resource('faq', FaqController::class);

        Route::get('refreshFaqTable', [FaqController::class, 'refreshFaqTable'])->name('faq.refreshFaqTable');

        Route::get('refreshAnnouncementTable', [AnnouncementController::class, 'refreshAnnouncementTable'])->name('announcement.refreshAnnouncementTable');

        Route::resource('notify', NotifyController::class);
        Route::get('notify/send/{id}', [NotifyController::class, 'showSendNotification'])->name('notify.send-view');
        Route::post('notify/send/{id}', [NotifyController::class, 'sendNotification'])->name('notify.send');

        Route::resource('holiday', HolidayController::class);
        Route::post('holiday/update_weekend', [HolidayController::class, 'updateWeekend'])->name('holiday.update_weekend');
    });
});

Route::controller(EmailController::class)->group(function () {

    Route::post('addEmail', 'addEmail')->name('email.addEmail');
    Route::delete('deleteEmail', 'deleteEmail')->name('email.deleteEmail');

});

include 'documentation.php';
include 'custom_route/report_example_route.php';
include 'custom_route/test_form.php';
include 'custom_route/test_form_no_fmf.php';

// ROUTE: IRIS
include 'iris.php';
