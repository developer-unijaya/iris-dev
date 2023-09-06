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
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GroupRoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\Reference\AreaInterviewCentreController;
use App\Http\Controllers\Security\MenuController;
use App\Http\Controllers\Reference\StateController;
use App\Http\Controllers\Reference\ReligionController;
use App\Http\Controllers\Reference\MaritalStatusController;
use App\Http\Controllers\Reference\DepartmentMinistryController;
use App\Http\Controllers\Reference\SkimController;
use App\Http\Controllers\Reference\InstitutionController;
use App\Http\Controllers\Reference\SpecializationController;
use App\Http\Controllers\Reference\QualificationController;
use App\Http\Controllers\Reference\RaceController;
use App\Http\Controllers\Reference\GenderController;
use App\Http\Controllers\Reference\JobController;
use App\Http\Controllers\Reference\LanguageController;
use App\Http\Controllers\Reference\LevelJKKController;
use App\Http\Controllers\Reference\MatriculationController;
use App\Http\Controllers\Reference\MatriculationCourseController;
use App\Http\Controllers\Reference\MatriculationSubjectController;
use App\Http\Controllers\Reference\PenaltyController;
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
});

Route::prefix('admin')->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);

    Route::get('internalUser',[UserController::class,'index'])->name('admin.internalUser');
    Route::get('externalUser',[UserController::class,'index'])->name('admin.externalUser');
    Route::get('getUser/{userId}', [UserController::class,'getUser'])->name('user.getUser');
    Route::post('update-password', [UserController::class,'updatePassword'])->name('updatePassword');

    Route::get('edit/{roleId}', [RoleController::class,'getRole'])->name('role.kemaskini');
    Route::get('edittingRole/{roleId}', [RoleController::class, 'getRole'])->name('role.editting');
    Route::post('delete-role/{roleId}', [RoleController::class,'deleteRole'])->name('roles.delete');
    Route::get('view-role/{roleId}', [RoleController::class,'viewForm'])->name('roles.view');

    Route::post('getMenu', [RoleController::class, 'getMenu'])->name('role.getMenu');
    Route::post('getNextMenu', [RoleController::class, 'getNextMenu'])->name('role.getNextMenu');
    Route::get('editRole/{roleId}', [RoleController::class, 'editRole'])->name('role.editRole');
    Route::post('updateRole/{roleId}', [RoleController::class, 'updateRole'])->name('role.updateRole');

    Route::prefix('group_role')->group(function () {
        Route::get('/', [GroupRoleController::class, 'index'])->name('admin.group-role');

        Route::get('edit/{roleId}', [GroupRoleController::class, 'edit'])->name('admin.group-role.edit');
        Route::get('getRole/{roleId}', [GroupRoleController::class, 'getRole'])->name('admin.group-role.getRole');
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
        Route::prefix('state')->group(function () {
            Route::get('/', [StateController::class, 'index'])->name('admin.reference.state');
            Route::post('create', [StateController::class, 'store'])->name('admin.reference.state.store');
            Route::get('edit/{stateId}', [StateController::class, 'edit'])->name('admin.reference.state.edit');
            Route::post('update/{stateId}', [StateController::class, 'update'])->name('admin.reference.state.update');
        });

        Route::prefix('religion')->group(function () {
            Route::get('/', [ReligionController::class, 'index'])->name('admin.reference.religion');
            Route::post('create', [ReligionController::class, 'store'])->name('admin.reference.religion.store');
            Route::get('edit/{religionId}', [ReligionController::class, 'edit'])->name('admin.reference.religion.edit');
            Route::post('update/{religionId}', [ReligionController::class, 'update'])->name('admin.reference.religion.update');
        });

        Route::prefix('marital_status')->group(function () {
            Route::get('/', [MaritalStatusController::class, 'index'])->name('admin.reference.marital-status');
            Route::post('create', [MaritalStatusController::class, 'store'])->name('admin.reference.marital-status.store');
            Route::get('edit/{maritalStatusId}', [MaritalStatusController::class, 'edit'])->name('admin.reference.marital-status.edit');
            Route::post('update/{maritalStatusId}', [MaritalStatusController::class, 'update'])->name('admin.reference.marital-status.update');
        });

        Route::prefix('department_ministry')->group(function () {
            Route::get('/', [DepartmentMinistryController::class, 'index'])->name('admin.reference.department-ministry');
            Route::post('create', [DepartmentMinistryController::class, 'store'])->name('admin.reference.department-ministry.store');
            Route::get('edit/{departmentMinistryId}', [DepartmentMinistryController::class, 'edit'])->name('admin.reference.department-ministry.edit');
            Route::post('update/{departmentMinistryId}', [DepartmentMinistryController::class, 'update'])->name('admin.reference.department-ministry.update');
        });

        Route::prefix('skim')->group(function () {
            Route::get('/', [SkimController::class, 'index'])->name('admin.reference.skim');
            Route::post('create', [SkimController::class, 'store'])->name('admin.reference.skim.store');
            Route::get('edit/{skimId}', [SkimController::class, 'edit'])->name('admin.reference.skim.edit');
            Route::post('update/{skimId}', [SkimController::class, 'update'])->name('admin.reference.skim.update');
        });

        Route::prefix('institution')->group(function () {
            Route::get('/', [InstitutionController::class, 'index'])->name('admin.reference.institution');
            Route::post('create', [InstitutionController::class, 'store'])->name('admin.reference.institution.store');
            Route::get('edit/{institutionId}', [InstitutionController::class, 'edit'])->name('admin.reference.institution.edit');
            Route::post('update/{institutionId}', [InstitutionController::class, 'update'])->name('admin.reference.institution.update');
        });

        Route::prefix('specialization')->group(function () {
            Route::get('/', [SpecializationController::class, 'index'])->name('admin.reference.specialization');
            Route::post('create', [SpecializationController::class, 'store'])->name('admin.reference.specialization.store');
            Route::get('edit/{specializationId}', [SpecializationController::class, 'edit'])->name('admin.reference.specialization.edit');
            Route::post('update/{specializationId}', [SpecializationController::class, 'update'])->name('admin.reference.specialization.update');
        });

        Route::prefix('qualification')->group(function () {
            Route::get('/', [QualificationController::class, 'index'])->name('admin.reference.qualification');
            Route::post('create', [QualificationController::class, 'store'])->name('admin.reference.qualification.store');
            Route::get('edit/{qualificationId}', [QualificationController::class, 'edit'])->name('admin.reference.qualification.edit');
            Route::post('update/{qualificationId}', [QualificationController::class, 'update'])->name('admin.reference.qualification.update');
        });

        Route::prefix('race')->group(function () {
            Route::get('/', [RaceController::class, 'index'])->name('admin.reference.race');
            Route::post('create', [RaceController::class, 'store'])->name('admin.reference.race.store');
            Route::get('edit/{raceId}', [RaceController::class, 'edit'])->name('admin.reference.race.edit');
            Route::post('update/{raceId}', [RaceController::class, 'update'])->name('admin.reference.race.update');
        });

        Route::prefix('gender')->group(function () {
            Route::get('/', [GenderController::class, 'index'])->name('admin.reference.gender');
            Route::post('create', [GenderController::class, 'store'])->name('admin.reference.gender.store');
            Route::get('edit/{genderId}', [GenderController::class, 'edit'])->name('admin.reference.gender.edit');
            Route::post('update/{genderId}', [GenderController::class, 'update'])->name('admin.reference.gender.update');
        });

        Route::prefix('job')->group(function () {
            Route::get('/', [JobController::class, 'index'])->name('admin.reference.job');
            Route::post('create', [JobController::class, 'store'])->name('admin.reference.job.store');
            Route::get('edit/{jobId}', [JobController::class, 'edit'])->name('admin.reference.job.edit');
            Route::post('update/{jobId}', [JobController::class, 'update'])->name('admin.reference.job.update');
        });

        Route::prefix('language')->group(function () {
            Route::get('/', [LanguageController::class, 'index'])->name('admin.reference.language');
            Route::post('create', [LanguageController::class, 'store'])->name('admin.reference.language.store');
            Route::get('edit/{languageId}', [LanguageController::class, 'edit'])->name('admin.reference.language.edit');
            Route::post('update/{languageId}', [LanguageController::class, 'update'])->name('admin.reference.language.update');
        });

        Route::prefix('matriculation')->group(function () {
            Route::get('/', [MatriculationController::class, 'index'])->name('admin.reference.matriculation');
            Route::post('create', [MatriculationController::class, 'store'])->name('admin.reference.matriculation.store');
            Route::get('edit/{matriculationId}', [MatriculationController::class, 'edit'])->name('admin.reference.matriculation.edit');
            Route::post('update/{matriculationId}', [MatriculationController::class, 'update'])->name('admin.reference.matriculation.update');
        });

        Route::prefix('matriculation_course')->group(function () {
            Route::get('/', [MatriculationCourseController::class, 'index'])->name('admin.reference.matriculation-course');
            Route::post('create', [MatriculationCourseController::class, 'store'])->name('admin.reference.matriculation-course.store');
            Route::get('edit/{matriculationCourseId}', [MatriculationCourseController::class, 'edit'])->name('admin.reference.matriculation-course.edit');
            Route::post('update/{matriculationCourseId}', [MatriculationCourseController::class, 'update'])->name('admin.reference.matriculation-course.update');
        });

        Route::prefix('matriculation_subject')->group(function () {
            Route::get('/', [MatriculationSubjectController::class, 'index'])->name('admin.reference.matriculation-subject');
            Route::post('create', [MatriculationSubjectController::class, 'store'])->name('admin.reference.matriculation-subject.store');
            Route::get('edit/{matriculationSubjectId}', [MatriculationSubjectController::class, 'edit'])->name('admin.reference.matriculation-subject.edit');
            Route::post('update/{matriculationSubjectId}', [MatriculationSubjectController::class, 'update'])->name('admin.reference.matriculation-subject.update');
        });

        Route::prefix('position_level')->group(function () {
            Route::get('/', [PositionLevelController::class, 'index'])->name('admin.reference.position-level');
            Route::post('create', [PositionLevelController::class, 'store'])->name('admin.reference.position-level.store');
            Route::get('edit/{positionLevelId}', [PositionLevelController::class, 'edit'])->name('admin.reference.position-level.edit');
            Route::post('update/{positionLevelId}', [PositionLevelController::class, 'update'])->name('admin.reference.position-level.update');
        });

        Route::prefix('rank')->group(function () {
            Route::get('/', [RankController::class, 'index'])->name('admin.reference.rank');
            Route::post('create', [RankController::class, 'store'])->name('admin.reference.rank.store');
            Route::get('edit/{rankId}', [RankController::class, 'edit'])->name('admin.reference.rank.edit');
            Route::post('update/{rankId}', [RankController::class, 'update'])->name('admin.reference.rank.update');
        });

        Route::prefix('subject')->group(function () {
            Route::get('/', [SubjectController::class, 'index'])->name('admin.reference.subject');
            Route::post('create', [SubjectController::class, 'store'])->name('admin.reference.subject.store');
            Route::get('edit/{subjectId}', [SubjectController::class, 'edit'])->name('admin.reference.subject.edit');
            Route::post('update/{subjectId}', [SubjectController::class, 'update'])->name('admin.reference.subject.update');
        });

        Route::prefix('talent')->group(function () {
            Route::get('/', [TalentController::class, 'index'])->name('admin.reference.talent');
            Route::post('create', [TalentController::class, 'store'])->name('admin.reference.talent.store');
            Route::get('edit/{talentId}', [TalentController::class, 'edit'])->name('admin.reference.talent.edit');
            Route::post('update/{talentId}', [TalentController::class, 'update'])->name('admin.reference.talent.update');
        });

        Route::prefix('salary_grade')->group(function () {
            Route::get('/', [SalaryGradeController::class, 'index'])->name('admin.reference.salary-grade');
            Route::post('create', [SalaryGradeController::class, 'store'])->name('admin.reference.salary-grade.store');
            Route::get('edit/{salaryGradeId}', [SalaryGradeController::class, 'edit'])->name('admin.reference.salary-grade.edit');
            Route::post('update/{salaryGradeId}', [SalaryGradeController::class, 'update'])->name('admin.reference.salary-grade.update');
        });

        Route::prefix('level_JKK')->group(function () {
            Route::get('/', [LevelJKKController::class, 'index'])->name('admin.reference.level-JKK');
            Route::post('create', [LevelJKKController::class, 'store'])->name('admin.reference.level-JKK.store');
            Route::get('edit/{levelJKKId}', [LevelJKKController::class, 'edit'])->name('admin.reference.level-JKK.edit');
            Route::post('update/{levelJKKId}', [LevelJKKController::class, 'update'])->name('admin.reference.level-JKK.update');
        });

        Route::prefix('area_interview_centre')->group(function () {
            Route::get('/', [AreaInterviewCentreController::class, 'index'])->name('admin.reference.area-interview-centre');
            Route::post('create', [AreaInterviewCentreController::class, 'store'])->name('admin.reference.area-interview-centre.store');
            Route::get('edit/{areaInterviewCentreId}', [AreaInterviewCentreController::class, 'edit'])->name('admin.reference.area-interview-centre.edit');
            Route::post('update/{areaInterviewCentreId}', [AreaInterviewCentreController::class, 'update'])->name('admin.reference.area-interview-centre.update');
        });

        Route::prefix('penalty')->group(function () {
            Route::get('/', [PenaltyController::class, 'index'])->name('admin.reference.penalty');
            Route::post('create', [PenaltyController::class, 'store'])->name('admin.reference.penalty.store');
            Route::get('edit/{penaltyId}', [PenaltyController::class, 'edit'])->name('admin.reference.penalty.edit');
            Route::post('update/{penaltyId}', [PenaltyController::class, 'update'])->name('admin.reference.penalty.update');
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
