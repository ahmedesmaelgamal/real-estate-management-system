<?php



use App\Http\Controllers\Admin\{
    SettingController,
    AdminController,
    AgendaController,
    AssociationController,
    AuthController,
    CasesController,
    CaseTypesController,
    CaseUpdateController,
    CaseUpdateTypeController,
    ContractController,
    CourtCasesController,
    HomeController,
    JudiciatyTypesController,
    MediaController,
    MeetingController,
    MeetSummaryController as AdminMeetSummaryController,
    RealStateController,
    UnitController,
    UserController,
    VotesController
};
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('adminHome');
});
Route::group(
    [
        //        'prefix' => LaravelLocalization::setLocale(),
        //        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        Route::group(['prefix' => 'admin'], function () {
            Route::get('login', [AuthController::class, 'index'])->name('admin.login');
            Route::POST('login', [AuthController::class, 'login'])->name('admin.login');
            Route::POST('loginWithPhone', [AuthController::class, 'loginWithPhone'])->name('admin.loginWithPhone');
            Route::post('checkOtp', [AuthController::class, 'checkOtp']);
            Route::get('change_language/{id}', [\App\Http\Controllers\Admin\SettingController::class, 'changeLanguage'])->name('change_language');
            Route::get('forgetPasswordForm', [AuthController::class, 'forgetPasswordForm'])->name('admin.forgetPasswordForm');
            Route::post('forgetPassword', [AuthController::class, 'forgetPassword'])->name('admin.forgetPassword');
            Route::post('resetPassword', [AuthController::class, 'resetPassword'])->name('admin.resetPassword');
            Route::get('resetPasswordForm', [AuthController::class, 'resetPasswordForm'])->name('admin.resetPasswordForm');
            //            Route::post('sendOtp', [AuthController::class, 'sendOtp']);
            Route::get('checkOtpForm', [AuthController::class, 'checkOtpForm'])->name('admin.checkOtpForm');
            Route::get('checkOtp', [AuthController::class, 'checkOtp'])->name('admin.checkOtp');
            Route::get('terms', [SettingController::class, 'terms'])->name('terms');

            Route::group(['middleware' => 'auth:admin'], function () {

                Route::get('/dashboard', [HomeController::class, 'index'])->name('adminHome');
                Route::get('associations/stats/{year}', [HomeController::class, 'getNewAssocationsDate'])->whereNumber('year')
                    ->name('associations.byYear');
                Route::get('realState/stats/{year}', [HomeController::class, 'getNewrealState'])->whereNumber('year')
                    ->name('realState.byYear');
                Route::get('units/stats/{year}', [HomeController::class, 'getNewUnits'])->whereNumber('year')
                    ->name('units.byYear');


                #============================ Admin ====================================

                Route::get('admins/singlePageCreate', [AdminController::class, "singlePageCreate"])->name('admins.singlePageCreate');
                Route::resource('admins', AdminController::class);
                Route::post('admins/deleteSelected', [\App\Http\Controllers\Admin\AdminController::class, "deleteSelected"])->name('admins.deleteSelected');
                Route::post('admins/updateColumnSelected', [\App\Http\Controllers\Admin\AdminController::class, "updateColumnSelected"])->name('admins.updateColumnSelected');
                Route::get('admins/singlePageCreate', [\App\Http\Controllers\Admin\AdminController::class, "singlePageCreate"])->name('admins.singlePageCreate');
                Route::get('my_profile', [AdminController::class, 'myProfile'])->name('myProfile');
                Route::get('my_profile/edit', [AdminController::class, 'editProfile'])->name('myProfile.edit');
                Route::post('my_profile/update', [AdminController::class, 'updateProfile'])->name('myProfile.update');
                Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

                // contract routes
                Route::get('users_by_association/{id}', [UserController::class, 'getAssociationUsers'])
                    ->name('association.getUsers');
                Route::get('Admin_by_association/{id}', [AdminController::class, 'getAssociationAdmin'])
                    ->name('association.getAdmin');


                Route::get('/admin/termsAjax', [\App\Http\Controllers\Admin\ContractTermsController::class, 'getData'])->name('termsAjax.getdata');
                Route::match(['put', 'post'], 'contracts/{id}', [\App\Http\Controllers\Admin\ContractController::class, 'update'])->name('contracts.update');
                Route::get('contracts/add/Excel', [\App\Http\Controllers\Admin\ContractController::class, 'addExcel'])->name('contracts.add.excel');
                Route::post('contracts/store/Excel', [\App\Http\Controllers\Admin\ContractController::class, 'storeExcel'])->name('contracts.store.excel');
                Route::post('contracts/deleteSelected', [\App\Http\Controllers\Admin\ContractController::class, "deleteSelected"])->name('contracts.deleteSelected');
                Route::get("contracts.download/{id}", [\App\Http\Controllers\Admin\ContractController::class, "download"])->name("contracts.download");
                Route::get('contracts/export', [\App\Http\Controllers\Admin\ContractController::class, 'exportExcel'])
                    ->name('contracts.extract');
                Route::post('contracts/updateColumnSelected', [\App\Http\Controllers\Admin\ContractController::class, "updateColumnSelected"])->name('contracts.updateColumnSelected');
                Route::get('/contract-names/{typeId}', [ContractController::class, 'getContractNames'])->name("contrace-names_byType");
                Route::get("association_contracts/create", [\App\Http\Controllers\Admin\ContractController::class, "createByAssociation"])->name("association_contracts.createByAssociation");
                Route::group(["middleware" => "TermsCheckMiddleware"], function () {
                    Route::get('contracts/singlePageCreate', [\App\Http\Controllers\Admin\ContractController::class, "singlePageCreate"])->name('contracts.singlePageCreate');
                    Route::resource("contracts", \App\Http\Controllers\Admin\ContractController::class);
                });


                //                votes routes
                Route::get('/vote/image', [VotesController::class, 'getVoteImage'])->name('votes.getVoteImage');
                Route::get('/vote/getVoteData', [VotesController::class, 'getVoteData'])->name('votes.getVoteData');
                Route::get('/get-users-count/{id}', [VotesController::class, 'getAssociationOwners'])->name('getUserByAssociation');
                Route::get('votes/export', [\App\Http\Controllers\Admin\VotesController::class, 'exportExcel'])
                    ->name('votes.extract');
                Route::get('votes/add/Excel', [\App\Http\Controllers\Admin\VotesController::class, 'addExcel'])->name('votes.add.excel');
                Route::post('votes/store/Excel', [\App\Http\Controllers\Admin\VotesController::class, 'storeExcel'])->name('votes.store.excel');
                Route::get('Votes/singlePageCreate', [\App\Http\Controllers\Admin\VotesController::class, "singlePageCreate"])->name('votes.singlePageCreate');
                Route::post('votes/deleteSelected', [\App\Http\Controllers\Admin\VotesController::class, "deleteSelected"])->name('votes.deleteSelected');
                Route::post('votes/updateColumnSelected', [\App\Http\Controllers\Admin\VotesController::class, "updateColumnSelected"])->name('votes.updateColumnSelected');
                Route::get('votes/revoteShow/{id}',  [\App\Http\Controllers\Admin\VotesController::class, "revoteShow"])->name('votes.revoteShow');
                Route::post('votes/revote/revoting', [\App\Http\Controllers\Admin\VotesController::class, "revote"])->name('votes.revote.revoting');
                Route::post('votes/makeVote', [\App\Http\Controllers\Admin\VotesController::class, "makeVote"])->name('votes.makeVote');
                Route::resource("votes", \App\Http\Controllers\Admin\VotesController::class);
                Route::get("check-votes", [\App\Http\Controllers\Admin\VotesController::class, "checkVotes"])->name("votes.checkVotes");

                // meetings routes 
                // this middleware delete agendas who doesn't have meeting
                Route::group(['middleware' => "AgendaCheckMiddleware"], function () {
                    Route::get('/get-users-meet/{id}', [MeetingController::class, 'getUserMeetByAssociation'])->name('getUserMeetByAssociation');
                    Route::post('meetings/deleteSelected', [\App\Http\Controllers\Admin\MeetingController::class, "deleteSelected"])->name('meetings.deleteSelected');
                    Route::post('meetings/updateColumnSelected', [\App\Http\Controllers\Admin\MeetingController::class, "updateColumnSelected"])->name('meetings.updateColumnSelected');
                    Route::post("meetings/sendNotification/{id}", [\App\Http\Controllers\Admin\MeetingController::class, "sendNotification"])->name("meetings.sendNotification");
                    Route::get("meetings/showDate/{id}", [\App\Http\Controllers\Admin\MeetingController::class, "showDate"])->name("meetings.showDate");
                    Route::get('meetings/export', [\App\Http\Controllers\Admin\MeetingController::class, 'exportExcel'])
                        ->name('meetings.extract');
                    Route::get('meetings/add/Excel', [\App\Http\Controllers\Admin\MeetingController::class, 'addExcel'])->name('meetings.add.excel');
                    Route::post('meetings/store/Excel', [\App\Http\Controllers\Admin\MeetingController::class, 'storeExcel'])->name('meetings.store.excel');
                    Route::get("meetign-owner_by_association/{id}", [\App\Http\Controllers\Admin\MeetingController::class, "getOwners"])->name("meetings.getOwners");
                    Route::get("meetings/singlePageCreate", [\App\Http\Controllers\Admin\MeetingController::class, "singlePageCreate"])->name("meetings.singlePageCreate");
                    Route::get("meetings.download/{id}", [\App\Http\Controllers\Admin\MeetingController::class, "download"])->name("meetings.download");
                    Route::resource("meetings", \App\Http\Controllers\Admin\MeetingController::class);
                });

                Route::put("summary/update", [AdminMeetSummaryController::class, "update"])->name("summary.update");
                Route::resource("meetSummary", AdminMeetSummaryController::class);








                // advanced routes
                Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
                Route::get('get_terms', [\App\Http\Controllers\Admin\SettingController::class, 'termsIndex'])->name('terms.index');
                Route::put('settings', action: [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
                Route::group(['prefix' => 'contracts-setting'], function () {
                    Route::resource('parties', App\Http\Controllers\Admin\ContractPartiesController::class);
                    Route::resource('types', App\Http\Controllers\Admin\ContractTypesController::class);
                    Route::resource('names', App\Http\Controllers\Admin\ContractNamesController::class);
                    Route::resource('terms', App\Http\Controllers\Admin\ContractTermsController::class);
                    Route::resource('dates', App\Http\Controllers\Admin\ContractDateController::class);
                    Route::resource('locations', App\Http\Controllers\Admin\ContractLocationController::class);
                });

                Route::group(['prefix' => 'meetings-setting'], function () {
                    Route::resource('topics', App\Http\Controllers\Admin\TopicController::class);
                    Route::resource('agenda', AgendaController::class);
                });
                Route::get("association-by-id/{id}", [AssociationController::class, "getAssociationById"])->name("association.byId");
                Route::get('/admin/agendaAjax', [AgendaController::class, 'getData'])->name('agendaAjax.getdata');
                Route::get('activity_logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity_logs.index');
                Route::delete('activity_logs/{id}', [\App\Http\Controllers\Admin\ActivityLogController::class, 'destroy'])->name('activity_logs.destroy');
                Route::get('activity_logs_delete_all', [\App\Http\Controllers\Admin\ActivityLogController::class, 'deleteAll'])->name('activity_logs.delete_all');
                Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class)->except(['show']);
                Route::resource('legal_ownerships', \App\Http\Controllers\Admin\LegalOwnershipController::class);
                Route::resource('association_models', \App\Http\Controllers\Admin\AssociationModelController::class);
                Route::post('association_models/updateColumnSelected', [\App\Http\Controllers\Admin\AssociationModelController::class, "updateColumnSelected"])->name('association_models.updateColumnSelected');
                Route::post('association_models/deleteSelected', [\App\Http\Controllers\Admin\AssociationModelController::class, "deleteSelected"])->name('association_models.deleteSelected');

                Route::get('associations/add/Excel', [AssociationController::class, 'addExcel'])->name('association.add.excel');
                Route::get('real_states/add/Excel', [RealStateController::class, 'addExcel'])->name('real_state.add.excel');
                Route::get('units/add/Excel', [UnitController::class, 'addExcel'])->name('unit.add.excel');
                Route::post('associations/store/Excel', [AssociationController::class, 'storeExcel'])->name('associations.store.excel');
                Route::post('real_states/store/Excel', [RealStateController::class, 'storeExcel'])->name('real_states.store.excel');
                Route::post('units/store/Excel', [UnitController::class, 'storeExcel'])->name('units.store.excel');

                Route::get('real-states/export', [RealStateController::class, 'exportExcel'])
                    ->name('real_states.export');
                Route::get('associations/export', [AssociationController::class, 'exportExcel'])
                    ->name('associations.export');
                Route::get('units/export', [UnitController::class, 'exportExcel'])
                    ->name('units.export');



                Route::get('users/singlePageCreate', [\App\Http\Controllers\Admin\UserController::class, "singlePageCreate"])->name('users.singlePageCreate');

                Route::get('/generate-password/{id}', [UserController::class, 'showGenerateForm'])
                    ->name('password.generate');

                Route::post('/generate-password', [UserController::class, 'passwordStore'])
                    ->name('password.store');

                Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
                Route::get("get-user-by-id/{id}", [UserController::class, "getUserById"])->name("users.get.by.id");


                // allow user to set its own password
                Route::get('/admin/generate-password/{id}', [AdminController::class, 'showGenerateForm'])
                    ->name('admin.password.generate');

                Route::post('/admin/generate-password', [AdminController::class, 'passwordStore'])
                    ->name('admin.password.store');


                Route::post('users/updateColumnSelected', [\App\Http\Controllers\Admin\UserController::class, "updateColumnSelected"])->name('users.updateColumnSelected');
                Route::post('users/deleteSelected', [\App\Http\Controllers\Admin\UserController::class, "deleteSelected"])->name('users.deleteSelected');


                //                Route::get('/units/editOwners/showEdit', [\App\Http\Controllers\Admin\UnitController::class, 'editOwners'])->name('units.editOwners');

                Route::get('units/editOwners/{id}', [\App\Http\Controllers\Admin\UnitController::class, 'editOwners'])
                    ->name('units.editOwners');
                Route::post('units/updateColumnSelected', [\App\Http\Controllers\Admin\UnitController::class, "updateColumnSelected"])->name('units.updateColumnSelected');
                Route::post('units/deleteSelected', [\App\Http\Controllers\Admin\UnitController::class, "deleteSelected"])->name('units.deleteSelected');

                Route::post(
                    'units/{id}/updateOwners',
                    [\App\Http\Controllers\Admin\UnitController::class, 'updateOwners']
                )
                    ->name('units.updateOwners');

                Route::get('units/{id}/owners', [UnitController::class, 'unitOwners'])->name('units.unitOwners');
                Route::get('units/{id}/ownersByUnit', [UnitController::class, 'unitOwnersByUnit'])->name('units.unitOwnersByUnit');

                Route::get('units/get-realstates', [UnitController::class, 'getRealState'])->name('units.getRealState');
                Route::post('real_states/updateColumnSelected', [\App\Http\Controllers\Admin\RealStateController::class, "updateColumnSelected"])->name('real_states.updateColumnSelected');
                Route::post('real_states/StopReason', [\App\Http\Controllers\Admin\RealStateController::class, "StopReason"])->name('real_states.StopReason');
                Route::post('associations/StopReason', [\App\Http\Controllers\Admin\AssociationController::class, "stopReason"])->name('associations.StopReason');
                Route::post('units/StopReason', [\App\Http\Controllers\Admin\UnitController::class, "stopReason"])->name('units.StopReason');
                Route::post('real_states/deleteSelected', [\App\Http\Controllers\Admin\RealStateController::class, "deleteSelected"])->name('real_states.deleteSelected');
                Route::get('associations/singlePageCreate', [\App\Http\Controllers\Admin\AssociationController::class, 'singleCreate'])->name('associations.singlePageCreate');
                Route::get('association/real_statesOwnerShip/{id}', [\App\Http\Controllers\Admin\AssociationController::class, 'real_statesOwwnerShip'])->name('association.real_statesOwnerShip.show');
                Route::get('association/unitsTableOwnerShip/{id}', [\App\Http\Controllers\Admin\AssociationController::class, 'unitsTableOwnerShip'])->name('association.unitsTableOwnerShip.show');
                Route::get('association/images/{id}', [\App\Http\Controllers\Admin\AssociationController::class, 'imagesShow'])->name('association.images.show');
                Route::post('associations/delete_images', [\App\Http\Controllers\Admin\AssociationController::class, "associationDeleteImages"])->name('associationImages.delete');
                Route::get('association/files/{id}', [\App\Http\Controllers\Admin\AssociationController::class, 'filesShow'])->name('association.files.show');
                Route::post('associations/delete_files', [\App\Http\Controllers\Admin\AssociationController::class, "associationDeleteFiles"])->name('associationfiles.delete');

                Route::resource('associations', \App\Http\Controllers\Admin\AssociationController::class);
                Route::post('associations/updateColumnSelected', [\App\Http\Controllers\Admin\AssociationController::class, "updateColumnSelected"])->name('associations.updateColumnSelected');
                Route::post('associations/deleteSelected', [\App\Http\Controllers\Admin\AssociationController::class, "deleteSelected"])->name('associations.deleteSelected');
                Route::get('search_association', [\App\Http\Controllers\Admin\AssociationController::class, "search_association"])->name('search_association');


                Route::get('association/real_states', [\App\Http\Controllers\Admin\AssociationController::class, "realStates"])->name('association.real_states');
                Route::get('association/real_states/show', [\App\Http\Controllers\Admin\AssociationController::class, "realStates"])->name('association.real_states.show');
                Route::get('association/units/show/{id}', [\App\Http\Controllers\Admin\AssociationController::class, "units"])->name('association.units.show');
                //                Route::get('association/units/details/{id}', [\App\Http\Controllers\Admin\AssociationController::class, "unitData"])->name('association.units.show');

                Route::get('association/units/getData/{id}', [AssociationController::class, "unitData"])->name('association.units.getData');
                Route::get('real_state/{id}/owners', [RealStateController::class, 'RealStateOwners'])->name('realState.owners');
                Route::get('units/get-realstates', [UnitController::class, 'getRealState'])->name('units.getRealState');
                Route::post('real_states/updateColumnSelected', [\App\Http\Controllers\Admin\RealStateController::class, "updateColumnSelected"])->name('real_states.updateColumnSelected');
                Route::post('real_states/deleteSelected', [\App\Http\Controllers\Admin\RealStateController::class, "deleteSelected"])->name('real_states.deleteSelected');
                //                don't change this three routes order ok ? ******************
                Route::get('associations/singlePageCreate', [\App\Http\Controllers\Admin\AssociationController::class, 'singleCreate'])->name('associations.singlePageCreate');
                Route::resource('associations', \App\Http\Controllers\Admin\AssociationController::class);
                Route::post('associations/updateColumnSelected', [\App\Http\Controllers\Admin\AssociationController::class, "updateColumnSelected"])->name('associations.updateColumnSelected');
                Route::post('associations/storeSinglePageCreate', [\App\Http\Controllers\Admin\AssociationController::class, "storeSinglePageCreate"])->name('associations.storeSinglePageCreate');

                Route::get('association/real_states', [\App\Http\Controllers\Admin\AssociationController::class, "realStates"])->name('association.real_states');
                Route::get('association/real_states/show', [\App\Http\Controllers\Admin\AssociationController::class, "realStates"])->name('association.real_states.show');
                // <<<<<<< assoication_module
                // =======
                //  Route::get('search_unit', [\App\Http\Controllers\Admin\UnitController::class, "search_unit"])->name('search_unit');
                Route::get('units/get-realstates', [UnitController::class, 'getRealState'])->name('units.getRealState');
                Route::post('real_states/updateColumnSelected', [\App\Http\Controllers\Admin\RealStateController::class, "updateColumnSelected"])->name('real_states.updateColumnSelected');
                Route::post('real_states/deleteSelected', [\App\Http\Controllers\Admin\RealStateController::class, "deleteSelected"])->name('real_states.deleteSelected');
                Route::get('associations/singlePageCreate', [\App\Http\Controllers\Admin\AssociationController::class, 'singleCreate'])->name('associations.singlePageCreate');
                Route::get('association/real_statesOwwnerShip/{id}', [\App\Http\Controllers\Admin\AssociationController::class, 'real_statesOwwnerShip'])->name('association.real_statesOwwnerShip.show');
                Route::resource('associations', \App\Http\Controllers\Admin\AssociationController::class);
                Route::post('associations/updateColumnSelected', [\App\Http\Controllers\Admin\AssociationController::class, "updateColumnSelected"])->name('associations.updateColumnSelected');
                Route::post('associations/storeSinglePageCreate', [\App\Http\Controllers\Admin\AssociationController::class, "storeSinglePageCreate"])->name('associations.storeSinglePageCreate');
                // Route::get('search_association', [\App\Http\Controllers\Admin\AssociationController::class, "search_association"])->name('search_association');

                Route::get('association/real_states', [\App\Http\Controllers\Admin\AssociationController::class, "realStates"])->name('association.real_states');
                Route::get('association/real_states/show', [\App\Http\Controllers\Admin\AssociationController::class, "realStates"])->name('association.real_states.show');


                Route::get('association/real_states/getData/{id}', [\App\Http\Controllers\Admin\AssociationController::class, "realStateData"])->name('association.real_states.getData');
                Route::get('association/real_states/{id}', [\App\Http\Controllers\Admin\AssociationController::class, 'realStateShow'])->name('association.real_states.show');
                Route::get('association/real_statesOwwnerShip/{id}', [\App\Http\Controllers\Admin\AssociationController::class, 'real_statesOwwnerShip'])->name('association.real_statesOwwnerShip.show');
                Route::get('association/units/{association_id}', [\App\Http\Controllers\Admin\AssociationController::class, 'getUnits'])->name('association.units');


                Route::prefix('association/{id}')->name('real-estate.')->group(function () {
                    Route::get('images', [RealStateController::class, 'showImages'])->name('images');
                    Route::get('documents', [RealStateController::class, 'showDocuments'])->name('documents');
                });
                Route::get('unit/singlePageCreate', [\App\Http\Controllers\Admin\UnitController::class, 'singleCreate'])->name('unit.singlePageCreate');
                Route::resource('Establishment_Real_estateUnit', \App\Http\Controllers\Admin\UnitController::class);
                Route::get('owners_real_state', [\App\Http\Controllers\Admin\UnitController::class, "owners_real_state"])->name('owners_real_state');


                // real state routes
                Route::resource('real_states', \App\Http\Controllers\Admin\RealStateController::class);
                Route::post('real_state/delete_images', [RealStateController::class, "RealStateDeleteImages"])->name('realStateImage.delete');
                Route::get('realState/images/{id}', [RealStateController::class, 'imagesShow'])->name('realState.images.show');
                Route::get('/get-real-states', [RealStateController::class, 'getRealStates'])->name('real-states.get');
                Route::get('real_state/singleCreate', [RealStateController::class, 'singlePageCreate'])->name('real_state.singleCreate');
                Route::post('real_states/updateColumnSelected', [\App\Http\Controllers\Admin\RealStateController::class, "updateColumnSelected"])->name('real_states.updateColumnSelected');
                // real state show
                Route::post('association/delete_images', action: [AssociationController::class, "AssociationDeletefile"])->name('AssociationDeletefile.delete');

                Route::get('real_states/{realStateId}/unitState', [\App\Http\Controllers\Admin\RealStateController::class, "unitState"])->name('real_states.unitState');
                Route::prefix('real-estate/{id}')->name('real-estate.')->group(function () {
                    Route::get('main-information', [RealStateController::class, 'showMainInformation'])->name('main-information');
                    Route::get('property', [RealStateController::class, 'showProperty'])->name('property');
                    Route::get('association', [RealStateController::class, 'showAssociation'])->name('association');

                    Route::get('images', [RealStateController::class, 'showImages'])->name('images');
                    Route::get('documents', [RealStateController::class, 'showDocuments'])->name('documents');
                });
                Route::resource('real_state_owners', \App\Http\Controllers\Admin\RealStateOwnerController::class);
                Route::get('units/create/{id}', [UnitController::class, 'showCreate'])
                    ->name('units.showCreate');

                Route::resource('units', \App\Http\Controllers\Admin\UnitController::class);
                Route::resource('unit_owners', \App\Http\Controllers\Admin\UnitOwnerController::class);
                Route::post('units/delete_images', [UnitController::class, "unitsDeleteImages"])->name('unitImages.delete');
                Route::get('units/images/{id}', [UnitController::class, 'imagesShow'])->name('unitImages.images.show');

                Route::get('/map', function () {
                    return view('map');
                });

                Route::get('/get-real-states', [RealStateController::class, 'getRealStatesByAssociation'])
                    ->name('real_states.byAssociation');

                Route::post('real_states/toggle_status/{id}', [RealStateController::class, "toggleStatus"])->name('real_states.toggle_status');
                Route::get('real_states/get_electrics/{id}', [RealStateController::class, "getElectrics"])->name('real_states.get_electrics');
                Route::get('real_states/get_waters/{id}', [RealStateController::class, "getWaters"])->name('real_states.get_waters');
                Route::post('real_states/createInShow', [RealStateController::class, "createInShow"])->name('real_states.createInShow');
                Route::post('units/createInShow', action: [unitController::class, "createInShow"])->name('units.createInShow');
                Route::get('units/get_electrics/{id}', [unitController::class, "getElectrics"])->name('units.get_electrics');
                Route::get('units/get_waters/{id}',  [unitController::class, "getWaters"])->name('units.get_waters');

                Route::get('/get-real-states', [RealStateController::class, 'getRealStatesByAssociation'])->name('real_states.byAssociation');

                Route::post('real_states/toggle_status/{id}', [RealStateController::class, "toggleStatus"])->name('real_states.toggle_status');
                Route::post('real_states/createInShow', [RealStateController::class, "createInShow"])->name('real_states.createInShow');
                Route::post('units/createInShow', [unitController::class, "createInShow"])->name('units.createInShow');

                Route::get('media/create', [MediaController::class, 'create'])->name('media.create');
                Route::post('media/store', [MediaController::class, 'store'])->name('media.store');


                //add_electrics_to_real_state
                Route::get('create_electrics_to_real_state/{id}', [RealStateController::class, 'createElectricsToRealState'])->name('real_state.create_electrics.create');
                Route::get('edit_electrics_to_real_state/{id}', [RealStateController::class, 'editElectricsToRealState'])->name('real_state.electrics.edit');
                Route::post('store_electrics_to_real_state', [RealStateController::class, 'storeElectricsToRealState'])->name('real_state.electrics.store');
                Route::put('update_electrics_to_real_state/{id}', [RealStateController::class, 'updateElectricsToRealState'])->name('real_state.electrics.update');
                Route::delete('real_state/delete_electrics/{id}', [RealStateController::class, 'deleteElectrics'])->name('real_state.electrics.delete');
                Route::post('real_state/delete_electrics', [RealStateController::class, 'deleteSelectedElectricsOrWaters'])->name('real_state.electrics.or.waters.delete.selected');

                Route::get('create_waters_to_real_state/{id}', [RealStateController::class, 'createWatersToRealState'])->name('real_state.create_waters.create');
                Route::post('store_waters_to_real_state', [RealStateController::class, 'storeWatersToRealState'])->name('real_state.waters.store');
                Route::get('edit_waters_to_real_state/{id}', [RealStateController::class, 'editWatersToRealState'])->name('real_state.waters.edit');
                Route::put('update_waters_to_real_state/{id}', [RealStateController::class, 'updateWatersToRealState'])->name('real_state.waters.update');
                Route::delete('real_state/delete_waters/{id}', [RealStateController::class, 'deleteWaters'])->name('real_state.waters.delete');


                //add_electrics_to_unit
                Route::get('create_electrics_to_unit/{id}', [UnitController::class, 'createElectricsToUnit'])->name('unit.create_electrics.create');
                Route::get('edit_electrics_to_unit/{id}', [UnitController::class, 'editElectricsToUnit'])->name('unit.electrics.edit');
                Route::post('store_electrics_to_unit', [UnitController::class, 'storeElectricsToUnit'])->name('unit.electrics.store');
                Route::put('update_electrics_to_unit/{id}', [UnitController::class, 'updateElectricsToUnit'])->name('unit.electrics.update');
                Route::delete('unit/delete_electrics/{id}', [UnitController::class, 'deleteElectrics'])->name('unit.electrics.delete');
                Route::post('unit/delete_electrics', [UnitController::class, 'deleteSelectedElectricsOrWaters'])->name('unit.electrics.or.waters.delete.selected');

                Route::get('create_waters_to_unit/{id}', [UnitController::class, 'createWatersToUnit'])->name('unit.create_waters.create');
                Route::post('store_waters_to_unit', [UnitController::class, 'storeWatersToUnit'])->name('unit.waters.store');
                Route::get('edit_waters_to_unit/{id}', [UnitController::class, 'editWatersToUnit'])->name('unit.waters.edit');
                Route::put('update_waters_to_unit/{id}', [UnitController::class, 'updateWatersToUnit'])->name('unit.waters.update');
                Route::delete('unit/delete_waters/{id}', [UnitController::class, 'deleteWaters'])->name('unit.waters.delete');



                Route::get('users/add/Excel', [UserController::class, 'addExcel'])->name('users.add.excel');
                Route::post('users/store/Excel', [UserController::class, 'storeExcel'])->name('users.store.excel');



                Route::get('real_state/electric/water/add/Excel', [RealStateController::class, 'addExcelElectricOrWater'])->name('real_state.add.electric_or_water.excel');
                Route::post('real_state/electric/water/store/Excel', [RealStateController::class, 'storeExcelElectricOrWater'])->name('real_state.store.electric_or_water.excel');

                Route::get('unit/electric/water/add/Excel', [UnitController::class, 'addExcelElectricOrWater'])->name('unit.add.electric_or_water.excel');
                Route::post('unit/electric/water/store/Excel', [UnitController::class, 'storeExcelElectricOrWater'])->name('unit.store.electric_or_water.excel');


                Route::get('users/export', [UserController::class, 'exportExcel'])
                    ->name('users.export.excel');



                Route::group(['prefix' => "case-setting"] , function(){
                    Route::post("case_type/updateColumnSelected", [CaseTypesController::class , 'updateColumnSelected'])->name("case_type.updateColumnSelected");
                    Route::resource("case_type", CaseTypesController::class);
                    Route::post("Judiciaty_type/updateColumnSelected", [JudiciatyTypesController::class , 'updateColumnSelected'])->name("Judiciaty_type.updateColumnSelected");
                    Route::resource("Judiciaty_type", JudiciatyTypesController::class);
                });


                Route::get('court_case/add/Excel', [\App\Http\Controllers\Admin\CourtCasesController::class, 'addExcel'])->name('court_case.add.excel');
                Route::post('court_case/store/Excel', [\App\Http\Controllers\Admin\CourtCasesController::class, 'storeExcel'])->name('court_case.store.excel');
                Route::get('court_case/export', [\App\Http\Controllers\Admin\CourtCasesController::class, 'exportExcel'])
                    ->name('court_case.extract');
                Route::get("court_case.singlePageCreate", [CourtCasesController::class , 'singlePageCreate'])->name("court_case.singlePageCreate");
                Route::post("court_case/updateColumnSelected", [CourtCasesController::class , 'updateColumnSelected'])->name("court_case.updateColumnSelected");
                Route::resource("court_case", CourtCasesController::class);
                

                Route::resource("case_update_type", CaseUpdateTypeController::class);
                Route::resource("case_update", CaseUpdateController::class);

                
                
                Route::get("users/getUnits/{id}", [UserController::class , "getUnits"])->name("users.getUnits");
                Route::get("association/getUsers/{id}", [AssociationController::class, "getUsers"])->name("association.getUsers");

            });
        });
        #=======================================================================
        #============================ ROOT =====================================
        #=======================================================================
        Route::get('/clear', function () {
            Artisan::call('cache:clear');
            Artisan::call('key:generate');
            Artisan::call('storage:link');
            Artisan::call('config:clear');
            Artisan::call('optimize:clear');
            return response()->json(['status' => 'success', 'code' => 1000000000]);
        });
    }
);
