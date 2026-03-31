<div>

    <form wire:submit.prevent="store">
        
    <div wire:loading wire:target="images, store"
     class="position-fixed top-0 start-0 w-100 h-100 
            bg-dark bg-opacity-50 
            justify-content-center align-items-center"
     style="z-index:9999;">

        <div class="bg-white p-4 rounded shadow">
            <p class="text-dark" style="font-size: 1.5rem; width: 100%; text-align: center;"> 
                <i class="text-dark animate-wand fas fa-wand-magic-sparkles text-dark"></i> &nbsp; Sedang Memproses
            </p>
        </div>
    </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Nomor Karyawan</label>
                <input placeholder="Nomor Karyawan" type="text" wire:model="nomor_karyawan" class="form-control">

                @error('nomor_karyawan')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <ul class="nav nav-tabs" id="tabEmployee" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal-tab-pane" type="button" role="tab" aria-controls="personal-tab-pane" aria-selected="true"><h3>Personal</h3></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="informasi-tambahan-tab" data-bs-toggle="tab" data-bs-target="#informasi-tambahan-tab-pane" type="button" role="tab" aria-controls="informasi-tambahan-tab-pane" aria-selected="true"><h3>Informasi Tambahan</h3></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="kontak-tab" data-bs-toggle="tab" data-bs-target="#kontak-tab-pane" type="button" role="tab" aria-controls="kontak-tab-pane" aria-selected="true"><h3>Kontak</h3></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="kontak-darurat-tab" data-bs-toggle="tab" data-bs-target="#kontak-darurat-tab-pane" type="button" role="tab" aria-controls="kontak-darurat-tab-pane" aria-selected="true"><h3>Kontak Darurat</h3></button>
            </li>
        </ul>
        <div class="tab-content" id="tabEmployeeContent">
            <div class="tab-pane fade show active" id="personal-tab-pane" role="tabpanel" aria-labelledby="personal-tab" tabindex="0">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Nama Lengkap</label>
                        <input placeholder="Nama Lengkap" type="text" wire:model="nama_karyawan" class="form-control">

                        @error('nama_karyawan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Nomor Identitas</label>
                        <input placeholder="Nomor Identitas" type="text" wire:model="nomor_identitas" class="form-control">

                        @error('nomor_identitas')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Divisi</label>
                        <select wire:model="divisi" class="form-select">
                            @foreach (App\Models\User::DIVISI_CHOICE as $key => $name)    
                                <option value="{{$name}}">{{$name}}</option>
                            @endforeach
                        </select>

                        @error('divisi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Tempat Lahir</label>
                        <input placeholder="Tempat Lahir" type="text" wire:model="tempat_lahir" class="form-control">

                        @error('tempat_lahir')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Tanggal Lahir</label>
                        <input placeholder="Tanggal Lahir" type="date" wire:model="tanggal_lahir" class="form-control">

                        @error('tanggal_lahir')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Jenis Kelamin</label>
                        <select wire:model="jenis_kelamin" class="form-select">
                            @foreach (App\Models\User::JENIS_KELAMIN_CHOICE as $key => $name)    
                                <option value="{{$name}}">{{$name}}</option>
                            @endforeach
                        </select>

                        @error('jenis_kelamin')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Agama</label>
                        <select wire:model="agama" class="form-select">
                            @foreach (App\Models\User::AGAMA_CHOICE as $key => $name)    
                                <option value="{{$name}}">{{$name}}</option>
                            @endforeach
                        </select>

                        @error('agama')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Status Perkawinan</label>
                        <select wire:model="status_perkawinan" class="form-select">
                            @foreach (App\Models\User::STATUS_PERKAWINAN_CHOICE as $key => $name)    
                                <option value="{{$name}}">{{$name}}</option>
                            @endforeach
                        </select>

                        @error('status_perkawinan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Pendidikan Terakhir</label>
                        <select wire:model="pendidikan_terakhir" class="form-select">
                            @foreach (App\Models\User::PENDIDIKAN_TERAKHIR_CHOICE as $key => $name)    
                                <option value="{{$name}}">{{$name}}</option>
                            @endforeach
                        </select>

                        @error('pendidikan_terakhir')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Makanan</label>
                        <div class="input-group">
                            <input type="text" wire:model="makanan.0.nama" placeholder="Makanan 1" class="form-control">
                            <input type="text" wire:model="makanan.1.nama" placeholder="Makanan 2" class="form-control">
                            <input type="text" wire:model="makanan.2.nama" placeholder="Makanan 3" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Minuman</label>
                        <div class="input-group">
                            <input type="text" wire:model="minuman.0.nama" placeholder="Minuman 1" class="form-control">
                            <input type="text" wire:model="minuman.1.nama" placeholder="Minuman 2" class="form-control">
                            <input type="text" wire:model="minuman.2.nama" placeholder="Minuman 3" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Hobi</label>
                        <div class="input-group">
                            <input type="text" wire:model="hobi.0.nama" placeholder="Hobi 1" class="form-control">
                            <input type="text" wire:model="hobi.1.nama" placeholder="Hobi 2" class="form-control">
                            <input type="text" wire:model="hobi.2.nama" placeholder="Hobi 3" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Apresiasi</label>
                        <div class="input-group">
                            <select wire:model="jenis_apresiasi" class="form-select">
                                @foreach (App\Models\User::APPRECIATION_CHOICE as $key => $name)    
                                    <option value="{{$name}}">{{$name}}</option>
                                @endforeach
                            </select>
                            <input type="text" wire:model="keterangan_apresiasi" placeholder="Keterangan" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Bank</label>
                        <div class="input-group">
                            <select wire:model="nama_bank" class="form-select">
                                @foreach (App\Models\User::NAMA_BANK_CHOICE as $key => $name)    
                                    <option value="{{$name}}">{{$name}}</option>
                                @endforeach
                            </select>
                            <input type="text" wire:model="no_rekening" placeholder="No Rekening" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="form-check m-2 mt-5">
                        <input class="form-check-input" type="checkbox" wire:model="status">
                        <label class="form-label ms-2 mb-2 fw-bold">
                            Penanda Aktif
                        </label>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="informasi-tambahan-tab-pane" role="tabpanel" aria-labelledby="informasi-tambahan-tab" tabindex="0">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label>KK</label>
                        <input type="file" wire:model="additional_kk" class="form-control">
            
                        @error('additional_kk')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @if($additional_kk_old)
                        <div class="border rounded p-4 text-center bg-light">
                            <i class="bi bi-file-earmark fs-1"></i>
                            <div class="mt-2">
                                {{ $additional_kk_old['name'] }}
                            </div>

                            <a href="{{ $additional_kk_old['url'] }}" download="{{$additional_kk_old['name']}}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                Download
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4 mb-2">
                        <label>Akta Kelahiran</label>
                        <input type="file" wire:model="additional_akta_kelahiran" class="form-control">
            
                        @error('additional_akta_kelahiran')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @if($additional_akta_kelahiran_old)
                        <div class="border rounded p-4 text-center bg-light">
                            <i class="bi bi-file-earmark fs-1"></i>
                            <div class="mt-2">
                                {{ $additional_akta_kelahiran_old['name'] }}
                            </div>

                            <a href="{{ $additional_akta_kelahiran_old['url'] }}" download="{{$additional_akta_kelahiran_old['name']}}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                Download
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4 mb-2">
                        <label>Ijazah</label>
                        <input type="file" wire:model="additional_ijazah" class="form-control">
            
                        @error('additional_ijazah')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @if($additional_ijazah_old)
                        <div class="border rounded p-4 text-center bg-light">
                            <i class="bi bi-file-earmark fs-1"></i>
                            <div class="mt-2">
                                {{ $additional_ijazah_old['name'] }}
                            </div>

                            <a href="{{ $additional_ijazah_old['url'] }}" download="{{$additional_ijazah_old['name']}}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                Download
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4 mb-2">
                        <label>BPJS TK</label>
                        <input type="file" wire:model="additional_bpjs_tk" class="form-control">
            
                        @error('additional_bpjs_tk')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @if($additional_bpjs_tk_old)
                        <div class="border rounded p-4 text-center bg-light">
                            <i class="bi bi-file-earmark fs-1"></i>
                            <div class="mt-2">
                                {{ $additional_bpjs_tk_old['name'] }}
                            </div>

                            <a href="{{ $additional_bpjs_tk_old['url'] }}" download="{{$additional_bpjs_tk_old['name']}}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                Download
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4 mb-2">
                        <label>KTP</label>
                        <input type="file" wire:model="additional_ktp" class="form-control">
            
                        @error('additional_ktp')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @if($additional_ktp_old)
                        <div class="border rounded p-4 text-center bg-light">
                            <i class="bi bi-file-earmark fs-1"></i>
                            <div class="mt-2">
                                {{ $additional_ktp_old['name'] }}
                            </div>

                            <a href="{{ $additional_ktp_old['url'] }}" download="{{$additional_ktp_old['name']}}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                Download
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4 mb-2">
                        <label>NPWP</label>
                        <input type="file" wire:model="additional_npwp" class="form-control">
            
                        @error('additional_npwp')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @if($additional_npwp_old)
                        <div class="border rounded p-4 text-center bg-light">
                            <i class="bi bi-file-earmark fs-1"></i>
                            <div class="mt-2">
                                {{ $additional_npwp_old['name'] }}
                            </div>

                            <a href="{{ $additional_npwp_old['url'] }}" download="{{$additional_npwp_old['name']}}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                Download
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="kontak-tab-pane" role="tabpanel" aria-labelledby="kontak-tab" tabindex="0">
                
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>No. Telp Pribadi</label>
                        <input placeholder="No. Telp Pribadi" type="text" wire:model="no_telp_pribadi" class="form-control">

                        @error('no_telp_pribadi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>No. Telp Kantor</label>
                        <input placeholder="No. Telp Kantor" type="text" wire:model="no_telp_kantor" class="form-control">

                        @error('no_telp_kantor')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Alamat Domisili</label>
                        <input placeholder="Alamat Domisili" type="text" wire:model="alamat_domisili" class="form-control">

                        @error('alamat_domisili')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Alamat Sesuai KTP</label>
                        <input placeholder="Alamat Sesuai KTP" type="text" wire:model="alamat_sesuai_ktp" class="form-control">

                        @error('alamat_sesuai_ktp')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-auto">
                                <button type="button" wire:loading.attr="disabled" class="btn btn-info btn-sm" wire:click="addEmailKantor">
                                    Tambah Email Kantor
                                </button>
                            </div>
                        </div>
                        
                        <div class="row">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Email Kantor</th>
                                        <th>Password</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($email_kantors as $index_email => $item)
                                        <tr wire:key="email-kantor-{{$index_email}}">
                                            <td>
                                                <input placeholder="Email" type="email" wire:model="email_kantors.{{$index_email}}.email" class="form-control">
                                            </td>
                                            <td>
                                                <input placeholder="Password" type="text" wire:model="email_kantors.{{$index_email}}.password" class="form-control">
                                            </td>
                                            <td>
                                                <button type="button" wire:loading.attr="disabled" class="btn btn-danger btn-sm" wire:click="removeEmailKantor('{{$index_email}}')">
                                                    <i class="ki-duotone ki-trash fs-1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="kontak-darurat-tab-pane" role="tabpanel" aria-labelledby="kontak-darurat-tab" tabindex="0">
                <div class="row">
                    <div class="col-auto">
                        <button type="button" wire:loading.attr="disabled" class="btn btn-info btn-sm" wire:click="addEmergencyContact">
                            Tambah Kontak Darurat
                        </button>
                    </div>
                </div>
                
                <div class="row">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No. telp</th>
                                <th>Hubungan Keluarga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emergency_contacts as $index_emergency_contact => $item)
                                <tr wire:key="emergency-contact-{{$index_emergency_contact}}">
                                    <td>
                                        <input placeholder="Nama" type="text" wire:model="emergency_contacts.{{$index_emergency_contact}}.nama" class="form-control">
                                    </td>
                                    <td>
                                        <input placeholder="Alamat" type="text" wire:model="emergency_contacts.{{$index_emergency_contact}}.alamat" class="form-control">
                                    </td>
                                    <td>
                                        <input placeholder="No. telp" type="text" wire:model="emergency_contacts.{{$index_emergency_contact}}.no_telp" class="form-control">
                                    </td>
                                    <td>
                                        <input placeholder="Hubungan Keluarga" type="text" wire:model="emergency_contacts.{{$index_emergency_contact}}.hubungan_keluarga" class="form-control">
                                    </td>
                                    <td>
                                        <button type="button" wire:loading.attr="disabled" class="btn btn-danger btn-sm" wire:click="removeEmergencyContact('{{$index_emergency_contact}}')">
                                            <i class="ki-duotone ki-trash fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
            

        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary mt-3">
            Save
        </button>
        

    </form>

</div>

@push('css')
    <style>
        input[type=checkbox] {
            /* Double-sized Checkboxes */
            -ms-transform: scale(1.2);
            /* IE */
            -moz-transform: scale(1.2);
            /* FF */
            -webkit-transform: scale(1.2);
            /* Safari and Chrome */
            -o-transform: scale(1.2);
            /* Opera */
            padding: 10px;
        }
        @keyframes pulse-wand {
            0%   { transform: scale(1);   opacity: 1; }
            50%  { transform: scale(1.2); opacity: 0.7; }
            100% { transform: scale(1);   opacity: 1; }
        }

        .animate-wand {
            animation: pulse-wand 1s infinite ease-in-out;
        }
    </style>
@endpush