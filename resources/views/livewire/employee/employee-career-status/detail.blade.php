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
            <div class="col-auto">
                <button type="button" wire:loading.attr="disabled" class="btn btn-info btn-sm" wire:click="addCareerStatus">
                    Tambah Status Karir
                </button>
            </div>
        </div>
        
        <div class="row">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Nama Karir</th>
                        <th>Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employee_career_statuses as $index_sattus => $item)
                        <tr wire:key="career-status-{{$index_sattus}}">
                            <td>
                                <input placeholder="Email" type="email" wire:model="email_kantors.{{$index_sattus}}.email" class="form-control">
                            </td>
                            <td>
                                <input placeholder="Password" type="text" wire:model="email_kantors.{{$index_sattus}}.password" class="form-control">
                            </td>
                            <td>
                                <button type="button" wire:loading.attr="disabled" class="btn btn-danger btn-sm" wire:click="removeEmailKantor('{{$index_sattus}}')">
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