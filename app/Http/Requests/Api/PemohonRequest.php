<?php

namespace App\Http\Requests\Api;

class PemohonRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $routeName = $routeName = $this->route()->getName();

        if ($routeName == 'pemohon.store') {
            $rules = [
                'nama_penuh' => 'required|string',
                'no_kp' => 'required|string|unique:calon,no_kp_baru',
                'emel' => 'required|email',
                'no_tel' => 'required|string',
                'tarikh_lahir' => 'required|date_format:Y-m-d',
                'jantina' => 'required|string',
                'agama' => 'required|string',
                'keturunan' => 'required|string',
                //'kewarganegaraan' => 'required|string',
                'status_kahwin' => 'required|string',
                'tempat_lahir' => 'required|string',
                'tempat_lahir_bapa' => 'required|string',
                'tempat_lahir_ibu' => 'required|string',
                'alamat1_tetap' => 'required|string',
                'alamat2_tetap' => 'nullable|string',
                'alamat3_tetap' => 'nullable|string',
                'poskod_tetap' => 'required|string|min:5',
                'bandar_tetap' => 'required|string',
                'negeri_tetap' => 'required|string',
                'alamat1_surat' => 'required|string',
                'alamat2_surat' => 'nullable|string',
                'alamat3_surat' => 'nullable|string',
                'poskod_surat' => 'required|string|min:5',
                'bandar_surat' => 'required|string',
                'negeri_surat' => 'required|string',
                'tinggi' => 'required|decimal:0,2',
                'berat' => 'required|decimal:0,2',
                'pusat_temuduga' => 'required|string|exists:ruj_pusat_temuduga,kod',
                'jenis_lesen' => 'nullable|string',
                'tempoh_tamat_lesen' => 'required_with:jenis_lesen|nullable|date_format:d/m/Y',
                'status_senaraihitam_lesen' => 'required_with:jenis_lesen|nullable|boolean',
                'msg_senaraihitam_lesen' => 'required_if:status_senaraihitam_lesen,true|nullable|string',
                'no_daftar_rujukan_oku' => 'required_with:jenis_bantuan_oku|nullable|string',
                'jenis_bantuan_oku' => 'required_with:no_daftar_rujukan_oku|nullable|string',
                'sub_kategori_oku' => 'nullable|string',
                'status_oku' => 'nullable|string',
                'skim' => 'nullable|array',
                'skim.*' => 'required|array',
                'skim.*.tarikh_daftar' => 'required_with:skim.*.skim|date_format:Y-m-d',
                'skim.*.skim' => 'required_with:skim.*.tarikh_daftar|string|exists:ruj_skim,code',
                'skim.*.no_kelompok' => 'required_with:skim.*.tarikh_daftar|string',
                'skim.*.no_siri' => 'required_with:skim.*.tarikh_daftar|string',
                'daftar_calon' => 'nullable|array',
                'daftar_calon.*' => 'required|array',
                'daftar_calon.*.skim' => 'required_with:skim.*.tarikh_daftar|string|exists:ruj_skim,code',
                'daftar_calon.*.tarikh_daftar' => 'required_with:skim.*.skim|date_format:Y-m-d',
                'daftar_calon.*.keutamaan' => 'nullable|string',
                'tingkatan_3' => 'nullable|array',
                'tingkatan_3.*' => 'required|array',
                'tingkatan_3.*.jenis_sijil' => 'required|integer',
                'tingkatan_3.*.keputusan_terbuka' => 'required|integer',
                'tingkatan_3.*.tahun' => 'required|date_format:Y,',
                'tingkatan_3.*.mata_pelajaran' => 'required|string',
                'tingkatan_3.*.gred' => 'required|string',
                'tingkatan_5' => 'nullable|array',
                'tingkatan_5.*' => 'required|array',
                'tingkatan_5.*.jenis_sijil' => 'required|integer',
                'tingkatan_5.*.keputusan_terbuka' => 'required|integer',
                'tingkatan_5.*.tahun' => 'required|date_format:Y,',
                'tingkatan_5.*.mata_pelajaran' => 'required|string',
                'tingkatan_5.*.gred' => 'required|string',
                'tingkatan_6' => 'nullable|array',
                'tingkatan_6.*' => 'required|array',
                'tingkatan_6.*.jenis_sijil' => 'required|integer',
                'tingkatan_6.*.keputusan_terbuka' => 'required|integer',
                'tingkatan_6.*.tahun' => 'required|date_format:Y,',
                'tingkatan_6.*.mata_pelajaran' => 'required|string',
                'tingkatan_6.*.gred' => 'required|string',
                'svm' => 'nullable|array',
                'svm.*' => 'required|array',
                'svm.*.kelulusan' => 'required|string|exists:ruj_kelulusan,code',
                'svm.*.tahun_lulus' => 'required|date_format:Y',
                'svm.*.pngka' => 'required|decimal:0,2',
                'svm.*.pngkv' => 'required|decimal:0,2',
                'svm.*.mata_pelajaran' => 'required|string',
                'svm.*.gred' => 'required|string',
                'skm' => 'nullable|array',
                'skm.*' => 'required|array',
                'skm.*.kelulusan' => 'required|string|exists:ruj_kelulusan,code',
                'skm.*.tahun_lulus' => 'required|date_format:Y',
                'matrikulasi' => 'nullable|array',
                'matrikulasi.*' => 'required|array',
                'matrikulasi.*.no_matrik' => 'required|string',
                'matrikulasi.*.jurusan' => 'required|string|exists:ruj_jurusan_matrikulasi,code',
                'matrikulasi.*.sesi' => 'required|string',
                'matrikulasi.*.semester' => 'required|string',
                'matrikulasi.*.kolej' => 'required|string|exists:ruj_matrikulasi,code',
                'matrikulasi.*.subjek' => 'required|string|exists:ruj_subjek_matrikulasi,code',
                'matrikulasi.*.pngk' => 'required|decimal:0,2',
                'matrikulasi.*.gred' => 'required|string',
                'pengajian_tinggi' => 'nullable|array',
                'pengajian_tinggi.*' => 'required|array',
                'pengajian_tinggi.*.institusi' => 'required|string|exists:ruj_institusi,code',
                'pengajian_tinggi.*.kelayakan' => 'required|string|exists:ruj_kelayakan,code',
                'pengajian_tinggi.*.pengkhususan' => 'required|string|exists:ruj_pengkhususan,code',
                'pengajian_tinggi.*.tahun' => 'required|date_format:Y',
                'pengajian_tinggi.*.cgpa' => 'required|decimal:0,2',
                'pengajian_tinggi.*.institusi_francais' => 'nullable|integer',
                'pengajian_tinggi.*.tarikh_senat' => 'nullable|date_format:Y-m-d',
                'pengajian_tinggi.*.nama_sijil' => 'required|string',
                'pengajian_tinggi.*.peringkat' => 'nullable|integer',
                'pengajian_tinggi.*.biasiswa' => 'nullable|integer',
                'profesional' => 'nullable|array',
                'profesional.*' => 'required|array',
                'profesional.*.kelulusan' => 'required|string|exists:ruj_kelulusan,code',
                'profesional.*.no_ahli' => 'nullable|string',
                'profesional.*.tarikh' => 'nullable|date_format:Y-m-d',
                'psl' => 'nullable|array',
                'psl.*' => 'required|array',
                'psl.*.kelulusan' => 'required|string|exists:ruj_kelulusan,code',
                'psl.*.tarikh_exam' => 'required|date_format:Y-m-d',
                'pengalaman_jenis_perkhidmatan' => 'nullable|string', //sektor_pekerjaan
                'pengalaman_jenis_lantikan' => 'nullable|string', //taraf_jawatan
                'pengalaman_tarikh_lantikan_pertama' => 'nullable|date_format:Y-m-d', //tarikh_lantik
                'pengalaman_tarikh_lantikan' => 'nullable|date_format:Y-m-d', //tarikh_mula
                'pengalaman_tarikh_sah' => 'nullable|date_format:Y-m-d', //tarikh_disahkan
                'pengalaman_skim' => 'nullable|string|exists:ruj_skim,code', //kod_ruj_skim
                'pengalaman_gred_gaji' => 'nullable|string|exists:ruj_gred_gaji_hdr,code', //kod_ruj_gred_gaji
                'pengalaman_kementerian' => 'nullable|string|exists:ruj_kem_jabatan,kod', //kod_ruj_kementerian
                'pengalaman_negeri_bertugas' => 'nullable|string|exists:ruj_negeri,kod', //kod_ruj_negeri
                'pengalaman_daerah_bertugas' => 'nullable|string', //daerah_bertugas //Validate remove 2 number depan and link degan ruj_daerah
                'pengalaman_tarikh_tamat_kontrak' => 'nullable|date_format:Y-m-d', //tarikh_tamat_kontrak
                'pengalaman_kumpulan_pkhidmat' => 'nullable|string|exists:ruj_kumpulan_ssm,kod', //kump_pkhidmat
                'kategori_tentera_polis' => 'required_with:pangkat_tentera_polis|nullable|string|exists:ruj_jenis_perkhidmatan,id', //status_pkhidmat
                'pangkat_tentera_polis' => 'required_with:kategori_tentera_polis|nullable|string|exists:ruj_pangkat,code',
                'jenis_bekas_tentera_polis' => 'nullable|string|exists:ruj_jenis_bekas_tentera_polis,code',
                'bakat' => 'nullable|array',
                'bakat.*' => 'required|array',
                'bakat.*.bakat' => 'required|string|exists:ruj_bakat,code',
                'bakat.*.bakat_detail' => 'nullable|string',
                'bahasa' => 'nullable|array',
                'bahasa.*' => 'required|array',
                'bahasa.*.bahasa' => 'required|string|exists:ruj_bahasa,kod',
                'bahasa.*.penguasaan' => 'required|string', //Validate dekat kod_pelbagai




                //Handle result sekolah exists utk matapelajaran dgn gred
            ];
        }

        return $rules;
    }

    // Overwrite function to add in id from route path for validation
    public function all($keys = null)
    {
        $data = parent::all();

        if ($this->route('id')) {
            $data['id'] = $this->route('id');
        }

        return $data;
    }
}