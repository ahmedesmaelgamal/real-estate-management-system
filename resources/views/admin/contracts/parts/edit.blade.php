<div>
    <form id="editForm" data-id="{{ $obj->id }}" class="editForm contract_form" method="POST"
        enctype="multipart/form-data" action="{{ $updateRoute }}">
        @csrf
        @method('PUT')
        <div class="row">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" autocomplete="off">


            {{-- ================= المعلومات الأساسية ================= --}}
            <div class="d-flex" style="flex-direction: column; padding-right: 15px;">
                <h5 class="fw-bold" style="color: #00F3CA;">{{ trns('main_information') }}</h5>
                <p class="association-sub-para">
                    {{ trns('you_can_start_with_creation_of_contract_adn_control_main_information_from_here') }}</p>
            </div>
            {{-- <hr class="divider"> --}}






            {{-- Contract Type --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="contract_type" class="form-control-label">
                        {{ trns('the_contract_type') }}<span class="text-danger">*</span>
                    </label>
                    <select class="form-control" name="contract_type" id="contract_type">
                        <option value="general" {{ $obj->contract_type === 'general' ? 'selected' : '' }}>
                            {{ trns('general_contract') }}
                        </option>
                        <option value="association" {{ $obj->contract_type === 'association' ? 'selected' : '' }}>
                            {{ trns('association') }}
                        </option>
                        <option value="owners_with_owner"
                            {{ $obj->contract_type === 'owners_with_owner' ? 'selected' : '' }}>
                            {{ trns('owners_with_owner') }}
                        </option>
                        <option value="owners_with_partner"
                            {{ $obj->contract_type === 'owners_with_partner' ? 'selected' : '' }}>
                            {{ trns('owners_with_partner') }}
                        </option>
                    </select>
                </div>
            </div>

            {{-- Association for association type --}}
            <div class="col-8 poth-container" id="asssociation" style="display:none;">
                <div class="form-group">
                    <label>{{ trns('association') }}</label>
                    <select class="form-control" name="association_id" id="association_id">
                        {{-- <option value="">{{ trns('chose_association') }}</option> --}}
                        @foreach ($associations as $assoc)
                            <option value="{{ $assoc->id }}" {{ $obj->association_id == $assoc->id ? '' : '' }}>
                                {{ $assoc->getTranslation('name', app()->getLocale()) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- For owners_with_owner --}}
            <div class="col-8 poth-container" id="user_asssociation" style="display:none;">
                <div class="form-group">
                    <label>{{ trns('association') }}</label>
                    <select class="form-control" name="user_association_id" id="user_association_id">
                        {{-- <option value="">{{ trns('chose_association') }}</option> --}}
                        @foreach ($associations as $assoc)
                            <option value="{{ $assoc->id }}"
                                {{ $obj->user_association_id == $assoc->id ? '' : '' }}>
                                {{ $assoc->getTranslation('name', app()->getLocale()) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- For owners_with_partner --}}
            <div class="col-8 poth-container" id="user_partner_association" style="display:none;">
                <div class="form-group">
                    <label>{{ trns('association') }}</label>
                    <select class="form-control" name="user_partner_association_id" id="user_partner_association_id">
                        {{-- <option value="">{{ trns('chose_association') }}</option> --}}
                        @foreach ($associations as $assoc)
                            <option value="{{ $assoc->id }}"
                                {{ $obj->user_partner_association_id == $assoc->id ? '' : '' }}>
                                {{ $assoc->getTranslation('name', app()->getLocale()) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <hr style="opacity: 1 !important; margin-top:20px ;">







            {{-- type --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="contract_type_id" class="form-control-label">{{ trns('contract_type') }}<span
                            class="text-danger">*</span></label>
                    <select class="form-control" name="contract_type_id" id="contract_type_id">
                        @foreach ($contractTypes as $contractType)
                            <option value="{{ $contractType->id }}"
                                {{ old('contract_type_id', $obj->contract_type_id ?? '') == $contractType->id ? 'selected' : '' }}>
                                {{ $contractType->getTranslation('title', app()->getLocale()) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- name --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="contract_name_id" class="form-control-label">{{ trns('contract_name') }}<span
                            class="text-danger">*</span></label>
                    <select class="form-control" name="contract_name_id" id="contract_name_id">
                        @foreach ($contractNames as $contractName)
                            <option value="{{ $contractName->id }}"
                                {{ old('contract_name_id', $obj->contract_name_id ?? '') == $contractName->id ? 'selected' : '' }}>
                                {{ $contractName->getTranslation('name', app()->getLocale()) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Date --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="date" class="form-control-label">{{ trns('contract_date') }}<span
                            class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="date" id="date"
                        value="{{ old('date', isset($obj->date) ? $obj->date->format('Y-m-d') : '') }}">
                </div>
            </div>

            {{-- location --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="contract_location_id" class="form-control-label">
                        {{ trns('contract_location') }}<span class="text-danger">*</span>
                    </label>

                    <select class="form-control" name="contract_location_id" id="contract_location_id">
                        <option value="">{{ trns('select_location') }}</option>
                        @foreach ($contractLocations as $contractLocation)
                            <option value="{{ $contractLocation->id }}"
                                {{ old('contract_location_id', $obj->contract_location_id ?? '') == $contractLocation->id ? 'selected' : '' }}>
                                {{ $contractLocation->getTranslation('title', app()->getLocale()) }}
                            </option>
                        @endforeach
                        {{-- خيار أخرى --}}
                        <option value="other"
                            {{ old('contract_location_id', $obj->contract_location_id ? '' : 'other') == 'other' ? 'selected' : '' }}>
                            {{ trns('others') }}
                        </option>
                    </select>
                </div>
            </div>

            {{-- contract location (input يظهر عند اختيار "other") --}}
            <div class="col-4" id="contract_location_wrapper" style="display: none;">
                <div class="form-group">
                    <label for="contract_location" class="form-control-label">
                        {{ trns('contract_location') }}
                    </label>
                    <input type="text" class="form-control" name="contract_location" id="contract_location"
                        value="{{ old('contract_location', $obj->contract_location ?? '') }}">
                </div>
            </div>



            {{-- contract address --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="contract_address" class="form-control-label">{{ trns('contract_address') }}</label>
                    <input type="text" class="form-control" name="contract_address" id="contract_address"
                        value="{{ old('contract_address', $obj->contract_address ?? '') }}">
                </div>
            </div>

            <hr class="divider">

            {{-- ================= معلومات الأطراف ================= --}}
            <div class="d-flex" style="flex-direction: column; padding-right: 15px;">
                <h5 class="fw-bold" style="color: #00F3CA;">{{ trns('contract_parties') }}</h5>
                <p class="association-sub-para">
                    {{ trns('add_the_contract_parties_and_there_agent_or_who_Acting_on_their_behalf') }}</p>
            </div>




            <div class="row col-12 mb-3" id="association_details" style=" display: none; " disabled>
                <div class="col-4">
                    <label class="form-control-label fw-bold" style="font-size: 18px; color: black;">
                        {{ trns('association_name') }}</label>
                    <input type="text" class="form-control" disabled value="{{ old('association_name') }}"
                        name="association_name" id="association_name"
                        placeholder="{{ $obj->association?->getTranslation('name', app()->getLocale()) ?? '-' }}">
                </div>
                <div class="col-4">
                    <label class="form-control-label fw-bold" style="font-size: 18px; color: black;">
                        {{ trns('association_number') }}</label>
                    <input type="text" class="form-control" disabled value="{{ old('association_number') }}"
                        name="association_number" id="association_number"
                        placeholder="{{ $obj->association?->number }}">
                </div>
                <div class="col-4">
                    <label class="form-control-label fw-bold" style="font-size: 18px; color: black;">
                        {{ trns('establish_date') }}</label>
                    <input type="text" class="form-control" disabled
                        value="{{ old('association_establish_date') }}" name="association_establish_date"
                        id="association_establish_date" placeholder="{{ $obj->association?->establish_date }}">
                </div>
            </div>




            {{-- First Party --}}
            <div class="col-4" id="contract_first_party">
                <div class="form-group">
                    <label for="contract_party_id"
                        class="form-control-label">{{ 1 . ' ' . trns('first_party_of_contract') }}<span
                            class="text-danger"></span></label>
                    <select class="form-control" name="contract_party_id" id="contract_party_id">
                        @foreach ($parties as $party)
                            <option value="{{ $party->id }}"
                                {{ old('contract_party_id', $obj->contract_first_party_id ?? '') == $party->id ? 'selected' : '' }}>
                                {{ $party->getTranslation('title', app()->getLocale()) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-4" id="association_admin" style="display: none;">
                <div class="form-group">
                    <label for="association_admin_id"
                        class="form-control-label">{{ 1 . ' ' . trns('association_admin') }}<span
                            class="text-danger"></span></label>
                    <select class="form-control" name="association_admin_id" id="association_admin_id">

                    </select>
                </div>
            </div>

            <div class="col-4" id="first_association_user" style="display: none;">
                <div class="form-group">
                    <label for="first_association_user_id"
                        class="form-control-label">{{ 1 . ' ' . trns('association_user') }}<span
                            class="text-danger"></span></label>
                    <select class="form-control" name="first_association_user_id" id="first_association_admin_id">

                    </select>
                </div>
            </div>


            {{-- @dd($obj->firstParties) --}}

            {{-- Party One Details --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="party_name_first" class="form-control-label">{{ trns('full_name') }}</label>
                    <input type="text" class="form-control" name="party_name[first]" id="party_name_first"
                        value="{{ old('party_name.first', $obj->firstParties->first()?->party_name) }}">

                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="party_nation_id_first" class="form-control-label">{{ trns('national_id') }}</label>
                    <input type="number" class="form-control" name="party_nation_id[first]"
                        id="party_nation_id_first"
                        value="{{ old('party_nation_id.first', $obj->firstParties->first()?->party_nation_id ?? '') }}"
                        maxlength="10" oninput="if(this.value.length > 10) this.value = this.value.slice(0,10);">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="party_phone_first" class="form-control-label">{{ trns('phone') }}</label>
                    <input type="number" class="form-control" name="party_phone[first]" id="party_phone_first"
                        value="{{ old('party_phone.first', $obj->firstParties->first()?->party_phone ?? '') }}"
                        maxlength="11" oninput="if(this.value.length > 11) this.value = this.value.slice(0,11);">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="party_email_first" class="form-control-label">{{ trns('email') }}</label>
                    <input type="email" class="form-control" name="party_email[first]" id="party_email_first"
                        value="{{ old('party_email.first', $obj->firstParties->first()?->party_email ?? '') }}">
                </div>
            </div>
            <div class="col-4 mb-4">
                <div class="form-group">
                    <label for="party_address_first" class="form-control-label">{{ trns('address') }}</label>
                    <input type="text" class="form-control" name="party_address[first]" id="party_address_first"
                        value="{{ old('party_address.first', $obj->firstParties->first()?->party_address ?? '') }}">
                </div>
            </div>

            <hr>

            {{-- Second Party --}}

            <div class="col-4 " id="contract_second_party">
                <div class="form-group">
                    <label for="contract_party_two_id"
                        class="form-control-label">{{ 2 . ' ' . trns('second_party_of_contract') }}</label>
                    <select class="form-control" name="contract_party_two_id" id="contract_party_two_id">
                        @foreach ($parties as $party)
                            <option value="{{ $party->id }}"
                                {{ old('contract_party_id', $obj->contract_second_party_id ?? '') == $party->id ? 'selected' : '' }}>
                                {{ $party->getTranslation('title', app()->getLocale()) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-4" id="second_association_user" style="display: none;">
                <div class="form-group">
                    <label for="second_association_user_id"
                        class="form-control-label">{{ 1 . ' ' . trns('association_user') }}<span
                            class="text-danger"></span></label>
                    <select class="form-control" name="second_association_user_id" id="second_association_admin_id">

                    </select>
                </div>
            </div>


            {{-- Party Two Details --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="party_name_second" class="form-control-label">{{ trns('full_name') }}</label>
                    <input type="text" class="form-control" name="party_name[second]" id="party_name_second"
                        value="{{ old('party_name.second', $obj->secondParties->first()?->party_name ?? '') }}">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="party_nation_id_second" class="form-control-label">{{ trns('national_id') }}</label>
                    <input type="number" class="form-control" name="party_nation_id[second]"
                        id="party_nation_id_second"
                        value="{{ old('party_nation_id.second', $obj->secondParties->first()?->party_nation_id ?? '') }}"
                        maxlength="10" oninput="if(this.value.length > 10) this.value = this.value.slice(0,10);">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="party_phone_second" class="form-control-label">{{ trns('phone') }}</label>
                    <input type="number" class="form-control" name="party_phone[second]" id="party_phone_second"
                        value="{{ old('party_phone.second', $obj->secondParties->first()?->party_phone ?? '') }}"
                        maxlength="11" oninput="if(this.value.length > 11) this.value = this.value.slice(0,11);">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="party_email_second" class="form-control-label">{{ trns('email') }}</label>
                    <input type="email" class="form-control" name="party_email[second]" id="party_email_second"
                        value="{{ old('party_email.second', $obj->secondParties->first()?->party_email ?? '') }}">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="party_address_second" class="form-control-label">{{ trns('address') }}</label>
                    <input type="text" class="form-control" name="party_address[second]"
                        id="party_address_second"
                        value="{{ old('party_address.second', $obj->secondParties->first()?->party_address ?? '') }}">
                </div>
            </div>

            <hr class="divider">

            {{-- ================= المقدمة ================= --}}
            <div class="d-flex" style="flex-direction: column; padding-right: 15px;">
                <h5 class="fw-bold" style="color: black;">{{ trns('introduction') }}</h5>
                <p class="association-sub-para">{{ trns('information_about_contract_reason') }}</p>
            </div>

            {{-- introduction --}}
            <div class="col-12">
                <div class="form-group">
                    <label for="introduction" class="form-control-label">{{ trns('introduction') }}</label>
                    <textarea class="form-control" name="introduction" id="introduction" rows="3">{{ old('introduction', $obj->introduction ?? '') }}</textarea>
                </div>
            </div>

            {{-- contract terms --}}
            <div class="col-12">
                <div class="form-group">
                    <h4 for="lat" class="form-control-label" style="display:block">
                        {{ trns('contract_terms') }}
                    </h4>
                    <label for="lat" class="form-control-label">
                        {{ trns('contract_terms_main_guide') }}
                    </label>
                    @php
                        $selectedTerms = old('contract_term_id', $obj->contractTerms->pluck('id')->toArray());
                    @endphp

                    @php $selectedTerms = old('contract_term_id', $obj->contractTerms->pluck('id')->toArray()); @endphp
                    <div class="mt-2 row">

                        @foreach ($contractTerms as $contractTerm)
                            <div class="col-12 mb-3">
                                <div
                                    class="card custom-checkbox-card {{ in_array($contractTerm->id, $selectedTerms) ? '' : '' }}">
                                    <input class="form-check-input d-none" type="checkbox" name="contract_term_id[]"
                                        id="template{{ $loop->index + 1 }}" value="{{ $contractTerm->id }}" checked>

                                    <label for="template{{ $loop->index + 1 }}" class="card-body w-100"
                                        style="pointer-events: none;">
                                        <h5 class="association-card-header" style="font-weight: bold;">
                                            {{ $contractTerm->getTranslation('title', app()->getLocale()) }}
                                        </h5>
                                        <p class="association-card-para" style="color: #b5b5c3;">
                                            {{ $contractTerm->description }}
                                        </p>
                                    </label>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="display:flex; justify-content: flex-end;">
                        <button type="button" class="createTerm btn btn-icon text-white">
                            {{ trns('create_Term') }}
                        </button>
                    </div>


                </div>
            </div>

            <!-- Create Or Edit Modal -->
            <div class="modal fade" id="termCreateModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ trns('create_term') }}</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body_termCreateModal" id="modal-body_termCreateModal"></div>
                        <div class="modal-footer_termCreateModal" id="modal-footer_termCreateModal"></div>
                    </div>
                </div>
            </div>
            <!-- Create Or Edit Modal END -->
        </div>
    </form>
</div>








<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        display: flex;
        align-items: center;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
</style>



<style>
    .select-display {
        background-color: #343a40;
        color: #fff;
        padding: 3px 20px;
        border-radius: 8px;
        display: inline-block;
        font-weight: 500;
    }

    .select2-container--default .select2-selection--multiple {
        padding: 0.305rem 0.60rem;
    }
</style>

<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        display: flex;
        align-items: center;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
</style>



<style>
    .select-display {
        background-color: #343a40;
        color: #fff;
        padding: 3px 20px;
        border-radius: 8px;
        display: inline-block;
        font-weight: 500;
    }

    .select2-container--default .select2-selection--multiple {
        padding: 0.305rem 0.60rem;
    }
</style>


<script>
    $(document).ready(function() {
        $('#contract_type').on('change', function() {
            var selectedType = $(this).val();

            if (selectedType === 'association') {
                $('#asssociation').show();
                $('#first_association_user').hide();
                $("#association_details").show();
                $("#association_admin").show();
                $("#association_admin_id").show();
                $("#contract_party_id").hide();
                $("#user_partner_association").hide();
                $("#user_asssociation").hide();
                $('#association_name').show();
                $('#association_number').show();
                $('#association_establish_date').show();
                $("#association_details").show();
                $("#party_name_second").val("");
                $("#party_name_second").prop('readonly', false);
                $("#party_nation_id_second").val("");
                $("#party_nation_id_second").prop("readonly", false);
                $("#party_phone_second").val("");
                $("#party_phone_second").prop("readonly", false);
                $("#party_email_second").val("");
                $("#party_email_second").prop("readonly", false);
                $("#party_name_first").val("");
                $("#party_name_first").prop('readonly', false);
                $("#party_nation_id_first").val("");
                $("#party_nation_id_first").prop("readonly", false);
                $("#party_phone_first").val("");
                $("#party_phone_first").prop("readonly", false);
                $("#party_email_first").val("");
                $("#contract_first_party").hide();
                $("#party_email_first").prop("readonly", false);


                $("#first_association_admin_id").empty();
                $("#second_association_admin_id").empty();


                $("#first_association_admin_id").append(
                    '<option value="" selected>{{ trns('select_user') }}</option>'
                );
                $("#second_association_admin_id").append(
                    '<option value="" selected>{{ trns('select_user') }}</option>'
                );

                $("#first_association_admin_id, #second_association_admin_id").val(null).trigger(
                    'change');
            } else if (selectedType == 'owners_with_owner') {
                $('#user_asssociation').show();
                $("#association_details").show();
                $("#first_association_user").show();
                $("#second_association_user").show();
                $("#contract_first_party").hide();
                $("#association_admin").hide();
                $("#contract_second_party").hide();
                $("#asssociation").hide();
                $("#user_partner_association").hide();
                $("#party_name_second").val("");
                $("#party_name_second").prop('readonly', false);
                $("#party_nation_id_second").val("");
                $("#party_nation_id_second").prop("readonly", false);
                $("#party_phone_second").val("");
                $("#party_phone_second").prop("readonly", false);
                $("#party_email_second").val("");
                $("#party_email_second").prop("readonly", false);
                $("#party_name_first").val("");
                $("#party_name_first").prop('readonly', false);
                $("#party_nation_id_first").val("");
                $("#party_nation_id_first").prop("readonly", false);
                $("#party_phone_first").val("");
                $("#party_phone_first").prop("readonly", false);
                $("#party_email_first").val("");
                $("#party_email_first").prop("readonly", false);


                $("#first_association_admin_id").empty();
                $("#second_association_admin_id").empty();


                $("#first_association_admin_id").append(
                    '<option value="" selected>{{ trns('select_user') }}</option>'
                );
                $("#second_association_admin_id").append(
                    '<option value="" selected>{{ trns('select_user') }}</option>'
                );

                $("#first_association_admin_id, #second_association_admin_id").val(null).trigger(
                    'change');
            } else if (selectedType == 'owners_with_partner') {
                $('#user_partner_association').show();
                $('#user_asssociation').hide();
                $('#second_association_user').hide();
                $("#association_details").show();
                $("#first_association_user").show();
                $("#contract_first_party").hide();
                $("#contract_second_party").show();
                $("#association_admin").hide();
                $("#asssociation").hide();



                $("#first_association_admin_id").empty();
                $("#second_association_admin_id").empty();


                $("#first_association_admin_id").append(
                    '<option value="" selected>{{ trns('select_user') }}</option>'
                );
                $("#second_association_admin_id").append(
                    '<option value="" selected>{{ trns('select_user') }}</option>'
                );

                $("#first_association_admin_id, #second_association_admin_id").val(null).trigger(
                    'change');



                $("#party_name_second").val("");
                $("#party_name_second").prop('readonly', false);
                $("#party_nation_id_second").val("");
                $("#party_nation_id_second").prop("readonly", false);
                $("#party_phone_second").val("");
                $("#party_phone_second").prop("readonly", false);
                $("#party_email_second").val("");
                $("#party_email_second").prop("readonly", false);
                $("#party_name_first").val("");
                $("#party_name_first").prop('readonly', false);
                $("#party_nation_id_first").val("");
                $("#party_nation_id_first").prop("readonly", false);
                $("#party_phone_first").val("");
                $("#party_phone_first").prop("readonly", false);
                $("#party_email_first").val("");
                $("#party_email_first").prop("readonly", false);
            } else {

                $('#user_asssociation').hide();
                $("#first_association_user").hide();
                $("#second_association_user").hide();
                $('#asssociation').hide();
                $("#contract_first_party").show();
                $("#contract_second_party").show();
                $("#contract_party_id").show();
                $('#association_id').val(null).trigger('change');
                $('#association_name').hide();
                $('#association_number').hide();
                $('#association_establish_date').hide();
                $("#association_details").hide();
                $("#association_admin").hide();


                $("#association_admin_id").hide();


                $("#party_name_second").val("");
                $("#party_name_second").prop('readonly', false);
                $("#party_nation_id_second").val("");
                $("#party_nation_id_second").prop("readonly", false);
                $("#party_phone_second").val("");
                $("#party_phone_second").prop("readonly", false);
                $("#party_email_second").val("");
                $("#party_email_second").prop("readonly", false);
                $("#party_name_first").val("");
                $("#party_name_first").prop('readonly', false);
                $("#party_nation_id_first").val("");
                $("#party_nation_id_first").prop("readonly", false);
                $("#party_phone_first").val("");
                $("#party_phone_first").prop("readonly", false);
                $("#party_email_first").val("");
                $("#party_email_first").prop("readonly", false);


                $("#first_association_admin_id").empty();
                $("#second_association_admin_id").empty();


                $("#first_association_admin_id").append(
                    '<option value="" selected>{{ trns('select_user') }}</option>'
                );
                $("#second_association_admin_id").append(
                    '<option value="" selected>{{ trns('select_user') }}</option>'
                );

                $("#first_association_admin_id, #second_association_admin_id").val(null).trigger(
                    'change');



            }


            $('#party_name_first').val(
                `{{ old('party_name.first', $obj->firstParties->first()?->party_name ?? '') }}`);
            $('#party_nation_id_first').val(
                `{{ old('party_nation_id.first', $obj->firstParties->first()?->party_nation_id ?? '') }}`
            );
            $('#party_phone_first').val(
                `{{ old('party_phone.first', $obj->firstParties->first()?->party_phone ?? '') }}`);
            $('#party_email_first').val(
                `{{ old('party_email.first', $obj->firstParties->first()?->party_email ?? '') }}`);
            $('#party_address_first').val(
                `{{ old('party_address.first', $obj->firstParties->first()?->party_address ?? '') }}`
            );

            // قيم الطرف الثاني
            $('#party_name_second').val(
                `{{ old('party_name.second', $obj->secondParties->first()?->party_name ?? '') }}`);
            $('#party_nation_id_second').val(
                `{{ old('party_nation_id.second', $obj->secondParties->first()?->party_nation_id ?? '') }}`
            );
            $('#party_phone_second').val(
                `{{ old('party_phone.second', $obj->secondParties->first()?->party_phone ?? '') }}`
            );
            $('#party_email_second').val(
                `{{ old('party_email.second', $obj->secondParties->first()?->party_email ?? '') }}`
            );
            $('#party_address_second').val(
                `{{ old('party_address.second', $obj->secondParties->first()?->party_address ?? '') }}`
            );


        });

        // Trigger change event on page load to set the initial state
        $('#contract_type').trigger('change');



        // handle admin association change 
        $('#association_id').on('change', function() {
            var associationId = $(this).val();
            if (associationId) {

                $.ajax({
                    url: "{{ route('association.byId', ['id' => '__ID__']) }}"
                        .replace('__ID__', $('#association_id').val()),
                    method: 'GET',
                    success: function(data) {
                        if (data.status === 200) {
                            var association = data.data;
                            $("#association_details").show();

                            // لو الكود داخل Blade يمكن استخدام app locale هنا:
                            var locale = '{{ app()->getLocale() }}';

                            var name = '';
                            // الحالة 1: API رجع الحقل name كمجال نصي مباشر
                            if (association.name && typeof association.name === 'string') {
                                name = association.name;
                            }
                            // الحالة 2: API رجع object للترجمات: { en: '...', ar: '...' }
                            else if (association.name && typeof association.name ===
                                'object') {
                                name = association.name[locale] ?? association.name[Object
                                    .keys(association.name)[0]] ?? '';
                            }
                            // الحالة 3: ممكن السيرفر رجع translations: { ar: { name: '...' }, ... }
                            else if (association.translations && association.translations[
                                    locale]) {
                                name = association.translations[locale].name ?? '';
                            }
                            $('#association_name').val(name);
                            $('#association_name').prop('readonly', true);
                            $('#association_number').val(association.number ?? '');
                            $('#association_number').prop('readonly', true);
                            $('#association_establish_date').val(association
                                .establish_date ?? '');
                            $('#association_establish_date').prop('readonly', true);
                        } else {
                            $('#association_name').val('');
                            $('#association_number').val('');
                            $('#association_establish_date').val('');
                        }
                    },

                    error: function() {
                        $('#association_name').val('');
                        $('#association_number').val('');
                    }
                })
                $.ajax({
                    url: "{{ route('association.getAdmin', ['id' => '__ID__']) }}"
                        .replace('__ID__', $('#association_id').val()),
                    method: 'GET',
                    success: function(data) {
                        if (data.status === 200) {
                            var admin = data.admin;
                            var $asssociationSelect = $('#association_id');
                            // $asssociationSelect.empty();
                            $("#contract_first_party").hide();
                            $("#association_admin").show();
                            $("#association_admin_id")
                                .html(
                                    `<option value="${admin.id}" selected>${admin.name}</option>`
                                )
                                .trigger('change');

                            $("#association_admin_id").prop('readonly', true);
                            $("#party_name_first").val(admin.name);
                            $("#party_name_first").prop('readonly', true);
                            $("#party_nation_id_first").prop('readonly', true);
                            $("#party_nation_id_first").val(admin.national_id);
                            $("#party_phone_first").prop('readonly', true);
                            $("#party_phone_first").val(admin.phone);
                            $("#party_email_first").prop('readonly', true);
                            $("#party_email_first").val(admin.email);

                            // $asssociationSelect.append(
                            //     `<option value="${admin.id}">${admin.name}</option>`);
                        } else {
                            $('#association_id').empty().append(
                                `<option value="">{{ trns('no_admin_found') }}</option>`
                            );
                        }
                    }
                });
            } else {
                $("#association_admin_id").empty().append(
                    '<option value="">{{ trns('select_admin') }}</option>');
            }
        });


        // handle the user association change 
        $('#user_association_id').on('change', function() {
            var associationId = $(this).val();

            if (associationId) {
                // ========== 1. Get Association Details ==========
                $.ajax({
                    url: "{{ route('association.byId', ['id' => '__ID__']) }}"
                        .replace('__ID__', associationId),
                    method: 'GET',
                    success: function(data) {
                        if (data.status === 200) {
                            var association = data.data;
                            $("#association_details").show();

                            var locale = '{{ app()->getLocale() }}';
                            var name = '';

                            if (association.name && typeof association.name === 'string') {
                                name = association.name;
                            } else if (association.name && typeof association.name ===
                                'object') {
                                name = association.name[locale] ??
                                    association.name[Object.keys(association.name)[0]] ??
                                    '';
                            } else if (association.translations && association.translations[
                                    locale]) {
                                name = association.translations[locale].name ?? '';
                            }

                            $('#association_name').val(name).prop('readonly', true);
                            $('#association_number').val(association.number ?? '').prop(
                                'readonly', true);
                            $('#association_establish_date').val(association
                                .establish_date ?? '').prop('readonly', true);
                        } else {
                            $('#association_name, #association_number, #association_establish_date')
                                .val('');
                        }
                    },
                    error: function() {
                        $('#association_name, #association_number, #association_establish_date')
                            .val('');
                    }
                });

                // ========== 2. Get Association Users ==========
                $.ajax({
                    url: "{{ route('association.getUsers', ['id' => '__ID__']) }}"
                        .replace('__ID__', associationId),
                    method: 'GET',
                    success: function(data) {
                        if (data.status === 200) {
                            var users = data.users || [];
                            var admin = data.admin;

                            // إظهار الحقول
                            $("#first_association_user, #second_association_user").show();

                            // تفريغ القديم
                            $("#first_association_admin_id, #second_association_admin_id")
                                .empty();

                            // تعبئة المستخدمين في القائمتين
                            if (users.length > 0) {
                                $("#first_association_admin_id").append(
                                    '<option value="">{{ trns('select_user') }}</option>'
                                );
                                $("#second_association_admin_id").append(
                                    '<option value="">{{ trns('select_user') }}</option>'
                                );
                                users.forEach(function(user) {
                                    $("#first_association_admin_id").append(
                                        `<option value="${user.id}">${user.name}</option>`
                                    );
                                    $("#second_association_admin_id").append(
                                        `<option value="${user.id}">${user.name}</option>`
                                    );
                                });
                            } else if (admin) {
                                $("#first_association_admin_id, #second_association_admin_id")
                                    .append(
                                        `<option value="${admin.id}">${admin.name}</option>`
                                    );
                            } else {
                                $("#first_association_admin_id, #second_association_admin_id")
                                    .append(
                                        `<option value="">{{ trns('no_users_found') }}</option>`
                                    );
                            }
                        } else {
                            $("#first_association_admin_id, #second_association_admin_id")
                                .empty()
                                .append(
                                    `<option value="">{{ trns('no_users_found') }}</option>`
                                );
                        }
                    },
                    error: function() {
                        $("#first_association_admin_id, #second_association_admin_id")
                            .empty()
                            .append(
                                `<option value="">{{ trns('error_loading_users') }}</option>`
                            );
                    }
                });
            } else {
                // Reset if no association selected
                $("#association_details").hide();
                $("#first_association_user, #second_association_user").hide();
                $("#first_association_admin_id, #second_association_admin_id").empty()
                    .append('<option value="">{{ trns('select_user') }}</option>');
            }
        });

        // handle the user and partner association change
        $('#user_partner_association_id').on('change', function() {
            var associationId = $(this).val();

            if (associationId) {
                // ========== 1. Get Association Details ==========
                $.ajax({
                    url: "{{ route('association.byId', ['id' => '__ID__']) }}"
                        .replace('__ID__', associationId),
                    method: 'GET',
                    success: function(data) {
                        if (data.status === 200) {
                            var association = data.data;
                            $("#association_details").show();

                            var locale = '{{ app()->getLocale() }}';
                            var name = '';

                            if (association.name && typeof association.name === 'string') {
                                name = association.name;
                            } else if (association.name && typeof association.name ===
                                'object') {
                                name = association.name[locale] ??
                                    association.name[Object.keys(association.name)[0]] ??
                                    '';
                            } else if (association.translations && association.translations[
                                    locale]) {
                                name = association.translations[locale].name ?? '';
                            }

                            $('#association_name').val(name).prop('readonly', true);
                            $('#association_number').val(association.number ?? '').prop(
                                'readonly', true);
                            $('#association_establish_date').val(association
                                .establish_date ?? '').prop('readonly', true);
                        } else {
                            $('#association_name, #association_number, #association_establish_date')
                                .val('');
                        }
                    },
                    error: function() {
                        $('#association_name, #association_number, #association_establish_date')
                            .val('');
                    }
                });

                // ========== 2. Get Association Users ==========
                $.ajax({
                    url: "{{ route('association.getUsers', ['id' => '__ID__']) }}"
                        .replace('__ID__', associationId),
                    method: 'GET',
                    success: function(data) {
                        if (data.status === 200) {
                            var users = data.users || [];
                            var admin = data.admin;

                            // إظهار الحقول
                            $("#first_association_user").show();

                            // تفريغ القديم
                            $("#first_association_admin_id, #second_association_admin_id")
                                .empty();

                            // تعبئة المستخدمين في القائمتين
                            if (users.length > 0) {
                                $("#first_association_admin_id").append(
                                    '<option value="">{{ trns('select_user') }}</option>'
                                );

                                users.forEach(function(user) {
                                    $("#first_association_admin_id").append(
                                        `<option value="${user.id}">${user.name}</option>`
                                    );

                                });
                            } else if (admin) {
                                $("#first_association_admin_id")
                                    .append(
                                        `<option value="${admin.id}">${admin.name}</option>`
                                    );
                            } else {
                                $("#first_association_admin_id")
                                    .append(
                                        `<option value="">{{ trns('no_users_found') }}</option>`
                                    );
                            }
                        } else {
                            $("#first_association_admin_id")
                                .empty()
                                .append(
                                    `<option value="">{{ trns('no_users_found') }}</option>`
                                );
                        }
                    },
                    error: function() {
                        $("#first_association_admin_id")
                            .empty()
                            .append(
                                `<option value="">{{ trns('error_loading_users') }}</option>`
                            );
                    }
                });
            } else {
                // Reset if no association selected
                $("#association_details").hide();
                $("#first_association_user, #second_association_user").hide();
                $("#first_association_admin_id").empty()
                    .append('<option value="">{{ trns('select_user') }}</option>');
            }
        });

        // handle the first user data on chose 
        // Handle user selection to fill Party One details
        $('#first_association_admin_id').on('change', function() {
            var userId = $(this).val();

            if (userId) {
                $.ajax({
                    url: "{{ route('users.get.by.id', ['id' => '__ID__']) }}".replace(
                        '__ID__',
                        userId),
                    method: 'GET',
                    success: function(data) {
                        if (data.status === 200 && data.user) {
                            var user = data.user;

                            // Fill the input fields
                            $('#party_name_first').val(user.name ?? '').prop('readonly',
                                true);
                            $('#party_nation_id_first').val(user.national_id ?? '').prop(
                                'readonly', true);
                            $('#party_phone_first').val(user.phone ?? '').prop('readonly',
                                true);
                            $('#party_email_first').val(user.email ?? '').prop('readonly',
                                true);
                        } else {
                            // Clear fields if no valid user
                            $('#party_name_first, #party_nation_id_first, #party_phone_first, #party_email_first')
                                .val('')
                                .prop('readonly', false);
                        }
                    },
                    error: function() {
                        $('#party_name_first, #party_nation_id_first, #party_phone_first, #party_email_first')
                            .val('')
                            .prop('readonly', false);
                    }
                });
            } else {
                // Clear and enable fields if no user selected
                $('#party_name_first, #party_nation_id_first, #party_phone_first, #party_email_first')
                    .val('')
                    .prop('readonly', false);
            }
        });


        // ======== Second Association User ========
        $('#second_association_admin_id').on('change', function() {
            var userId = $(this).val();

            if (userId) {
                $.ajax({
                    url: "{{ route('users.get.by.id', ['id' => '__ID__']) }}".replace(
                        '__ID__', userId),
                    method: 'GET',
                    success: function(data) {
                        if (data.status === 200 && data.user) {
                            var user = data.user;

                            // Fill the input fields
                            $('#party_name_second').val(user.name ?? '').prop('readonly',
                                true);
                            $('#party_nation_id_second').val(user.national_id ?? '').prop(
                                'readonly', true);
                            $('#party_phone_second').val(user.phone ?? '').prop('readonly',
                                true);
                            $('#party_email_second').val(user.email ?? '').prop('readonly',
                                true);
                        } else {
                            // Clear fields if no valid user
                            $('#party_name_second, #party_nation_id_second, #party_phone_second, #party_email_second')
                                .val('')
                                .prop('readonly', false);
                        }
                    },
                    error: function() {
                        $('#party_name_second, #party_nation_id_second, #party_phone_second, #party_email_second')
                            .val('')
                            .prop('readonly', false);
                    }
                });
            } else {
                // Clear and enable fields if no user selected
                $('#party_name_second, #party_nation_id_second, #party_phone_second, #party_email_second')
                    .val('')
                    .prop('readonly', false);
            }
        });



    });
</script>






































{{--  handle on open modal editing --}}

<script>
    $(document).ready(function() {

        let selectedType = $('#contract_type').val();

        if (selectedType === 'association') {
            $('#asssociation').show();
            $("#association_details").show();
            $("#contract_party_id").hide();

            $("#contract_first_party").hide();
            $("#association_admin").show();

            $("#association_id").append(
                `<option selected value="{{ $obj->association?->id }}">{{ $obj->association?->getTranslation('name', app()->getLocale()) }}</option>`
            );

            $.ajax({
                url: "{{ route('association.getAdmin', ['id' => '__ID__']) }}"
                    .replace('__ID__', {{ $obj->association?->id }}),
                method: 'GET',
                success: function(data) {
                    if (data.status === 200) {
                        var admin = data.admin;
                        var $asssociationSelect = $('#association_id');
                        // $asssociationSelect.empty();
                        $("#contract_first_party").hide();
                        $("#association_admin").show();
                        $("#association_admin_id")
                            .html(
                                `<option value="${admin.id}" selected>${admin.name}</option>`
                            )
                            .trigger('change');

                        $("#association_admin_id").prop('readonly', true);
                        $("#party_name_first").val(admin.name);
                        $("#party_name_first").prop('readonly', true);
                        $("#party_nation_id_first").prop('readonly', true);
                        $("#party_nation_id_first").val(admin.national_id);
                        $("#party_phone_first").prop('readonly', true);
                        $("#party_phone_first").val(admin.phone);
                        $("#party_email_first").prop('readonly', true);
                        $("#party_email_first").val(admin.email);

                        // $asssociationSelect.append(
                        //     `<option value="${admin.id}">${admin.name}</option>`);
                    } else {
                        $('#association_id').empty().append(
                            `<option value="">{{ trns('no_admin_found') }}</option>`
                        );
                    }
                }
            });

        } else if (selectedType === 'owners_with_owner') {
            $('#user_asssociation').show();
            $("#association_details").show();
            $("#first_association_user").show();
            $("#second_association_user").show();
            $("#contract_first_party").hide();
            $("#association_admin").hide();
            $("#association_admin").hide();
            $("#contract_second_party").hide();
            $("#asssociation").hide();

            $("#party_name_first, #party_name_second, #party_nation_id_first, #party_nation_id_second, #party_phone_first, #party_phone_second, #party_email_first, #party_email_second")
                .prop('readonly', true);

            $("#user_association_id").append(
                `<option selected value="{{ $obj->association?->id }}">{{ $obj->association?->getTranslation('name', app()->getLocale()) }}</option>`
            );

            let associationId = "{{ $obj->association?->id }}";



            let translations = {
                select_user: "{{ trns('select_user') }}",
                no_users_found: "{{ trns('no_users_found') }}",
                error_loading_users: "{{ trns('error_loading_users') }}"
            };

            $.ajax({
                url: "{{ route('association.getUsers', ['id' => '__ID__']) }}".replace('__ID__',
                    associationId),
                method: 'GET',
                success: function(data) {
                    console.log("✅ association users response:", data);

                    $("#first_association_admin_id, #second_association_admin_id").empty();

                    if (data && (data.status === 200 || data.success)) {
                        var users = data.users || [];
                        var admin = data.admin;

                        var firstSelectedId =
                            "{{ $obj->firstParties->first()?->model_id ?? '' }}";
                        var secondSelectedId =
                            "{{ $obj->secondParties->first()?->model_id ?? '' }}";

                        $("#first_association_user, #second_association_user").show();

                        if (users.length > 0) {
                            $("#first_association_admin_id").append(
                                `<option value="">${translations.select_user}</option>`);
                            $("#second_association_admin_id").append(
                                `<option value="">${translations.select_user}</option>`);

                            users.forEach(function(user) {
                                let firstSelected = (String(user.id) === String(
                                    firstSelectedId)) ? 'selected' : '';
                                let secondSelected = (String(user.id) === String(
                                    secondSelectedId)) ? 'selected' : '';

                                $("#first_association_admin_id").append(
                                    `<option value="${user.id}" ${firstSelected}>${user.name}</option>`
                                );
                                $("#second_association_admin_id").append(
                                    `<option value="${user.id}" ${secondSelected}>${user.name}</option>`
                                );
                            });

                            // ✅ لو فيه مستخدم واحد فقط، نختاره تلقائيًا
                            if (users.length === 1) {
                                $("#first_association_admin_id").val(users[0].id);
                                $("#second_association_admin_id").val(users[0].id);
                            }

                        } else if (admin) {
                            $("#first_association_admin_id, #second_association_admin_id")
                                .append(
                                    `<option value="${admin.id}" selected>${admin.name}</option>`);
                        } else {
                            $("#first_association_admin_id, #second_association_admin_id")
                                .append(`<option value="">${translations.no_users_found}</option>`);
                        }
                    } else {
                        $("#first_association_admin_id, #second_association_admin_id")
                            .append(`<option value="">${translations.no_users_found}</option>`);
                    }
                },
                error: function(xhr) {
                    console.error("❌ AJAX Error:", xhr.responseText);
                    $("#first_association_admin_id, #second_association_admin_id")
                        .empty()
                        .append(`<option value="">${translations.error_loading_users}</option>`);
                }
            });

        } else if (selectedType === 'owners_with_partner') {
            $('#user_partner_association').show();
            $('#user_asssociation').hide();
            $('#second_association_user').hide();
            $("#association_details").show();
            $("#first_association_user").show();
            $("#contract_first_party").hide();
            $("#contract_second_party").show();
            $("#association_admin").hide();
            $("#asssociation").hide();


            $("#party_name_first,  #party_nation_id_first, #party_phone_first,  #party_email_first")
                .prop('readonly', true);

            $("#user_partner_association_id").append(
                `<option selected value="{{ $obj->association?->id }}">{{ $obj->association?->getTranslation('name', app()->getLocale()) }}</option>`
            );



            let translations = {
                select_user: "{{ trns('select_user') }}",
                no_users_found: "{{ trns('no_users_found') }}",
                error_loading_users: "{{ trns('error_loading_users') }}"
            };

            $.ajax({
                url: "{{ route('association.getUsers', ['id' => '__ID__']) }}".replace('__ID__',
                    {{ $obj->association?->id ?? 'null' }}),
                method: 'GET',
                success: function(data) {
                    console.log("✅ association users response:", data);

                    // تفريغ الـ selects
                    $("#first_association_admin_id, #second_association_admin_id").empty();

                    if (data && (data.status === 200 || data.success)) {
                        var users = data.users || [];
                        var admin = data.admin;

                        // ids المحددة مسبقًا من الـ contract
                        var firstSelectedId =
                            "{{ $obj->firstParties->first()?->model_id ?? '' }}";
                        var secondSelectedId =
                            "{{ $obj->secondParties->first()?->model_id ?? '' }}";

                        console.log("🔹 firstSelectedId:", firstSelectedId);
                        console.log("🔹 secondSelectedId:", secondSelectedId);

                        $("#first_association_user").show();

                        // لو فيه users جايين
                        if (users.length > 0) {
                            $("#first_association_admin_id").append(
                                `<option value="">${translations.select_user}</option>`);
                            $("#second_association_admin_id").append(
                                `<option value="">${translations.select_user}</option>`);

                            users.forEach(function(user) {
                                let firstSelected = (String(user.id) === String(
                                    firstSelectedId)) ? 'selected' : '';
                                let secondSelected = (String(user.id) === String(
                                    secondSelectedId)) ? 'selected' : '';

                                $("#first_association_admin_id").append(
                                    `<option value="${user.id}" ${firstSelected}>${user.name}</option>`
                                );
                                $("#second_association_admin_id").append(
                                    `<option value="${user.id}" ${secondSelected}>${user.name}</option>`
                                );
                            });

                            // ✅ في حالة لو firstSelectedId فاضي نحدد أول user افتراضيًا
                            if (!firstSelectedId && users.length > 0) {
                                $("#first_association_admin_id").val(users[0].id);
                            }

                        }
                        // لو مفيش users لكن فيه admin
                        else if (admin) {
                            $("#first_association_admin_id, #second_association_admin_id").append(
                                `<option value="${admin.id}" selected>${admin.name}</option>`
                            );
                        }
                        // لو مفيش لا users ولا admin
                        else {
                            $("#first_association_admin_id, #second_association_admin_id").append(
                                `<option value="">${translations.no_users_found}</option>`
                            );
                        }

                    } else {
                        $("#first_association_admin_id, #second_association_admin_id").append(
                            `<option value="">${translations.no_users_found}</option>`
                        );
                    }
                },
                error: function(xhr) {
                    console.error("❌ AJAX Error:", xhr.responseText);
                    $("#first_association_admin_id, #second_association_admin_id")
                        .empty()
                        .append(`<option value="">${translations.error_loading_users}</option>`);
                }
            });

        } else {
            $("#association_details").hide();
            $('#asssociation').hide();
            $("#contract_first_party").show();
            $("#contract_second_party").show();
            $("#contract_party_id").show();
            $('#association_id').val(null).trigger('change');
        }

        // Trigger change event on page load to apply logic
        $('#contract_type').trigger('change');
    });
</script>
































{{-- handle the name according to the type  --}}

<script>
    $(document).ready(function() {
        $("#contract_type_id").on("change", function() {
            var typeId = $(this).val();

            if (typeId) {
                $.ajax({
                    url: "{{ route('contrace-names_byType', ['typeId' => '__ID__']) }}"
                        .replace('__ID__', typeId),
                    method: 'GET',
                    success: function(data) {
                        var $nameSelect = $("#contract_name_id");
                        $nameSelect.empty();
                        $nameSelect.append(
                            '<option value="">{{ trns('select_name') }}</option>');

                        $.each(data, function(key, name) {
                            $nameSelect.append('<option value="' + name.id + '">' +
                                name.name + '</option>');
                        });

                        @if (old('contract_name_id'))
                            $nameSelect.val("{{ old('contract_name_id') }}");
                        @endif
                    }
                });
            } else {
                $("#contract_name_id").empty().append(
                    `<option value="{{ $obj->contract_name_id }}">{{ trns('select_name') }}</option>`
                );
            }
        });

        // $("#contract_type_id").trigger('change');
    });
</script>
<script>
    initializeSelect2InModal("#contract_type_id");
    initializeSelect2InModal("#contract_party_two_id");
    initializeSelect2InModal("#contract_party_id");
    initializeSelect2InModal("#contract_name_id");
    initializeSelect2InModal("#contract_location_id");














    $(document).on('click', '.createTerm', function(e) {
        e.preventDefault(); // prevent form submission

        $('#modal-footer_termCreateModal').html(`
                        <div class="w-100 d-flex">
                            <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                            <button type="submit" class="btn btn-one me-2" id="createTermButton">{{ trns('create') }}</button>
                        </div>
                    `);

        $('#modal-body_termCreateModal').html(loader);
        $('#termCreateModal').modal('show');
        $('#editOrCreate').find('.modal-title').text("{{ trns('create_term') }}");
        setTimeout(function() {
            $('#modal-body_termCreateModal').load('{{ route('terms.create') }}');
        }, 250);
    });




    //     store
    $(document).on('click', '#createTermButton', function(e) {
        e.preventDefault();
        // Clear previous validation errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        var form = $('#addForm.termFormCreate')[0]; // نجيب الفورم بالـ ID + الكلاس
        var formData = new FormData(form);
        var url = $(form).attr('action');


        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $('#addButton').html(
                        '<span class="spinner-border spinner-border-sm mr-2"></span> <span style="margin-left: 4px;"><?php echo e(trns('loading...')); ?></span>'
                    )
                    .attr('disabled', true);
            },
            success: function(data) {
                $('#addButton').html('<?php echo e(trns('add')); ?>').attr('disabled', false);

                if (data.status == 200) {
                    Swal.fire({
                        title: '<span style="margin-bottom: 50px; display: block;"><?php echo e(trns('added_successfully')); ?></span>',
                        imageUrl: '<?php echo e(asset('true.png')); ?>',
                        imageWidth: 80,
                        imageHeight: 80,
                        imageAlt: 'Success',
                        showConfirmButton: false,
                        timer: 500,
                        customClass: {
                            image: 'swal2-image-mt30'
                        }
                    });

                    $('#termCreateModal').modal('hide');

                    // fetch newly created term(s)
                    $.ajax({
                        url: '{{ route('termsAjax.getdata') }}',
                        type: 'GET',
                        success: function(response) {
                            console.log(terms);
                            if (response.status === 200) {
                                var terms = response
                                    .terms; // <-- get the actual terms array

                                // append only new terms
                                var container = $('.mt-2.row');

                                var existingIds = [];
                                container.find('input[name="contract_term_id[]"]').each(
                                    function() {
                                        existingIds.push(String($(this).val()));
                                    });

                                terms.forEach(function(term) {
                                    if (!existingIds.includes(String(term
                                            .id))) {
                                        var html = `
            <div class=" col-12 ">
                <div class="card custom-checkbox-card ">
                    <input class="form-check-input d-none"
                           type="checkbox"
                           name="contract_term_id[]"
                           id="template${term.id}"
                           value="${term.id}" checked>
                    <label for="template${term.id}" class="card-body w-100">
                        <h5 class="association-card-header" style="font-weight: bold;">
                            ${term.title}
                        </h5>
                        <p class="association-card-para" style="color: #b5b5c3;">
                            ${term.description}
                        </p>
                    </label>
                </div>
            </div>
        `;
                                        container.append(html);
                                    }
                                });


                            }
                        }
                    });


                } else if (data.status == 405) {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ trns('something_went_wrong') }}'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ trns('something_went_wrong') }}'
                    });
                }
                $('#addButton').html(`<?php echo e(trns('add')); ?>`).attr('disabled', false);
                $('#termCreateModal').modal('hide');
            },
            error: function(xhr) {
                $('#addButton').html('<?php echo e(trns('add')); ?>').attr('disabled', false);

                if (xhr.status === 500) {
                    Swal.fire({
                        icon: 'error',
                        title: '<?php echo e(trns('server_error')); ?>',
                        text: '<?php echo e(trns('internal_server_error')); ?>'
                    });
                } else if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;

                    $.each(errors, function(field, messages) {
                        var fieldName = field.includes('.') ?
                            field.replace(/\./g, '[') + ']' :
                            field;

                        var input = $('[name="' + fieldName + '"]');

                        input.addClass('is-invalid');

                        input.next('.invalid-feedback').remove();

                        var errorHtml = '<div class="invalid-feedback">' + messages[0] +
                            '</div>';
                        input.after(errorHtml);
                    });

                    var firstField = Object.keys(errors)[0];
                    var firstFieldName = firstField.includes('.') ?
                        firstField.replace(/\./g, '[') + ']' :
                        firstField;

                    $('[name="' + firstFieldName + '"]').focus();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '<?php echo e(trns('error')); ?>',
                        text: '<?php echo e(trns('something_went_wrong')); ?>'
                    });
                }

                $('#addButton').html('<?php echo e(trns('add')); ?>').attr('disabled', false);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });





    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('contract_location_id');
        const locationWrapper = document.getElementById('contract_location_wrapper');

        function toggleLocationInput() {
            if (select.value === 'other') {
                locationWrapper.style.display = 'block';
            } else {
                locationWrapper.style.display = 'none';
            }
        }

        // استدعاء عند التحميل
        toggleLocationInput();

        // استدعاء عند التغيير
        select.addEventListener('change', toggleLocationInput);
    });
</script>
