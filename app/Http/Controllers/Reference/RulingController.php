<?php

namespace App\Http\Controllers\Reference;

use App\Http\Controllers\Controller;
use App\Models\LogSystem;
use App\Models\Reference\Ruling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Master\MasterModule;

class RulingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->module = MasterModule::where('code', 'admin.reference.ruling')->first();
        $this->menu = $this->module->menu;
    }

    public function index(Request $request)
    {
        $roles = auth()->user()->roles;
        $roles = $roles->pluck('id')->toArray();

        $accessRole = $this->menu->role()->whereIn('id', $roles)->get();

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

        $ruling = Ruling::all();
        if ($request->ajax()) {

            $log = new LogSystem;
            $log->module_id = MasterModule::where('code', 'admin.reference.ruling')->firstOrFail()->id;
            $log->activity_type_id = 1;
            $log->description = "Lihat Senarai Ruling";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            return Datatables::of($ruling)
                ->editColumn('kod', function ($ruling){
                    return $ruling->kod;
                })
                ->editColumn('nama', function ($ruling) {
                    return $ruling->nama;
                })
                ->editColumn('pernyataan', function ($ruling) {
                    return $ruling->pernyataan;
                })
                ->editColumn('status', function ($ruling) {
                    return $ruling->status;
                })
                ->editColumn('action', function ($ruling) use ($accessDelete) {
                    $button = "";

                    $button .= '<div class="btn-group btn-group-sm d-flex justify-content-center" role="group" aria-label="Action">';
                    // //$button .= '<a onclick="getModalContent(this)" data-action="'.route('role.edit', $roles).'" type="button" class="btn btn-xs btn-default"> <i class="fas fa-eye text-primary"></i> </a>';
                    $button .= '<a href="javascript:void(0);" class="btn btn-xs btn-default" onclick="rulingForm('.$ruling->id.')"> <i class="fas fa-pencil text-primary"></i> ';
                    if($accessDelete){
                        if($ruling->sah_yt) {
                            $button .= '<a href="#" class="btn btn-sm btn-default deactivate" data-id="'.$ruling->id.'" onclick="toggleActive('.$ruling->id.')"> <i class="fas fa-toggle-on text-success fa-lg"></i> </a>';
                        } else {
                            $button .= '<a href="#" class="btn btn-sm btn-default activate" data-id="'.$ruling->id.'" onclick="toggleActive('.$ruling->id.')"> <i class="fas fa-toggle-off text-danger fa-lg"></i> </a>';
                        }
                    }
                    $button .= '</div>';

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.reference.ruling', compact('accessAdd', 'accessUpdate', 'accessDelete'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'code' => 'required|string|unique:ruj_ruling,kod',
                'name' => 'required|string',
                'pernyataan' => 'required|string',
                'status' => 'required|string',
            ],[
                'code.required' => 'Sila isikan kod',
                'code.unique' => 'Kod telah diambil',
                'name.required' => 'Sila isikan ruling',
                'pernyataan' => 'Sila isikan pernyataan',
                'status' => 'Sila isikan status',
            ]);

            $ruling = Ruling::create([
                'kod' => $request->code,
                'nama' => strtoupper($request->name),
                'pernyataan' => strtoupper($request->pernyataan),
                'status' => strtoupper($request->status),
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            $log = new LogSystem;
            $log->module_id = MasterModule::where('code', 'admin.reference.ruling')->firstOrFail()->id;
            $log->activity_type_id = 3;
            $log->description = "Tambah Ruling";
            $log->data_new = json_encode($ruling);
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

    }

    public function edit(Request $request)
    {
        DB::beginTransaction();
        try {

            $ruling = Ruling::find($request->rulingId);

            if (!$ruling) {
                return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            }
            $log = new LogSystem;
            $log->module_id = MasterModule::where('code', 'admin.reference.ruling')->firstOrFail()->id;
            $log->activity_type_id = 2;
            $log->description = "Lihat Maklumat Ruling";
            $log->data_new = json_encode($ruling);
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            DB::commit();

            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $ruling]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

            $rulingId = $request->rulingId;
            $ruling = Ruling::find($rulingId);

            $log = new LogSystem;
            $log->module_id = MasterModule::where('code', 'admin.reference.ruling')->firstOrFail()->id;
            $log->activity_type_id = 4;
            $log->description = "Kemaskini Maklumat Ruling";
            $log->data_old = json_encode($ruling);

            $request->validate([
                'code' => 'required|string|unique:ruj_ruling,kod,'.$rulingId,
                'name' => 'required|string',
                'pernyataan' => 'required|string',
                'status' => 'required|string',
            ],[
                'code.required' => 'Sila isikan kod',
                'code.unique' => 'Kod telah diambil',
                'name.required' => 'Sila isikan ruling',
                'pernyataan' => 'Sila isikan pernyataan',
                'status' => 'Sila isikan status',
            ]);

            $ruling->update([
                'kod' => $request->code,
                'nama' => strtoupper($request->name),
                'pernyataan' => strtoupper($request->pernyataan),
                'status' => strtoupper($request->status),
                'updated_by' => auth()->user()->id,
            ]);

            $rulingNewData = ruling::find($rulingId);
            $log->data_new = json_encode($rulingNewData);
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
    }

    public function toggleActive(Request $request)
    {
        DB::beginTransaction();
        try {

            $rulingId = $request->rulingId;
            $ruling = Ruling::find($rulingId);

            $sah_yt = $ruling->sah_yt;

            $ruling->update([
                'sah_yt' => !$sah_yt,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya", 'success' => true]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }
}
