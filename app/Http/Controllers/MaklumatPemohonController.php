<?php

namespace App\Http\Controllers;

use App\Models\Candidate\CandidateLanguage;
use App\Models\Candidate\CandidateLicense;
use App\Models\Candidate\CandidateMatriculation;
use App\Models\Candidate\CandidateOku;
use App\Models\Candidate\CandidatePsl;
use App\Models\Reference\KodPelbagai;
use App\Models\Reference\Language;
use App\Models\Reference\MatriculationSubject;
use App\Models\Reference\Qualification;
use App\Models\Reference\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Reference\DepartmentMinistry;
use App\Models\Reference\Eligibility;
use App\Models\Reference\Gender;
use App\Models\Reference\GredMatapelajaran;
use App\Models\Reference\Institution;
use App\Models\Reference\JenisBekasTenteraPolis;
use App\Models\Reference\JenisPerkhidmatan;
use App\Models\Reference\MaritalStatus;
use App\Models\Reference\Penalty;
use App\Models\Reference\PeringkatPengajian;
use App\Models\Reference\PositionLevel;
use App\Models\Reference\Rank;
use App\Models\Reference\Race;
use App\Models\Reference\Religion;
use App\Models\Reference\State;
use App\Models\Reference\Skim;
use App\Models\Reference\Subject;
use App\Models\Reference\Specialization;
use App\Models\Candidate\Candidate;
use App\Models\Candidate\CandidateArmyPolice;
use App\Models\Candidate\CandidateExperience;
use App\Models\Candidate\CandidateHigherEducation;
use App\Models\Candidate\CandidatePenalty;
use App\Models\Candidate\CandidateSchoolResult;
use App\Models\Candidate\CandidateSkm;
use App\Models\Candidate\CandidateTalent;
use App\Models\Candidate\CandidateTimeline;
use App\Models\Reference\Matriculation;
use App\Models\Reference\MatriculationCourse;
use Carbon\Carbon;

class MaklumatPemohonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function calonCadangan(Request $request){
        $inputValue = $request->input('input_value');
        $suggestions = Candidate::where(function($query) use ($inputValue) {
            $query->where('no_ic', 'ILIKE', '%' . $inputValue . '%')
                  ->orWhere('no_ic_old', 'ILIKE', '%' . $inputValue . '%')
                  ->orWhere('full_name', 'ILIKE', '%' . $inputValue . '%');
        })->get();

        return response()->json($suggestions);
    }

    public function searchPemohon ()
    {
        $departmentMinistries = DepartmentMinistry::where('sah_yt', 1)->orderBy('nama', 'asc')->get();
        $eligibilities = Eligibility::all();
        $genders = Gender::all();
        $gredPmr = GredMatapelajaran::where('tkt', 3)->orderBy('susunan', 'asc')->get();
        $gredSpm = GredMatapelajaran::where('tkt', 5)->orderBy('susunan', 'asc')->get();
        $gredSpmv = GredMatapelajaran::where('tkt', 5)->orderBy('susunan', 'asc')->get();
        $gredSvm = GredMatapelajaran::where('tkt', 5)->orderBy('susunan', 'asc')->get();
        $gredStpm = GredMatapelajaran::where('tkt', 6)->orderBy('susunan', 'asc')->get();
        $gredStam = GredMatapelajaran::where('tkt', 6)->orderBy('susunan', 'asc')->get();
        $institutions = Institution::orderBy('type', 'asc')->orderBy('name', 'asc')->get();
        $jenisBekasTenteraPolis = JenisBekasTenteraPolis::all();
        $jenisPerkhidmatan = JenisPerkhidmatan::all();
        $maritalStatuses = MaritalStatus::where('sah_yt', 1)->orderBy('nama', 'asc')->get();
        $penalties = Penalty::all();
        $peringkatPengajian = PeringkatPengajian::all();
        $positionLevels = PositionLevel::orderBy('name', 'asc')->get();
        $races = Race::where('sah_yt', 1)->orderBy('nama', 'asc')->get();
        $ranks = Rank::all();
        $religions = Religion::where('sah_yt', 1)->orderBy('nama', 'asc')->get();
        $states = State::where('sah_yt', 1)->orderBy('nama', 'asc')->get();
        $skims = Skim::orderBy('name', 'asc')->get();
        $specializations = Specialization::orderBy('name', 'asc')->get();
        $subjekPmr = Subject::where('form', 3)->orderBy('name', 'asc')->get();
        $subjekSpm = Subject::where('form', 5)->orderBy('name', 'asc')->get();
        $subjekSpmv = Subject::where('form', 5)->orderBy('name', 'asc')->get();
        $subjekSvm = Subject::where('form', 5)->orderBy('name', 'asc')->get();
        $subjekStpm = Subject::where('form', 6)->orderBy('name', 'asc')->get();
        $subjekStam = Subject::where('form', 6)->orderBy('name', 'asc')->get();
        $skmkod = Qualification::orderBy('name', 'asc')->get();
        $talentkod = Talent::orderBy('name', 'asc')->get();
        $kolejMatrikulasi = Matriculation::orderBy('name', 'asc')->get();
        $jurusanMatrikulasi = MatriculationCourse::orderBy('name', 'asc')->get();
        $subjekMatrikulasi =  MatriculationSubject::orderBy('name', 'asc')->get();
        $kategoriOKU = KodPelbagai::where('kategori', 'KECACATAN CALON')->orderBy('nama', 'asc')->get();
        $Bahasa = Language::orderBy('nama', 'asc')->get();
        $kategoriPenguasaan = KodPelbagai::where('kategori', 'PENGUASAAN BAHASA')->orderBy('nama', 'asc')->get();
        $jenisPeperiksaan = Qualification::orderBy('name', 'asc')->get();

        return view('maklumat_pemohon.carian_pemohon', compact('departmentMinistries', 'eligibilities', 'genders', 'gredPmr', 'institutions', 'jenisBekasTenteraPolis', 'jenisPerkhidmatan', 'maritalStatuses', 'penalties', 'peringkatPengajian', 'positionLevels', 'races', 'ranks', 'religions', 'states', 'skims', 'specializations', 'subjekPmr', 'skmkod', 'talentkod', 'gredSpm', 'subjekSpm', 'gredSpmv', 'subjekSpmv', 'gredSvm', 'subjekSvm', 'gredStpm', 'subjekStpm', 'gredStam', 'subjekStam', 'kolejMatrikulasi', 'jurusanMatrikulasi', 'subjekMatrikulasi', 'kategoriOKU', 'Bahasa', 'kategoriPenguasaan', 'jenisPeperiksaan' ));
    }

    public function viewMaklumatPemohon(){
        return view('maklumat_pemohon.index_pemohon');
    }

    public function getCandidateDetails(Request $request)
    {
        $no_ic = $request->no_ic;

        DB::beginTransaction();
        try {

            $candidate = Candidate::where(function ($query) use ($no_ic) {
                $query->where('no_ic', $no_ic)->orWhere('no_ic_old', $no_ic);
            })
            ->with([
                'license',
                'oku',
                'skim' => function ($query) {
                    $query->with(['skim', 'interviewCentre']);
                },
                'matriculation' => function ($query) {
                    $query->with(['course', 'college', 'subject']);
                },
                'skm' => function ($query) {
                    $query->with(['qualification']);
                },
                'higherEducation' => function ($query) {
                    $query->with(['institution', 'eligibility', 'specialization']);
                },
                'professional' => function ($query) {
                    $query->with(['specialization']);
                },
                'experience',
                'psl' => function ($query) {
                    $query->with(['qualification']);
                },
                'armyPolice' => function ($query) {
                    $query->with(['rank']);
                },
                'language' => function ($query) {
                    $query->with(['language']);
                },
                'talent' => function ($query) {
                    $query->with(['talent']);
                },
                'penalty' => function ($query) {
                    $query->with(['penalty']);
                },
                'timeline',
            ])->first();

            if(!$candidate) {
                return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            }

            $candidate->date_of_birth = Carbon::parse($candidate->date_of_birth)->format('d/m/Y');

            if($candidate->license){
                $candidate->license->expiry_date = ($candidate->license->expiry_date != null) ? Carbon::parse($candidate->license->expiry_date)->format('d/m/Y') : null;
            }

            foreach($candidate->skim as $skim){
                $skim->register_date = ($skim->register_date != null) ? Carbon::parse($skim->register_date)->format('d/m/Y') : null;
                $skim->expiry_date = ($skim->expiry_date != null) ? Carbon::parse($skim->expiry_date)->format('d/m/Y') : null;
            }

            if($candidate->higherEducation) {
                $candidate->higherEducation->tarikh_senat = ($candidate->higherEducation->tarikh_senat != null) ? Carbon::parse($candidate->higherEducation->tarikh_senat)->format('d/m/Y') : null;
            }

            foreach($candidate->professional as $professional){
                $professional->date = ($professional->date != null) ? Carbon::parse($professional->date)->format('d/m/Y') : null;
            }

            if($candidate->experience){

                $candidate->experience->date_appoint = ($candidate->experience->date_appoint != null) ? Carbon::parse($candidate->experience->date_appoint)->format('d/m/Y') : null;
                $candidate->experience->date_start = ($candidate->experience->date_start != null) ? Carbon::parse($candidate->experience->date_start)->format('d/m/Y') : null;
                $candidate->experience->date_verify = ($candidate->experience->date_verify != null) ? Carbon::parse($candidate->experience->date_verify)->format('d/m/Y') : null;
                $candidate->experience->date_end = ($candidate->experience->date_end != null) ? Carbon::parse($candidate->experience->date_end)->format('d/m/Y') : null;

            }
            foreach($candidate->psl as $psl){
                $psl->exam_date = ($psl->exam_date != null) ? Carbon::parse($psl->exam_date)->format('d/m/Y') : null;
            }

            foreach($candidate->penalty as $penalty){
                $penalty->date_start = ($penalty->date_start != null) ? Carbon::parse($penalty->date_start)->format('d/m/Y') : null;
                $penalty->date_end = ($penalty->date_end != null) ? Carbon::parse($penalty->date_end)->format('d/m/Y') : null;
            }

            $candidate->pmr = $candidate->schoolResult()->with('subject')->whereHas('subject', function ($query) {
                $query->where('form', '3');
            })->get();

            //Cerfiticate Type Form 5 : 1 - SPM, 3 - SPMV, 5 - SVM
            $candidate->spm = $candidate->schoolResult()->where('certificate_type', 1)->with('subject')->whereHas('subject', function ($query) {
                $query->where('form', '5');
            })->get();

            $candidate->spmv = $candidate->schoolResult()->where('certificate_type', 3)->with('subject')->whereHas('subject', function ($query) {
                $query->where('form', '5');
            })->get();

            $candidate->svm = $candidate->schoolResult()->where('certificate_type', 5)->with('subject')->whereHas('subject', function ($query) {
                $query->where('form', '5');
            })->get();

            //Cerfiticate Type Form 6 : 1 - STPM, 2- STP, 3 - HSC, 4 - X Pakai, 5 - STAM
            $candidate->stpm = $candidate->schoolResult()->where('certificate_type', 1)->with('subject')->whereHas('subject', function ($query) {
                $query->where('form', '6');
            })->get();

            $candidate->stam = $candidate->schoolResult()->where('certificate_type', 5)->with('subject')->whereHas('subject', function ($query) {
                $query->where('form', '6');
            })->get();

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidate]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function listTimeline(Request $request)
    {
        $candidateTimeline = CandidateTimeline::where('no_pengenalan', $request->noPengenalan)->orderBy('created_at', 'desc')->limit(10)->get();
        return view('maklumat_pemohon.pemohon.list_timeline', compact('candidateTimeline'));
    }

    public function updatePersonal(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidate = Candidate::where('no_pengenalan', $request->personal_no_pengenalan)->first();

            $request->validate([
                'gender' => 'required|string|exists:ruj_jantina,code',
                'religion' => 'required|string|exists:ruj_agama,kod',
                'race' => 'required|string|exists:ruj_keturunan,kod',
                'date_of_birth' => 'required',
                'marital_status' => 'required|required|exists:ruj_taraf_kahwin,kod',
                'phone_number' => 'required',
                'email' => 'required|email:rfc,dns',
            ],[
                'gender.required' => 'Sila pilih jantina',
                'gender.exists' => 'Tiada rekod data jantina yang dipilih',
                'religion.required' => 'Sila pilih agama',
                'religion.exists' => 'Tiada rekod data agama yang dipilih',
                'race.required' => 'Sila pilih keturunan',
                'race.exists' => 'Tiada rekod data keturunan yang dipilih',
                'date_of_birth.required' => 'Sila isikan tarikh lahir',
                'marital_status.required' => 'Sila pilih taraf perkahwinan',
                'marital_status.exists' => 'Tiada rekod data taraf perkahwinan yang dipilih',
                'phone_number.required' => 'Sila isikan no telefon',
                'email.required' => 'Sila isikan emel',
                'email.email' => 'Sila isikan emel yang sah',
            ]);

            $candidate->update([
                'ref_gender_code' => $request->gender,
                'ref_religion_code' => $request->religion,
                'ref_race_code' => $request->race,
                'date_of_birth' => Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->format('Y-m-d'),
                'ref_marital_status_code' => $request->marital_status,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'updated_by' => auth()->user()->id,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->personal_no_pengenalan,
                'activity_type_id' => 4,
                'details' => 'Kemaskini Maklumat Peribadi (Peribadi)',
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function personalDetails(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidate = Candidate::where('no_pengenalan', $request->noPengenalan)->first();

            if(!$candidate) {
                return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            }

            $candidate->date_of_birth = Carbon::parse($candidate->date_of_birth)->format('d/m/Y');

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidate]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function updateAlamat(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidate = Candidate::where('no_pengenalan', $request->alamat_no_pengenalan)->first();

            $request->validate([
                'permanent_address_1' => 'required|string',
                'permanent_address_2' => 'nullable|string',
                'permanent_address_3' => 'nullable|string',
                'permanent_poscode' => 'required|min:5|string',
                'permanent_city' => 'required|string',
                'permanent_state' => 'required|string|exists:ref_state,code',
                'address_1' => 'required|string',
                'address_2' => 'nullable|string',
                'address_3' => 'nullable|string',
                'poscode' => 'required|min:5|string',
                'city' => 'required|string',
                'state' => 'required|string|exists:ref_state,code',
            ],[
                'permanent_address_1.required' => 'Sila isi alamat tetap',
                'permanent_poscode.required' => 'Sila isi poskod alamat tetap',
                'permanent_poscode.min' => 'Poskod alamat tetap mestilah sekurang-kurangnya 5 aksara',
                'permanent_city.required' => 'Sila isi bandar alamat tetap',
                'permanent_state.required' => 'Sila pilih negeri alamat tetap',
                'permanent_state.exists' => 'Tiada rekod data negeri yang dipilih',
                'address_1.required' => 'Sila isi alamat surat menyurat',
                'poscode.required' => 'Sila isi poskod alamat surat menyurat',
                'poscode.min' => 'Poskod alamat surat menyurat mestilah sekurang-kurangnya 5 aksara',
                'city.required' => 'Sila isi bandar alamat surat menyurat',
                'state.required' => 'Sila pilih negeri alamat surat menyurat',
                'state.exists' => 'Tiada rekod data negeri yang dipilih',
            ]);

            $candidate->update([
                'permanent_address_1' => $request->permanent_address_1,
                'permanent_address_2' => $request->permanent_address_2,
                'permanent_address_3' => $request->permanent_address_3,
                'permanent_poscode' => $request->permanent_poscode,
                'permanent_city' => $request->permanent_city,
                'permanent_ref_state_code' => $request->permanent_state,
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'address_3' => $request->address_3,
                'poscode' => $request->poscode,
                'city' => $request->city,
                'ref_state_code' => $request->state,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->alamat_no_pengenalan,
                'details' => 'Kemaskini Maklumat Peribadi (Alamat)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function alamatDetails(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidate = Candidate::where('no_pengenalan', $request->noPengenalan)->first();

            if(!$candidate) {
                return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            }

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidate]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function updateTempatLahir(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidate = Candidate::where('no_pengenalan', $request->tempat_lahir_no_pengenalan)->first();

            $request->validate([
                'place_of_birth' => 'required|string|exists:ref_state,code',
                'father_place_of_birth' => 'required|string|exists:ref_state,code',
                'mother_place_of_birth' => 'required|string|exists:ref_state,code',
            ],[
                'place_of_birth.required' => 'Sila pilih tempat lahir',
                'place_of_birth.exists' => 'Tiada rekod tempat lahir yang dipilih',
                'father_place_of_birth.required' => 'Sila pilih tempat lahir ayah',
                'father_place_of_birth.exists' => 'Tiada rekod tempat lahir ayah yang dipilih',
                'mother_place_of_birth.required' => 'Sila pilih tempat lahir ibu',
                'mother_place_of_birth.exists' => 'Tiada rekod tempat lahir ibu yang dipilih',
            ]);

            $candidate->update([
                'place_of_birth' => $request->place_of_birth,
                'father_place_of_birth' => $request->father_place_of_birth,
                'mother_place_of_birth' => $request->mother_place_of_birth,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->tempat_lahir_no_pengenalan,
                'details' => 'Kemaskini Maklumat Peribadi (Tempat Lahir)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function tempatLahirDetails(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidate = Candidate::where('no_pengenalan', $request->noPengenalan)->first();

            if(!$candidate) {
                return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            }

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidate]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function updateLesenMemandu(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'license_type' => 'required|string',
                'license_expiry_date' => 'required|string',
                'license_blacklist_status' => 'required|string',
                'license_blacklist_details' => 'required|string',
            ],[
                'license_type.required' => 'Sila pilih jenis lesen',
                'license_expiry_date.required' => 'Sila pilih tarikh tamat tempoh',
                'license_blacklist_status.required' => 'Sila pilih senarai hitam status',
                'license_blacklist_details.required' => 'Sila pilih butiran senarai hitam',
            ]);

            $candidateLesen = CandidateLicense::where('no_pengenalan', $request->lesen_memandu_no_pengenalan)->first();

            if($candidateLesen){
                CandidateLicense::where('no_pengenalan',$request->lesen_memandu_no_pengenalan)->update([
                    'type' => $request->license_type,
                    'expiry_date' => Carbon::createFromFormat('d/m/Y', $request->license_expiry_date)->format('Y-m-d'),
                    'is_blacklist' => $request->license_blacklist_status,
                    'blacklist_details' => $request->license_blacklist_details,
                ]);
            }else{
                CandidateLicense::create([
                    'no_pengenalan' => $request->lesen_memandu_no_pengenalan,
                    'type' => $request->license_type,
                    'expiry_date' => Carbon::createFromFormat('d/m/Y', $request->license_expiry_date)->format('Y-m-d'),
                    'is_blacklist' => $request->license_blacklist_status,
                    'blacklist_details' => $request->license_blacklist_details,
                ]);
            }

            CandidateTimeline::create([
                'no_pengenalan' => $request->lesen_memandu_no_pengenalan,
                'details' => 'Kemaskini Maklumat Peribadi (Lesen Memandu)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function lesenMemanduDetails(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidate = Candidate::where('no_pengenalan', $request->noPengenalan)
            ->with([
                'license'
            ])->first();
            if(!$candidate) {
                return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            }

            $candidate->license->expiry_date = ($candidate->license->expiry_date != null) ? Carbon::parse($candidate->license->expiry_date)->format('d/m/Y') : null;

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidate]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function updateOKU(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'oku_registration_no' => 'required|string',
                'oku_status' => 'required|string',
                'oku_category' => 'required|string',
                'oku_sub' => 'required|string',
            ],[
                'oku_registration_no.required' => 'Sila pilih nombor pendaftaran',
                'oku_status.required' => 'Sila pilih tempat status',
                'oku_category.required' => 'Sila pilih kategori',
                'oku_sub.required' => 'Sila pilih sub-kategori',
            ]);

            $candidateOku = CandidateOku::where('no_pengenalan', $request->oku_no_pengenalan)->first();

            if($candidateOku){
                CandidateOku::where('no_pengenalan',$request->oku_no_pengenalan)->update([
                    'no_registration' => $request->oku_registration_no,
                    'status' => $request->oku_status,
                    'category' => $request->oku_category,
                    'sub' => $request->oku_sub,
                ]);
            }else{
                CandidateOku::create([
                    'no_pengenalan' => $request->oku_no_pengenalan,
                    'no_registration' => $request->oku_registration_no,
                    'status' => $request->oku_status,
                    'category' => $request->oku_category,
                    'sub' => $request->oku_sub,
                ]);
            }

            CandidateTimeline::create([
                'no_pengenalan' => $request->oku_no_pengenalan,
                'details' => 'Kemaskini Maklumat Peribadi (OKU)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function OKUDetails(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidate = Candidate::where('no_pengenalan', $request->noPengenalan)
            ->with([
                'oku',
            ])->first();
            if(!$candidate) {
                return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            }

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidate]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function storePmr(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'subjek_pmr' => 'required|string|exists:ruj_matapelajaran,code',
                'gred_pmr' => 'required|string|exists:ruj_gred_matapelajaran,gred',
                'tahun_pmr' => 'required|string',
            ],[
                'subjek_pmr.required' => 'Sila pilih subjek pmr',
                'subjek_pmr.exists' => 'Tiada rekod subjek yang dipilih',
                'gred_pmr.required' => 'Sila pilih gred pmr',
                'gred_pmr.exists' => 'Tiada rekod gred yang dipilih',
                'tahun_pmr.required' => 'Sila pilih gred pmr',
                'tahun_pmr.exists' => 'Tiada rekod gred pmr yang dipilih',
            ]);

            CandidateSchoolResult::create([
                'no_pengenalan' => $request->pmr_no_pengenalan,
                'ref_subject_code' => $request->subjek_pmr,
                'grade' => $request->gred_pmr,
                'year' => $request->tahun_pmr,
                'ref_subject_tkt'=> 3,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->pmr_no_pengenalan,
                'details' => 'Tambah Maklumat Akademik (PT3/PMR/SRP)',
                'activity_type_id' => 3,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function listPmr(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidatePmr = CandidateSchoolResult::where('no_pengenalan', $request->noPengenalan)->with('subject')->whereHas('subject', function ($query) {
                $query->where('form', '3');
            })->get();

            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            //}

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidatePmr]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        //return view('maklumat_pemohon.pemohon.maklumat_tatatertib.list_penalty', compact('candidatePenalty'));
    }

    public function updatePmr(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'subjek_pmr' => 'required|string',
                'gred_pmr' => 'required|string',
                'tahun_pmr' => 'required|string',
            ],[
                'subjek_pmr.required' => 'Sila pilih subjek pmr',
                'gred_pmr.required' => 'Sila pilih gred pmr',
                'tahun_pmr.required' => 'Sila pilih gred pmr',
            ]);

            CandidateSchoolResult::where('id',$request->id_pmr)->update([
                'ref_subject_code' => $request->subjek_pmr,
                'grade' => $request->gred_pmr,
                'year' => $request->tahun_pmr,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->pmr_no_pengenalan,
                'details' => 'Kemaskini Maklumat Akademik (PT3/PMR/SRP)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function deletePmr(Request $request){
        $pmr = CandidateSchoolResult::find($request-> idPmr);

        if (!$pmr) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $pmr->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }

    public function storeSpm(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'subjek_spm' => 'required|string|exists:ruj_matapelajaran,code',
                'gred_spm' => 'required|string|exists:ruj_gred_matapelajaran,gred',
                'tahun_spm' => 'required|string',
            ],[
                'subjek_spm.required' => 'Sila pilih subjek spm',
                'subjek_spm.exists' => 'Tiada rekod subjek yang dipilih',
                'gred_spm.required' => 'Sila pilih gred spm',
                'gred_spm.exists' => 'Tiada rekod gred yang dipilih',
                'tahun_spm.required' => 'Sila pilih gred spm',
                'tahun_spm.exists' => 'Tiada rekod gred spm yang dipilih',
            ]);

            CandidateSchoolResult::create([
                'no_pengenalan' => $request->spm_no_pengenalan,
                'ref_subject_code' => $request->subjek_spm,
                'grade' => $request->gred_spm,
                'year' => $request->tahun_spm,
                'certificate_type' => 1,
                'ref_subject_tkt'=> 5,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->spm_no_pengenalan,
                'details' => 'Tambah Maklumat Akademik (SPM)',
                'activity_type_id' => 3,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function listSpm(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidateSpm = CandidateSchoolResult::where('no_pengenalan', $request->noPengenalan)->where('certificate_type', 1)->with('subject')->whereHas('subject', function ($query) {
                $query->where('form', '5');
            })->get();

            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            //}

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidateSpm]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        //return view('maklumat_pemohon.pemohon.maklumat_tatatertib.list_penalty', compact('candidatePenalty'));
    }

    public function updateSpm(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'subjek_spm' => 'required|string',
                'gred_spm' => 'required|string',
                'tahun_spm' => 'required|string',
            ],[
                'subjek_spm.required' => 'Sila pilih subjek spm',
                'gred_spm.required' => 'Sila pilih gred spm',
                'tahun_spm.required' => 'Sila pilih gred spm',
            ]);

            CandidateSchoolResult::where('id',$request->id_spm)->update([
                'ref_subject_code' => $request->subjek_spm,
                'grade' => $request->gred_spm,
                'year' => $request->tahun_spm,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->spm_no_pengenalan,
                'details' => 'Kemaskini Maklumat Akademik (SPM)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function deleteSpm(Request $request){
        $spm = CandidateSchoolResult::find($request-> idSpm);

        if (!$spm) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $spm->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }

    public function storeSpmv(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'subjek_spmv' => 'required|string|exists:ruj_matapelajaran,code',
                'gred_spmv' => 'required|string|exists:ruj_gred_matapelajaran,gred',
                'tahun_spmv' => 'required|string',
            ],[
                'subjek_spmv.required' => 'Sila pilih subjek spmv',
                'subjek_spmv.exists' => 'Tiada rekod subjek yang dipilih',
                'gred_spmv.required' => 'Sila pilih gred spmv',
                'gred_spmv.exists' => 'Tiada rekod gred yang dipilih',
                'tahun_spmv.required' => 'Sila pilih gred spmv',
                'tahun_spmv.exists' => 'Tiada rekod gred spmv yang dipilih',
            ]);

            CandidateSchoolResult::create([
                'no_pengenalan' => $request->spmv_no_pengenalan,
                'ref_subject_code' => $request->subjek_spmv,
                'grade' => $request->gred_spmv,
                'year' => $request->tahun_spmv,
                'certificate_type' => 3,
                'ref_subject_tkt'=> 5,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->spmv_no_pengenalan,
                'details' => 'Tambah Maklumat Akademik (SPMV)',
                'activity_type_id' => 3,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function listSpmv(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidateSpmv = CandidateSchoolResult::where('no_pengenalan', $request->noPengenalan)->where('certificate_type', 3)->with('subject')->whereHas('subject', function ($query) {
                $query->where('form', '5');
            })->get();

            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            //}

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidateSpmv]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        //return view('maklumat_pemohon.pemohon.maklumat_tatatertib.list_penalty', compact('candidatePenalty'));
    }

    public function updateSpmv(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'subjek_spmv' => 'required|string',
                'gred_spmv' => 'required|string',
                'tahun_spmv' => 'required|string',
            ],[
                'subjek_spmv.required' => 'Sila pilih subjek spmv',
                'gred_spmv.required' => 'Sila pilih gred spmv',
                'tahun_spmv.required' => 'Sila pilih gred spmv',
            ]);

            CandidateSchoolResult::where('id',$request->id_spmv)->update([
                'ref_subject_code' => $request->subjek_spmv,
                'grade' => $request->gred_spmv,
                'year' => $request->tahun_spmv,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->spmv_no_pengenalan,
                'details' => 'Kemaskini Maklumat Akademik (SPMV)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function deleteSpmv(Request $request){
        $spmv = CandidateSchoolResult::find($request-> idSpmv);

        if (!$spmv) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $spmv->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }

    public function storeSvm(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'subjek_svm' => 'required|string|exists:ruj_matapelajaran,code',
                'gred_svm' => 'required|string|exists:ruj_gred_matapelajaran,gred',
                'tahun_svm' => 'required|string',
            ],[
                'subjek_svm.required' => 'Sila pilih subjek svm',
                'subjek_svm.exists' => 'Tiada rekod subjek yang dipilih',
                'gred_svm.required' => 'Sila pilih gred svm',
                'gred_svm.exists' => 'Tiada rekod gred yang dipilih',
                'tahun_svm.required' => 'Sila pilih gred svm',
                'tahun_svm.exists' => 'Tiada rekod gred svm yang dipilih',
            ]);

            CandidateSchoolResult::create([
                'no_pengenalan' => $request->svm_no_pengenalan,
                'ref_subject_code' => $request->subjek_svm,
                'grade' => $request->gred_svm,
                'year' => $request->tahun_svm,
                'certificate_type' => 5,
                'ref_subject_tkt'=> 5,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->svm_no_pengenalan,
                'details' => 'Tambah Maklumat Akademik (SVM)',
                'activity_type_id' => 3,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function listSvm(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidateSvm = CandidateSchoolResult::where('no_pengenalan', $request->noPengenalan)->where('certificate_type', 5)->with('subject')->whereHas('subject', function ($query) {
                $query->where('form', '5');
            })->get();

            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            //}

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidateSvm]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        //return view('maklumat_pemohon.pemohon.maklumat_tatatertib.list_penalty', compact('candidatePenalty'));
    }

    public function updateSvm(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'subjek_svm' => 'required|string',
                'gred_svm' => 'required|string',
                'tahun_svm' => 'required|string',
            ],[
                'subjek_svm.required' => 'Sila pilih subjek svm',
                'gred_svm.required' => 'Sila pilih gred svm',
                'tahun_svm.required' => 'Sila pilih gred svm',
            ]);

            CandidateSchoolResult::where('id',$request->id_svm)->update([
                'ref_subject_code' => $request->subjek_svm,
                'grade' => $request->gred_svm,
                'year' => $request->tahun_svm,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->svm_no_pengenalan,
                'details' => 'Kemaskini Maklumat Akademik (SVM)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function deleteSvm(Request $request){
        $svm = CandidateSchoolResult::find($request-> idSvm);

        if (!$svm) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $svm->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }

    public function storeStpm(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'subjek_stpm' => 'required|string|exists:ruj_matapelajaran,code',
                'gred_stpm' => 'required|string|exists:ruj_gred_matapelajaran,gred',
                'tahun_stpm' => 'required|string',
            ],[
                'subjek_stpm.required' => 'Sila pilih subjek stpm',
                'subjek_stpm.exists' => 'Tiada rekod subjek yang dipilih',
                'gred_stpm.required' => 'Sila pilih gred stpm',
                'gred_stpm.exists' => 'Tiada rekod gred yang dipilih',
                'tahun_stpm.required' => 'Sila pilih gred stpm',
                'tahun_stpm.exists' => 'Tiada rekod gred stpm yang dipilih',
            ]);

            CandidateSchoolResult::create([
                'no_pengenalan' => $request->stpm_no_pengenalan,
                'ref_subject_code' => $request->subjek_stpm,
                'grade' => $request->gred_stpm,
                'year' => $request->tahun_stpm,
                'certificate_type' => 1,
                'ref_subject_tkt'=> 6,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->stpm_no_pengenalan,
                'details' => 'Tambah Maklumat Akademik (STPM)',
                'activity_type_id' => 3,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function listStpm(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidateStpm = CandidateSchoolResult::where('no_pengenalan', $request->noPengenalan)->where('certificate_type', 1)->with('subject')->whereHas('subject', function ($query) {
                $query->where('form', '6');
            })->get();

            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            //}

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidateStpm]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        //return view('maklumat_pemohon.pemohon.maklumat_tatatertib.list_penalty', compact('candidatePenalty'));
    }

    public function updateStpm(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'subjek_stpm' => 'required|string',
                'gred_stpm' => 'required|string',
                'tahun_stpm' => 'required|string',
            ],[
                'subjek_stpm.required' => 'Sila pilih subjek stpm',
                'gred_stpm.required' => 'Sila pilih gred stpm',
                'tahun_stpm.required' => 'Sila pilih gred stpm',
            ]);

            CandidateSchoolResult::where('id',$request->id_stpm)->update([
                'ref_subject_code' => $request->subjek_stpm,
                'grade' => $request->gred_stpm,
                'year' => $request->tahun_stpm,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->stpm_no_pengenalan,
                'details' => 'Kemaskini Maklumat Akademik (STPM)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function deleteStpm(Request $request){
        $stpm = CandidateSchoolResult::find($request-> idStpm);

        if (!$stpm) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $stpm->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }

    public function storeStam(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'subjek_stam' => 'required|string|exists:ruj_matapelajaran,code',
                'gred_stam' => 'required|string|exists:ruj_gred_matapelajaran,gred',
                'tahun_stam' => 'required|string',
            ],[
                'subjek_stam.required' => 'Sila pilih subjek stam',
                'subjek_stam.exists' => 'Tiada rekod subjek yang dipilih',
                'gred_stam.required' => 'Sila pilih gred stam',
                'gred_stam.exists' => 'Tiada rekod gred yang dipilih',
                'tahun_stam.required' => 'Sila pilih gred stam',
                'tahun_stam.exists' => 'Tiada rekod gred stam yang dipilih',
            ]);

            CandidateSchoolResult::create([
                'no_pengenalan' => $request->stam_no_pengenalan,
                'ref_subject_code' => $request->subjek_stam,
                'grade' => $request->gred_stam,
                'year' => $request->tahun_stam,
                'certificate_type' => 5,
                'ref_subject_tkt'=> 6,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->stam_no_pengenalan,
                'details' => 'Tambah Maklumat Akademik (STAM)',
                'activity_type_id' => 3,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function listStam(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidateStam = CandidateSchoolResult::where('no_pengenalan', $request->noPengenalan)->where('certificate_type', 5)->with('subject')->whereHas('subject', function ($query) {
                $query->where('form', '6');
            })->get();

            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            //}

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidateStam]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        //return view('maklumat_pemohon.pemohon.maklumat_tatatertib.list_penalty', compact('candidatePenalty'));
    }

    public function updateStam(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'subjek_stam' => 'required|string',
                'gred_stam' => 'required|string',
                'tahun_stam' => 'required|string',
            ],[
                'subjek_stam.required' => 'Sila pilih subjek stam',
                'gred_stam.required' => 'Sila pilih gred stam',
                'tahun_stam.required' => 'Sila pilih gred stam',
            ]);

            CandidateSchoolResult::where('id',$request->id_stam)->update([
                'ref_subject_code' => $request->subjek_stam,
                'grade' => $request->gred_stam,
                'year' => $request->tahun_stam,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->stam_no_pengenalan,
                'details' => 'Kemaskini Maklumat Akademik (STAM)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function deleteStam(Request $request){
        $stam = CandidateSchoolResult::find($request-> idStam);

        if (!$stam) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $stam->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }

    public function storeMatrikulasi(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'kolej_matrikulasi' => 'required|string',
                'jurusan_matrikulasi' => 'required|string',
                'matrik_matrikulasi' => 'required|string',
                'sesi_matrikulasi' => 'required|string',
                'semester_matrikulasi' => 'required|string',
                'subjek_matrikulasi' => 'required|string',
                'gred_matrikulasi' => 'required|string',
                'pngk_matrikulasi' => 'required|string',
            ],[
                'kolej_matrikulasi.required' => 'Sila pilih kolej matrikulasi',
                'jurusan_matrikulasi.required' => 'Sila pilih jurusan matrikulasi',
                'matrik_matrikulasi.required' => 'Sila isikan nombor matrik matrikulasi',
                'sesi_matrikulasi.required' => 'Sila isikan sesi matrikulasi',
                'semester_matrikulasi.required' => 'Sila isikan semester matrikulasi',
                'subjek_matrikulasi.required' => 'Sila pilih subjek matrikulasi',
                'gred_matrikulasi.required' => 'Sila isikan gred matrikulasi',
                'pngk_matrikulasi.required' => 'Sila isikan pngk matrikulasi',
            ]);

            CandidateMatriculation::create([
                'no_pengenalan' => $request->matrikulasi_no_pengenalan,
                'matric_no' => $request->matrik_matrikulasi,
                'ref_matriculation_course_code' => $request->jurusan_matrikulasi,
                'session' => $request->sesi_matrikulasi,
                'semester' => $request->semester_matrikulasi,
                'ref_matriculation_code' => $request->kolej_matrikulasi,
                'ref_matriculation_subject_code' => $request->subjek_matrikulasi,
                'grade' => $request->gred_matrikulasi,
                'pngk' => $request->pngk_matrikulasi,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->matrikulasi_no_pengenalan,
                'details' => 'Tambah Maklumat Akademik (Matrikulasi)',
                'activity_type_id' => 3,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function listMatrikulasi(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidateMatrikulasi = CandidateMatriculation::where('no_pengenalan', $request->noPengenalan)->with(['course', 'college', 'subject'])->get();

            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            //}

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidateMatrikulasi]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        //return view('maklumat_pemohon.pemohon.maklumat_tatatertib.list_penalty', compact('candidatePenalty'));
    }

    public function updateMatrikulasi(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'kolej_matrikulasi' => 'required|string',
                'jurusan_matrikulasi' => 'required|string',
                'matrik_matrikulasi' => 'required|string',
                'sesi_matrikulasi' => 'required|string',
                'semester_matrikulasi' => 'required|string',
                'subjek_matrikulasi' => 'required|string',
                'gred_matrikulasi' => 'required|string',
                'pngk_matrikulasi' => 'required|string',
            ],[
                'kolej_matrikulasi.required' => 'Sila pilih kolej matrikulasi',
                'jurusan_matrikulasi.required' => 'Sila pilih jurusan matrikulasi',
                'matrik_matrikulasi.required' => 'Sila isikan nombor matrik matrikulasi',
                'sesi_matrikulasi.required' => 'Sila isikan sesi matrikulasi',
                'semester_matrikulasi.required' => 'Sila isikan semester matrikulasi',
                'subjek_matrikulasi.required' => 'Sila pilih subjek matrikulasi',
                'gred_matrikulasi.required' => 'Sila isikan gred matrikulasi',
                'pngk_matrikulasi.required' => 'Sila isikan pngk matrikulasi',
            ]);

            CandidateMatriculation::where('id',$request->id_matrikulasi)->update([
                'matric_no' => $request->matrik_matrikulasi,
                'ref_matriculation_course_code' => $request->jurusan_matrikulasi,
                'session' => $request->sesi_matrikulasi,
                'semester' => $request->semester_matrikulasi,
                'ref_matriculation_code' => $request->kolej_matrikulasi,
                'ref_matriculation_subject_code' => $request->subjek_matrikulasi,
                'grade' => $request->gred_matrikulasi,
                'pngk' => $request->pngk_matrikulasi,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->matrikulasi_no_pengenalan,
                'details' => 'Kemaskini Maklumat Akademik (Matrikulasi)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function deleteMatrikulasi(Request $request){
        $smatrikulasi = CandidateMatriculation::find($request-> idMatrikulasi);

        if (!$smatrikulasi) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $smatrikulasi->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }

    public function storeSkm(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'tahun_skm' => 'required|string',
                'nama_skm' => 'required|string',
            ],[
                'tahun_skm.required' => 'Sila isi tahun kelulusan',
                'nama_skm.required' => 'Sila pilih kelulusan',
            ]);

            CandidateSkm::create([
                'no_pengenalan' => $request->skm_no_pengenalan,
                'ref_qualification_code' => $request->nama_skm,
                'year' => $request->tahun_skm,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->skm_no_pengenalan,
                'details' => 'Tambah Maklumat Akademik (SKM)',
                'activity_type_id' => 3,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function listSkm(Request $request)
    {
        DB::beginTransaction();
        try {
            $candidateSkm = CandidateSkm::where('no_pengenalan', $request->noPengenalan)->with(['qualification'])->get();

            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            //}

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidateSkm]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        //return view('maklumat_pemohon.pemohon.maklumat_tatatertib.list_penalty', compact('candidatePenalty'));
    }

    public function updateSkm(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'tahun_skm' => 'required|string',
                'nama_skm' => 'required|string',
            ],[
                'tahun_skm.required' => 'Sila isi tahun kelulusan',
                'nama_skm.required' => 'Sila pilih kelulusan',
            ]);

            CandidateSkm::where('id',$request->id_skm)->update([
                'ref_qualification_code' => $request->nama_skm,
                'year' => $request->tahun_skm,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->skm_no_pengenalan,
                'details' => 'Kemaskini Maklumat Akademik (SKM)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function deleteSkm(Request $request){
        $skm = CandidateSkm::find($request-> idSkm);

        if (!$skm) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $skm->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }

    public function storeBahasa(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'nama_bahasa' => 'required|string',
                'penguasaan_bahasa' => 'required|string',
            ],[
                'nama_bahasa.required' => 'Sila pilih bahasa',
                'penguasaan_bahasa.required' => 'Sila pilih penguasaan',

            ]);

            CandidateLanguage::create([
                'no_pengenalan' => $request->bahasa_no_pengenalan,
                'ref_language_code' => $request->nama_bahasa,
                'level' => $request->penguasaan_bahasa,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->bahasa_no_pengenalan,
                'details' => 'Tambah Maklumat Tambahan (Bahasa)',
                'activity_type_id' => 3,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function listBahasa(Request $request)
    {
        DB::beginTransaction();
        try {
            $candidateBahasa = CandidateLanguage::select(
            )->where('no_pengenalan', $request->noPengenalan)->with(['language'])->get();

            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            //}

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidateBahasa]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        //return view('maklumat_pemohon.pemohon.maklumat_tatatertib.list_penalty', compact('candidatePenalty'));
    }

    public function updateBahasa(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'nama_bahasa' => 'required|string',
                'penguasaan_bahasa' => 'required|string',
            ],[
                'nama_bahasa.required' => 'Sila pilih bahasa',
                'penguasaan_bahasa.required' => 'Sila pilih penguasaan',

            ]);

            CandidateLanguage::where('id',$request->id_bahasa)->update([
                'ref_language_code' => $request->nama_bahasa,
                'level' => $request->penguasaan_bahasa,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->bahasa_no_pengenalan,
                'details' => 'Kemaskini Maklumat Tamabahan (Bahasa)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function deleteBahasa(Request $request){
        $bahasa = CandidateLanguage::find($request-> idBahasa);

        if (!$bahasa) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $bahasa->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }

    public function storeBakat(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'nama_bakat' => 'required|string',
            ],[
                'nama_bakat.required' => 'Sila pilih kelulusan',
            ]);

            CandidateTalent::create([
                'no_pengenalan' => $request->bakat_no_pengenalan,
                'ref_talent_code' => $request->nama_bakat,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->bakat_no_pengenalan,
                'details' => 'Tambah Maklumat Tambahan (Bakat)',
                'activity_type_id' => 3,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function listBakat(Request $request)
    {
        DB::beginTransaction();
        try {
            $candidateBakat = CandidateTalent::select(
            )->where('no_pengenalan', $request->noPengenalan)->with(['talent'])->get();

            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            //}

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidateBakat]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        //return view('maklumat_pemohon.pemohon.maklumat_tatatertib.list_penalty', compact('candidatePenalty'));
    }

    public function updateBakat(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'nama_bakat' => 'required|string',
            ],[
                'nama_bakat.required' => 'Sila pilih kelulusan',
            ]);

            CandidateTalent::where('id',$request->id_bakat)->update([
                'ref_talent_code' => $request->nama_bakat,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->bakat_no_pengenalan,
                'details' => 'Kemaskini Maklumat Tamabahan (Bakat)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function deleteBakat(Request $request){
        $bakat = CandidateTalent::find($request-> idBakat);

        if (!$bakat) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $bakat->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }

    public function updatePengajianTinggi(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidate = CandidateHigherEducation::where('no_pengenalan', $request->pengajian_tinggi_no_pengenalan)->first();

            $request->validate([
                'peringkat_pengajian_tinggi' => 'required|string|exists:ruj_peringkat_pengajian,id',
                'tahun_pengajian_tinggi' => 'required|string',
                'kelayakan_pengajian_tinggi' => 'required|string|exists:ruj_kelayakan,code',
                'cgpa_pengajian_tinggi' => 'required|string',
                'institusi_pengajian_tinggi' => 'required|string|exists:ruj_institusi,code',
                'nama_sijil_pengajian_tinggi' => 'required|string',
                'pengkhususan_pengajian_tinggi' => 'required|string|exists:ruj_pengkhususan,code',
                'fln_pengajian_tinggi' => 'required|integer|digits_between:1,2',
                'tarikh_senat_pengajian_tinggi' => 'required',
                'biasiswa_pengajian_tinggi' => 'required|boolean',
            ],[
                'peringkat_pengajian_tinggi.required' => 'Sila pilih peringkat pengajian tinggi',
                'peringkat_pengajian_tinggi.exists' => 'Tiada rekod peringkat pengajian tinggi yang dipilih',
                'tahun_pengajian_tinggi.required' => 'Sila pilih tahun pengajian tinggi',
                'kelayakan_pengajian_tinggi.required' => 'Sila pilih peringkat kelulusan pengajian tinggi',
                'kelayakan_pengajian_tinggi.exists' => 'Tiada rekod peringkat kelulusan pengajian tinggi yang dipilih',
                'cgpa_pengajian_tinggi.required' => 'Sila pilih cgpa pengajian tinggi',
                'institusi_pengajian_tinggi.required' => 'Sila pilih institusi pengajian tinggi',
                'institusi_pengajian_tinggi.exists' => 'Tiada rekod institusi pengajian tinggi yang dipilih',
                'nama_sijil_pengajian_tinggi.required' => 'Sila pilih nama sijil pengajian tinggi',
                'pengkhususan_pengajian_tinggi.required' => 'Sila pilih pengkhususan/bidang pengajian tinggi',
                'pengkhususan_pengajian_tinggi.exists' => 'Tiada rekod pengkhususan/bidang pengajian tinggi yang dipilih',
                'fln_pengajian_tinggi.required' => 'Sila pilih francais luar negara pengajian tinggi',
                'fln_pengajian_tinggi.digits_between' => 'Sila pilih Ya/Tidak sahaja untuk francais luar negara pengajian tinggi',
                'tarikh_senat_pengajian_tinggi.required' => 'Sila pilih tarikh senat pengajian tinggi',
                'biasiswa_pengajian_tinggi.required' => 'Sila pilih biasiswa pengajian tinggi',
                'biasiswa_pengajian_tinggi.boolean' => 'Sila pilih Ya/Tidak sahaja untuk biasiswa pengajian tinggi',
            ]);

            $candidate->update([
                'peringkat_pengajian' => $request->peringkat_pengajian_tinggi,
                'year' => $request->tahun_pengajian_tinggi,
                'ref_eligibility_code' => $request->kelayakan_pengajian_tinggi,
                'cgpa' => $request->cgpa_pengajian_tinggi,
                'ref_institution_code' => $request->institusi_pengajian_tinggi,
                'nama_sijil' => $request->nama_sijil_pengajian_tinggi,
                'ref_specialization_code' => $request->pengkhususan_pengajian_tinggi,
                'ins_fln' => $request->fln_pengajian_tinggi,
                'tarikh_senat' => Carbon::createFromFormat('d/m/Y', $request->tarikh_senat_pengajian_tinggi)->format('Y-m-d'),
                'biasiswa' => $request->biasiswa_pengajian_tinggi,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->pengajian_tinggi_no_pengenalan,
                'details' => 'Kemaskini Maklumat Akademik (Pengajian Tinggi)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function pengajianTinggiDetails(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidateHigherEducation = CandidateHigherEducation::where('no_pengenalan', $request->noPengenalan)->first();

            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);

            $candidateHigherEducation->tarikh_senat = ($candidateHigherEducation->tarikh_senat != null) ? Carbon::parse($candidateHigherEducation->tarikh_senat)->format('d/m/Y') : null;
            // }

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidateHigherEducation]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function storePsl(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'jenis_peperiksaan' => 'required|string',
                'tarikh_peperiksaan' => 'required|string',
            ],[
                'jenis_peperiksaan.required' => 'Sila pilih jenis peperiksaan',
                'tarikh_peperiksaan.required' => 'Sila pilih tarikh peperiksaan',

            ]);

            CandidatePsl::create([
                'no_pengenalan' => $request->psl_no_pengenalan,
                'ref_qualification_code' => $request->jenis_peperiksaan,
                'exam_date' => Carbon::createFromFormat('d/m/Y', $request->tarikh_peperiksaan)->format('Y-m-d'),
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->psl_no_pengenalan,
                'details' => 'Tambah Maklumat Pegawai Berkhidmat (PSL)',
                'activity_type_id' => 3,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function listPsl(Request $request)
    {
        DB::beginTransaction();
        try {
            $candidatePsl = CandidatePsl::where('no_pengenalan', $request->noPengenalan)->with(['qualification'])->get();

            foreach($candidatePsl as $psl){
                $psl->exam_date = ($psl->exam_date != null) ? Carbon::parse($psl->exam_date)->format('d/m/Y') : null;
            }

            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            //}

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidatePsl]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        //return view('maklumat_pemohon.pemohon.maklumat_tatatertib.list_penalty', compact('candidatePenalty'));
    }

    public function updatePsl(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'jenis_peperiksaan' => 'required|string',
                'tarikh_peperiksaan' => 'required|string',
            ],[
                'jenis_peperiksaan.required' => 'Sila pilih jenis peperiksaan',
                'tarikh_peperiksaan.required' => 'Sila pilih tarikh peperiksaan',

            ]);

            CandidatePsl::where('id',$request->id_psl)->update([
                'ref_qualification_code' => $request->jenis_peperiksaan,
                'exam_date' => Carbon::createFromFormat('d/m/Y', $request->tarikh_peperiksaan)->format('Y-m-d'),
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->psl_no_pengenalan,
                'details' => 'Kemaskini Maklumat Pegawai Berkhidmat (PSL)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function deletePsl(Request $request){
        $psl = CandidatePsl::find($request-> idPsl);

        if (!$psl) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $psl->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }

    public function updateExperience(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidate = CandidateExperience::where('no_pengenalan', $request->experience_no_pengenalan)->first();

            $request->validate([
                'experience_appoint_date' => 'required',
                'experience_position_level' => 'required|string|exists:ruj_taraf_jawatan,code',
                'experience_skim' => 'required|string|exists:ruj_skim,code',
                'experience_start_date' => 'required',
                'experience_verify_date' => 'required',
                'experience_department_ministry' => 'required|string|exists:ruj_kem_jabatan,kod',
                'experience_department_state' => 'required|string|exists:ref_state,code',
            ],[
                'experience_appoint_date.required' => 'Sila pilih tarikh lantikan pertama',
                'experience_position_level.required' => 'Sila pilih taraf jawatan',
                'experience_position_level.exists' => 'Tiada rekod taraf jawatan yang dipilih',
                'experience_skim.required' => 'Sila pilih skim perkhidmatan',
                'experience_skim.exists' => 'Tiada rekod skim perkhidmatan yang dipilih',
                'experience_start_date.required' => 'Sila pilih tarikh lantikan',
                'experience_verify_date.required' => 'Sila pilih tarikh pengesahan lantikan',
                'experience_department_ministry.required' => 'Sila pilih kementerian/jabatan',
                'experience_department_ministry.exists' => 'Tiada rekod kementerian/jabatan yang dipilih',
                'experience_department_state.required' => 'Sila pilih negeri kementerian/jabatan',
                'experience_department_state.exists' => 'Tiada rekod negeri kementerian/jabatan yang dipilih',
            ]);

            $candidate->update([
                'date_appoint' => Carbon::createFromFormat('d/m/Y', $request->experience_appoint_date)->format('Y-m-d'),
                'ref_position_level_code' => $request->experience_position_level,
                'ref_skim_code' => $request->experience_skim,
                'date_start' => Carbon::createFromFormat('d/m/Y', $request->experience_start_date)->format('Y-m-d'),
                'date_verify' => Carbon::createFromFormat('d/m/Y', $request->experience_verify_date)->format('Y-m-d'),
                'ref_department_ministry_code' => $request->experience_department_ministry,
                'state_department' => $request->experience_department_state,

            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->experience_no_pengenalan,
                'details' => 'Kemaskini Pegawai Berkhidmat (Maklumat PSB/PSL)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function experienceDetails(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidateExperience = CandidateExperience::where('no_pengenalan', $request->noPengenalan)->first();

            $candidateExperience->date_appoint = ($candidateExperience->date_appoint != null) ? Carbon::parse($candidateExperience->date_appoint)->format('d/m/Y') : null;
            $candidateExperience->date_start = ($candidateExperience->date_start != null) ? Carbon::parse($candidateExperience->date_start)->format('d/m/Y') : null;
            $candidateExperience->date_verify = ($candidateExperience->date_verify != null) ? Carbon::parse($candidateExperience->date_verify)->format('d/m/Y') : null;
            $candidateExperience->date_end = ($candidateExperience->date_end != null) ? Carbon::parse($candidateExperience->date_end)->format('d/m/Y') : null;


            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            // }

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidateExperience]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function updateTenteraPolis(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidate = CandidateArmyPolice::where('no_pengenalan', $request->tentera_polis_no_pengenalan)->first();

            $request->validate([
                'jenis_perkhidmatan_tentera_polis' => 'required|string|exists:ruj_jenis_perkhidmatan,id',
                'pangkat_tentera_polis' => 'required|string|exists:ruj_pangkat,code',
                'jenis_bekas_tentera_polis' => 'required|string|exists:ruj_jenis_bekas_tentera_polis,code',
            ],[
                'jenis_perkhidmatan_tentera_polis.required' => 'Sila pilih jenis penamatan perkhidmatan',
                'jenis_perkhidmatan_tentera_polis.exists' => 'Tiada rekod jenis penamatan perkhidmatan yang dipilih',
                'pangkat_tentera_polis.required' => 'Sila pilih pangkat dalam tentera',
                'pangkat_tentera_polis.exists' => 'Tiada rekod pangkat dalam tentera yang dipilih',
                'jenis_bekas_tentera_polis.required' => 'Sila pilih kategori',
                'jenis_bekas_tentera_polis.exists' => 'Tiada rekod kategori yang dipilih',
            ]);

            $candidate->update([
                'type_service' => $request->jenis_perkhidmatan_tentera_polis,
                'ref_rank_code' => $request->pangkat_tentera_polis,
                'type_army_police' => $request->jenis_bekas_tentera_polis,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->tentera_polis_no_pengenalan,
                'details' => 'Kemaskini Maklumat Tambahan (Maklumat Bekas Tentera)',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function tenteraPolisDetails(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidateArmyPolice = CandidateArmyPolice::where('no_pengenalan', $request->noPengenalan)->first();

            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            // }

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidateArmyPolice]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function storePenalty(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'penalty_no_pengenalan' => 'required|string|exists:candidate,no_pengenalan',
                'penalty' => 'required|string|exists:ruj_tatatertib,code',
                'penalty_duration' => 'required|integer',
                'penalty_type' => 'required',
                'penalty_start' => 'required',
                'penalty_end' => 'required',
            ],[
                'penalty_no_pengenalan.required' => 'Sila isikan no kad pengenalan',
                'penalty_no_pengenalan.exists' => 'Rekod data no kad pengenalan tidak dijumpai',
                'penalty.required' => 'Sila pilih tindakan tatatertib',
                'penalty_duration.required' => 'Sila isikan tempoh hukuman',
                'penalty_type.required' => 'Sila isikan jenis tempoh hukuman',
                'penalty_start.required' => 'Sila isikan tarikh mula hukuman',
                'penalty_end.required' => 'Sila isikan tarikh akhir hukuman',
            ]);

            $candidatePenalty = CandidatePenalty::create([
                'no_pengenalan' => $request->penalty_no_pengenalan,
                'ref_penalty_code' => $request->penalty,
                'duration' => $request->penalty_duration,
                'type' => $request->penalty_type,
                'date_start' => Carbon::createFromFormat('d/m/Y', $request->penalty_start)->format('Y-m-d'),
                'date_end' => Carbon::createFromFormat('d/m/Y', $request->penalty_end)->format('Y-m-d'),
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->penalty_no_pengenalan,
                'details' => 'Tambah Tatatertib',
                'activity_type_id' => 3,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function listPenalty(Request $request)
    {
        DB::beginTransaction();
        try {

            $candidatePenalty = CandidatePenalty::where('no_pengenalan', $request->noPengenalan)->with('penalty')->get();

            foreach($candidatePenalty as $penalty){
                $penalty->date_start = ($penalty->date_start != null) ? Carbon::parse($penalty->date_start)->format('d/m/Y') : null;
                $penalty->date_end = ($penalty->date_end != null) ? Carbon::parse($penalty->date_end)->format('d/m/Y') : null;
            }

            // if(!$candidate) {
            //     return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => "Data tidak dijumpai"], 404);
            //}

            //DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => $candidatePenalty]);

        } catch (\Throwable $e) {

            //DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }

        //return view('maklumat_pemohon.pemohon.maklumat_tatatertib.list_penalty', compact('candidatePenalty'));
    }

    public function updatePenalty(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'penalty_no_pengenalan' => 'required|string',
                'penalty' => 'required|string',
                'penalty_duration' => 'required|integer',
                'penalty_type' => 'required',
                'penalty_start' => 'required',
                'penalty_end' => 'required',
            ],[
                'penalty_no_pengenalan.required' => 'Sila isikan no kad pengenalan',
                'penalty.required' => 'Sila pilih tindakan tatatertib',
                'penalty_duration.required' => 'Sila isikan tempoh hukuman',
                'penalty_type.required' => 'Sila isikan jenis tempoh hukuman',
                'penalty_start.required' => 'Sila isikan tarikh mula hukuman',
                'penalty_end.required' => 'Sila isikan tarikh akhir hukuman',
            ]);

            CandidatePenalty::where('id',$request->id_penalty)->update([
                'ref_penalty_code' => $request->penalty,
                'duration' => $request->penalty_duration,
                'type' => $request->penalty_type,
                'date_start' => Carbon::createFromFormat('d/m/Y', $request->penalty_start)->format('Y-m-d'),
                'date_end' => Carbon::createFromFormat('d/m/Y', $request->penalty_end)->format('Y-m-d'),
            ]);

            CandidateTimeline::create([
                'no_pengenalan' => $request->penalty_no_pengenalan,
                'details' => 'Kemaskini Maklumat Tatatertib',
                'activity_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['title' => 'Berjaya', 'status' => 'success', 'message' => "Berjaya", 'detail' => "berjaya"]);

        } catch (\Throwable $e) {

            DB::rollback();
            return response()->json(['title' => 'Gagal', 'status' => 'error', 'detail' => $e->getMessage()], 404);
        }
    }

    public function deletePenalty(Request $request){
        $penalty = CandidatePenalty::find($request-> idPenalty);

        if (!$penalty) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $penalty->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }

}
