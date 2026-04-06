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
                <label>Nama Barang</label>
                <input placeholder="Nama Barang" type="text" wire:model="nama_barang" class="form-control">

                @error('nama_barang')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Nomor Seri</label>
                <input placeholder="Nomor Seri" type="text" wire:model="serial_number" class="form-control">

                @error('serial_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Status Kondisi</label>
                <select wire:model="status_kondisi" class="form-select">
                    <option value="">-- ISI --</option>
                    @foreach (App\Models\Company\CompanyAsset::STATUS_KONDISI_CHOICE as $key => $name)    
                        <option value="{{$name}}">{{$name}}</option>
                    @endforeach
                </select>
                
                @error('status_kondisi')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Status Pembelian</label>
                <select wire:model="status_kondisi" class="form-select">
                    <option value="">-- ISI --</option>
                    @foreach (App\Models\Company\CompanyAsset::STATUS_PEMBELIAN_CHOICE as $key => $name)    
                        <option value="{{$name}}">{{$name}}</option>
                    @endforeach
                </select>

                @error('status_pembelian')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Divisi</label>
                <select wire:model="divisi" class="form-select">
                    <option value="">-- ISI --</option>
                    @foreach (App\Models\User::DIVISI_CHOICE as $key => $name)    
                        <option value="{{$name}}">{{$name}}</option>
                    @endforeach
                </select>

                @error('divisi')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Brand</label>
                <input placeholder="Brand" type="text" wire:model="brand" class="form-control">

                @error('brand')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Keterangan</label>
                <input placeholder="Keterangan" type="text" wire:model="keterangan" class="form-control">

                @error('keterangan')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Pengguna saat ini</label>
                <select wire:model="assigned_user_id" class="form-select">
                    <option value="">-- ISI --</option>
                    @foreach ($user_choice as $key => $name)    
                        <option value="{{$key}}">{{$name}}</option>
                    @endforeach
                </select>

                @error('assigned_user_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
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