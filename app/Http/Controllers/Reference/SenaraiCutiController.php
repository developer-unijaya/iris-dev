<?php

namespace App\Http\Controllers\Reference;

use App\Http\Controllers\Controller;
use App\Models\Reference\SenaraiCuti;
use Illuminate\Http\Request;
use App\Models\LogSystem;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Master\MasterModule;

class SenaraiCutiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->module = MasterModule::where('code', 'admin.reference.senaraicuti')->first();
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

        $senaraicuti = SenaraiCuti::all();
        if ($request->ajax()) {

            $log = new LogSystem;
            $log->module_id = MasterModule::where('code', 'admin.reference.senaraicuti')->firstOrFail()->id;
            $log->activity_type_id = 1;
            $log->description = "Lihat Senarai SenaraiCuti";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            return Datatables::of($senaraicuti)
                ->editColumn('kod', function ($senaraicuti){
                    return $senaraicuti->kod;
                })
                ->editColumn('nama', function ($senaraicuti) {
                    return $senaraicuti->nama;
                })
                ->editColumn('action', function ($senaraicuti) use ($accessDelete) {
                    $button = "";

                    $button .= '<div class="btn-group btn-group-sm d-flex justify-content-center" role="group" aria-label="Action">';
                    // //$button .= '<a onclick="getModalContent(this)" data-action="'.route('role.edit', $roles).'" type="button" class="btn btn-xs btn-default"> <i class="fas fa-eye text-primary"></i> </a>';
                    $button .= '<a href="javascript:void(0);" class="btn btn-xs btn-default" onclick="senaraicutiForm('.$senaraicuti->id.')"> <i class="fas fa-pencil text-primary"></i> ';
                    if($accessDelete){
                        if($senaraicuti->sah_yt) {
                            $button .= '<a href="#" class="btn btn-sm btn-default deactivate" data-id="'.$senaraicuti->id.'" onclick="toggleActive('.$senaraicuti->id.')"> <i class="fas fa-toggle-on text-success fa-lg"></i> </a>';
                        } else {
                            $button .= '<a href="#" class="btn btn-sm btn-default activate" data-id="'.$senaraicuti->id.'" onclick="toggleActive('.$senaraicuti->id.')"> <i class="fas fa-toggle-off text-danger fa-lg"></i> </a>';
                        }
                    }
                    $button .= '</div>';

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.reference.senarai_cuti', compact('accessAdd', 'accessUpdate', 'accessDelete'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'code' => 'required|string|unique:ruj_senarai_cuti,kod',
                'name' => 'required|string',
                'kategori' => 'required|string',
            ],[
                'code.required' => 'Sila isikan kod',
                'code.unique' => 'Kod telah diambil',
                'name.required' => 'Sila isikan cuti',
                'kategori.required' => 'Sila isikan kategori',
            ]);

            $senaraicuti = SenaraiCuti::create([
                'kod' => $request->code,
                'nama' => strtoupper($request->name),
                'kategori' => strtoupper($request->kategori),
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            $log = new LogSystem;
            $log->module_id = MasterModule::where('code', 'admin.reference.senaraicuti')->firstOrFail()->id;
            $log->activity_type_id = 3;
            $log->description = "Tambah Senarai Cuti";
            $log->data_new = json_encode($senaraicuti);
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

            $senaraicuti = SenaraiCuti::find($request->senaraicutiId);

            if (!$senaraicuti) {
                return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            }
            $log = new LogSystem;
            $log->module_id = MasterModule::where('code', 'admin.reference.senaraicuti')->firstOrFail()->id;
            $log->activity_type_id = 2;
            $log->description = "Lihat Maklumat Senarai Cuti";
            $log->data_new = json_encode($senaraicuti);
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            DB::commit();

            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $senaraicuti]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

            $senaraicutiId = $request->senaraicutiId;
            $senaraicuti = SenaraiCuti::find($senaraicutiId);

            $log = new LogSystem;
            $log->module_id = MasterModule::where('code', 'admin.reference.senaraicuti')->firstOrFail()->id;
            $log->activity_type_id = 4;
            $log->description = "Kemaskini Maklumat Senarai Cuti";
            $log->data_old = json_encode($senaraicuti);

            $request->validate([
                'code' => 'required|string|unique:ruj_senarai_cuti,kod,'.$senaraicutiId,
                'name' => 'required|string',
                'kategori' => 'required|string',
            ],[
                'code.required' => 'Sila isikan kod',
                'code.unique' => 'Kod telah diambil',
                'name.required' => 'Sila isikan cuti',
                'kategori.required' => 'Sila isikan kategori',
            ]);

            $senaraicuti->update([
                'kod' => $request->code,
                'nama' => strtoupper($request->name),
                'kategori' => strtoupper($request->kategori),
                'updated_by' => auth()->user()->id,
            ]);

            $senaraicutiNewData = senaraicuti::find($senaraicutiId);
            $log->data_new = json_encode($senaraicutiNewData);
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

            $senaraicutiId = $request->senaraicutiId;
            $senaraicuti = SenaraiCuti::find($senaraicutiId);

            $sah_yt = $senaraicuti->sah_yt;

            $senaraicuti->update([
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
