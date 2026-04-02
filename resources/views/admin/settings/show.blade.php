<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0 section-title">Setting Details</h2></x-slot>
    <div class="container">
        <x-flash-message />
        <div class="card page-card">
            <div class="card-body p-4">
                <dl class="row mb-0">
                    <dt class="col-md-3">Key</dt>
                    <dd class="col-md-9">{{ $setting->key }}</dd>

                    <dt class="col-md-3">Value</dt>
                    <dd class="col-md-9">{{ is_array($setting->value) ? json_encode($setting->value) : $setting->value }}</dd>

                    <dt class="col-md-3">Type</dt>
                    <dd class="col-md-9">{{ $setting->type }}</dd>

                    <dt class="col-md-3">Group</dt>
                    <dd class="col-md-9">{{ $setting->group_name }}</dd>

                    <dt class="col-md-3">Autoload</dt>
                    <dd class="col-md-9">{{ $setting->autoload ? 'Yes' : 'No' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>