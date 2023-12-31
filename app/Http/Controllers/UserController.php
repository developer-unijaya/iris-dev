<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reference\DepartmentMinistry;
use App\Models\Reference\Skim;
use App\Models\LogSystem;
use App\Models\Master\MasterModule;
use App\Models\Master\MasterActivityType;
use App\Notifications\NewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Throwable;
use Yajra\DataTables\DataTables;
use Mail;
use App\Mail\Auth\RegisterUser;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->moduleInternal = MasterModule::where('code', 'admin.internalUser')->first();
        $this->menuInternal = $this->moduleInternal->menu;
        $this->moduleExternal= MasterModule::where('code', 'admin.externalUser')->first();
        $this->menuExternal = $this->moduleExternal->menu;
    }

    public function index(Request $request)
    {
        $roles = auth()->user()->roles;
        $roles = $roles->pluck('id')->toArray();

        if (request()->route()->getname() == 'admin.internalUser') {
            $accessRole = $this->menuInternal->role()->whereIn('id', $roles)->get();
        } else if(request()->route()->getname() == 'admin.externalUser'){
            $accessRole = $this->menuExternal->role()->whereIn('id', $roles)->get();
        }

        $accessAdd = $accessUpdate = $accessDelete = false;

        foreach($accessRole as $access) {
            if($access->pivot->add){
                $accessAdd = true;
            }

            if($access->pivot->update){
                $accessUpdate = true;
            }

            if($access->pivot->delete){
                $accessDelete = true;
            }
        }

        $departmentMinistry = DepartmentMinistry::where('sah_yt', 1)->orderBy('nama', 'asc')->get();
        $skim = Skim::all();

        if(request()->route()->getname() == 'admin.internalUser' || request()->route()->getname() == 'admin.externalUser'){
            if ($request->ajax()) {
                if (request()->route()->getname() == 'admin.internalUser') {
                    $users = User::whereHas('roles', function ($query) {
                        $query->where('is_internal', 1);
                    });
                    $type = 'internal';
                    $type2 = 'Dalaman';
                    $code = 'admin.internalUser';
                } else if(request()->route()->getname() == 'admin.externalUser'){
                    $users = User::whereHas('roles', function ($query) {
                        $query->where('is_internal', 0);
                    });
                    $type = 'external';
                    $type2 = 'Luaran';
                    $code = 'admin.externalUser';
                }

                $log = new LogSystem;
                $log->module_id = MasterModule::where('code', $code)->firstOrFail()->id;
                $log->activity_type_id = 1;
                $log->description = "Lihat Senarai Pengguna ".$type2;
                $log->data_old = json_encode($request->input());
                $log->url = $request->fullUrl();
                $log->method = strtoupper($request->method());
                $log->ip_address = $request->ip();
                $log->created_by_user_id = auth()->id();
                $log->save();

                if($request->name){
                    $users->where('name', 'like', '%' . $request->name . '%');
                }
                if($request->no_ic){
                    $users->where('no_ic', 'like', '%' . $request->no_ic . '%');
                }
                if($request->role){
                    $users->whereHas('roles', function ($query) use ($request) {
                        $query->where('id', $request->role);
                    });

                }
                if($request->department_ministry){
                    $users->whereHas('department_ministry', function ($query) use ($request) {
                        $query->where('kod', $request->department_ministry);
                    });
                }
                if($request->skim){
                    $users->whereHas('skim', function ($query) use ($request) {
                        $query->where('code', $request->skim);
                    });
                }

                return Datatables::of($users->get())
                    ->editColumn('name', function ($users) use ($type) {

                        if ($type == "internal") {
                            $label = "";
                            $label .= '<a href=" ' . route('user.show', $users) . ' " class="btn btn-xs btn-default text-primary" style="width:100%">';
                            $label .= $users->name;
                            $label .= '</a>';
                            return $label;
                        } else {
                            $label = "";
                            $label .= '<a href=" ' . route('user.show', $users) . ' " class="btn btn-xs btn-default text-primary" style="width:100%">';
                            $label .= $users->name;
                            $label .= '</a>';
                            return $label;
                        }
                    })
                    ->editColumn('username', function ($users) use ($type) {
                        return $users->no_ic;
                    })
                    ->editColumn('department_ministry', function ($users) use ($type) {
                        return ($users->ref_department_ministry_code != null) ? $users->department_ministry->nama : null;
                    })
                    ->editColumn('skim', function ($users) use ($type) {
                        return ($users->ref_skim_code != null) ? $users->skim->name : null;
                    })
                    ->editColumn('role', function ($users) use ($type) {

                        $roles = implode(",", $users->getRoleNames()->toArray());
                        $role_label = '</br>';
                        $role_label .= '<td>';
                        if (strpos($roles, "admin") !== false && strpos($roles, "superadmin") !== false) {
                            $role_label .= '<span class="badge rounded-pill bg-light-info">Superadmin</span> &nbsp; <span class="badge rounded-pill bg-light-secondary">Admin</span>';
                        } elseif ($roles == "admin") {
                            $role_label .= '<span class="badge rounded-pill bg-light-secondary">Admin</span>';
                        } elseif ($roles == "superadmin") {
                            $role_label .= '<span class="badge rounded-pill bg-light-info">Superadmin</span>';
                        } else {
                            $role_label .= '<span class="badge rounded-pill bg-light-info">' . $roles . '</span> &nbsp;';
                        }
                        $role_label .= "</td>";

                        return $role_label;
                    })
                    ->editColumn('action', function ($users) use ($type, $accessDelete) {
                        $button = "";

                        $button .= '<div class="btn-group btn-group-sm d-flex justify-content-center" role="group" aria-label="Action">';
                        if ($type == "internal") {
                            //$button .= '<a href=" '.route('user.show', $users).' " class="btn btn-xs btn-default"> <i class="fas fa-eye text-primary"></i> </a>';
                            $button .= '<a href="javascript:void(0);" class="btn btn-xs btn-default" onclick="viewUserForm(' . $users->id . ')"> <i class="fas fa-pencil text-primary"></i> ';
                            // $button .= '<form id="formDestroyUser_'.$user->id.'" method="POST" action=" '.route('user.destroy', $user).' "> @csrf <input type="hidden" name="_method" value="DELETE"/> </form>';
                            // $button .= '<a href="#" class="btn btn-outline-dark waves-effect" onclick="event.preventDefault(); document.getElementById('formDestroyUser_. $user->id .').submit();"> <i class="fas fa-trash"></i> </a>';
                        } else {
                            //$button .= '<a href=" '.route('user.show', $users).' " class="btn btn-xs btn-default"> <i class="fas fa-eye text-primary"></i> </a>';
                            $button .= '<a href="javascript:void(0);" class="btn btn-xs btn-default" onclick="viewUserForm(' . $users->id . ')"> <i class="fas fa-pencil text-primary"></i> ';
                        }
                        $button .= "</div>";

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }
        if (request()->route()->getname() == 'admin.internalUser') {
            $users = User::whereHas('roles', function ($query) {
                $query->where('is_internal', 1);
            });
            $is_internal = 1;
            $type = 'internal';
            $route = 'admin.internalUser';
        } else {
            $users = User::whereHas('roles', function ($query) {
                $query->where('is_internal', 0);
            });
            $is_internal = 0;
            $type = 'external';
            $route = 'admin.externalUser';
        }

        $totalUser = clone $users;
        $totalUser = $totalUser->count();

        $inactiveUser = clone $users;
        $inactiveUser = $inactiveUser->where('is_active', 0)->count();

        $activeUser = $totalUser - $inactiveUser;

        $role = Role::where('is_internal', $is_internal)->get();

        $externalUsers = Role::where('is_internal', 0)->get();
        $internalUsers = Role::where('is_internal', 1)->get();

        return view('admin.user.index', compact('type', 'role', 'totalUser', 'inactiveUser', 'activeUser', 'externalUsers', 'internalUsers', 'departmentMinistry', 'skim' ,'route', 'accessAdd', 'accessUpdate', 'accessDelete'));
    }

    public function create(Request $request)
    {
        $type = $request->type;
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.user.create', compact('roles', 'permissions', 'type'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'ic_number' => 'required|min_digits:12|unique:users,no_ic',
                'full_name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'phone_number' => 'required',
                'department_ministry_code' => 'required|exists:ruj_kem_jabatan,kod',
                'skim_code' => 'required|exists:ruj_skim,code',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',
                    'confirmed',
                ],
                'roles' => 'required',
            ],[
                'ic_number.required' => 'Sila isikan no kad pengenalan',
                'ic_number.unique' => 'No kad pengenalan telah diambil',
                'ic_number.min_digits' => 'No kad pengenalan mestilah sekurang-kurangnya 12 aksara',
                'full_name.required' => 'Sila isikan nama penuh',
                'email.required' => 'Sila isikan emel',
                'email.unique' => 'Emel telah diambil',
                'phone_number.required' => 'Sila isikan no telefon',
                'department_ministry_code.required' => 'Sila pilih nama kementerian',
                'department_ministry_code.exists' => 'Nama kementerian tidak sah',
                'skim_code.required' => 'Sila pilih jawatan',
                'skim_code.exists' => 'Jawatan tidak sah',
                'password.required' => 'Sila isikan kata laluan',
                'password.min' => 'Kata laluan mestilah sekurang-kurangnya 8 aksara',
                'password.regex' => 'Kata laluan tidak sah',
                'password.confirmed' => 'Pengesahan kata laluan tidak sepadan',
                'roles.required' => 'Sila pilih peranan',

            ]);

            $user = User::create([
                'name' => $request->full_name,
                'no_ic' => $request->ic_number,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'ref_department_ministry_code' => $request->department_ministry_code,
                'ref_skim_code' => $request->skim_code,
                'is_active' => $request->has("status") ?? 0,
                'password' => Hash::make($request->password),
            ]);

            $user->syncRoles($request->roles ? $request->roles : []);
            // $user->syncPermissions($request->permissions ? $request->permissions : []);

            //For Audi Trail
            $userNewData = User::with(['department_ministry', 'skim', 'roles'])->find($user->id);

            $code = $request->route;

            $log = new LogSystem;
            $log->module_id = MasterModule::where('code', $code)->firstOrFail()->id;
            $log->activity_type_id = 3;
            $log->description = "Tambah Pengguna [" . $userNewData->name . "]";
            $log->data_new = json_encode($userNewData);
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            if ($user) {
                Mail::to($user->email)->send(new RegisterUser($user, $request->password));
            }

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        DB::commit();
        return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);
    }

    public function show(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $departments = DepartmentMinistry::where('sah_yt', 1)->orderBy('nama', 'asc')->get();
        $skims = Skim::all();

        $internalRoleArr = Role::where('is_internal', 1)->pluck('name')->toArray();
        if ($user->role($internalRoleArr)) {
            $type = "internal";
        } else {
            $type = "external";
        }
        return view('admin.user.user_information.user_information', compact('user', 'roles', 'skims', 'departments', 'permissions', 'type'));
    }

    public function edit(User $user, $userId)
    {
        $roles = Role::all();
        $permissions = Permission::all();

        $internalRoleArr = Role::where('is_internal', 1)->pluck('name')->toArray();
        if ($user->role($internalRoleArr)) {
            $type = "internal";
        } else {
            $type = "external";
        }
        // return view('admin.user.edit', compact('user', 'roles', 'permissions','type'));
        return view('admin.user.index', compact('user', 'roles', 'permissions', 'type'));
    }

    public function update(Request $request, $id_used)
    {
        DB::beginTransaction();
        try {

            $validatedData = $request->validate([
                'ic_number' => 'required|integer|min_digits:12|unique:users,no_ic,'.$id_used,
                'full_name' => 'required|string',
                'email' => 'required|email|unique:users,email,'.$id_used,
                'phone_number' => 'required',
                'department_ministry_code' => 'required|exists:ruj_kem_jabatan,kod',
                'skim_code' => 'required|exists:ref_skim,code',
                'roles' => 'required',
            ],[
                'ic_number.required' => 'Sila isikan no kad pengenalan',
                'ic_number.unique' => 'No kad pengenalan telah diambil',
                'ic_number.min_digits' => 'No kad pengenalan mestilah sekurang-kurangnya 12 aksara',
                'full_name.required' => 'Sila isikan nama penuh',
                'email.required' => 'Sila isikan emel',
                'email.unique' => 'Emel telah diambil',
                'phone_number.required' => 'Sila isikan no telefon',
                'department_ministry_code.required' => 'Sila pilih nama kementerian',
                'department_ministry_code.exists' => 'Nama kementerian tidak sah',
                'skim_code.required' => 'Sila pilih jawatan',
                'skim_code.exists' => 'Jawatan tidak sah',
                'roles.required' => 'Sila pilih peranan',

            ]);

            $user = User::with(['department_ministry', 'skim', 'roles'])->find($id_used);

            $code = $request->route;

            $log = new LogSystem;
            $log->module_id = MasterModule::where('code', $code)->firstOrFail()->id;
            $log->activity_type_id = 4;
            $log->description = "Kemaskini Maklumat Pengguna [".$user->name."]";
            $log->data_old = json_encode($user);
            
            $user->update([
                'name' => $request->full_name,
                'no_ic' => $request->ic_number,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'ref_department_ministry_code' => $request->department_ministry_code,
                'ref_skim_code' => $request->skim_code,
                'is_active' => $request->has("status") ?? 0,
            ]);

            $user->syncRoles($request->roles ? $request->roles : []);

            //For Audit Trail
            $userNewData = User::with(['department_ministry', 'skim', 'roles'])->find($user->id);

            $log->data_new = json_encode($userNewData);
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        //return to_route('user.index', [$user]);
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return redirect()->route('user.index');
    }

    public function getUser(Request $request, User $userId)
    {
        $user = User::with(['department_ministry', 'skim', 'roles'])->find($userId->id);

        DB::beginTransaction();
        try {

            $code = $request->route;

            $log = new LogSystem;
            $log->module_id = MasterModule::where('code', $code)->firstOrFail()->id;
            $log->activity_type_id = 2;
            $log->description = "Lihat Maklumat Pengguna [".$user->name."]";
            $log->data_old = $user;
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $user->listOfRole = $user->roles->pluck('id')->toArray();

            if (!$user) {
                return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Module Role not found. Please refresh"], 404);
            }

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        DB::commit();
        return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $user]);
    }

    public function updatePassword(Request $request)
    {

        // dd($request->all());
        \DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'reset_password_old' => 'required|string|min:8',
                'reset_password_new' => 'required|string|min:8',
                'reset_password_confirm' => 'required|same:reset_password_new',
                'captcha' => 'required|captcha',
            ], [
                'reset_password_old.required' => 'Please fill in current password',
                'reset_password_new.required' => 'Please fill in new password',
                'reset_password_confirm.required' => 'Please retype new password',
                'captcha.required' => 'Please enter captcha',
                'captcha' => 'CAPTCHA validation failed, try again.',
            ]);

            if (Hash::check($request->reset_password_old, auth()->user()->password)) {

                User::whereId(auth()->user()->id)->update(['password' => Hash::make($request->reset_password_new)]);
                $user = auth()->user();

            } else {
                return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => 'Wrong Current Password'], 404);
            }

        } catch (Throwable $e) {

            \DB::rollBack();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        \DB::commit();
        return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);
    }
}
