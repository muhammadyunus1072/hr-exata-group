<div class="row">
        <div class="col-auto mb-4">
        <div class="w-100" wire:ignore>
            <label>Jenis Aset</label>
            <select class="form-select" wire:model.live="jenis">
                <option value="">Semua</option>
                @foreach (App\Models\Company\CompanyAsset::JENIS_CHOICE as $key => $name)    
                    <option value="{{$key}}">{{$name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>