<div>
    <div class="dropdown nxl-h-item nxl-header-language d-none d-sm-flex">
        <a href="javascript:void(0);" class="nxl-head-link me-0 nxl-language-link" data-bs-toggle="dropdown" data-bs-auto-close="outside">
            <img src="{{ asset('assets/vendors/img/flags/4x3/' . ($currentLocale == 'en' ? 'us' : 'sa') . '.svg') }}" alt="" class="img-fluid wd-20" />
        </a>
        <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-language-dropdown">
            <div class="dropdown-divider mt-0"></div>
            <div class="language-items-wrapper">
                <div class="select-language px-4 py-2 hstack justify-content-between gap-4">
                    <div class="lh-lg">
                        <h6 class="mb-0">{{ __('Select Language') }}</h6>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="row px-4 pt-3">
                    @foreach($locales as $locale => $name)
                        <div class="col-sm-6 col-6 language_select {{ $currentLocale == $locale ? 'active' : '' }}">
                            <a href="javascript:void(0);" wire:click="setLocale('{{ $locale }}')" class="d-flex align-items-center gap-2">
                                <div class="avatar-image avatar-sm">
                                    <img src="{{ asset('assets/vendors/img/flags/1x1/' . ($locale == 'en' ? 'us' : 'sa') . '.svg') }}" alt="" class="img-fluid" />
                                </div>
                                <span>{{ $name }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
