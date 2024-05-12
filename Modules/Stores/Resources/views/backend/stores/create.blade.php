@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

<style>
    .required::after {
    content: "*";
    color: red;
    margin-left: 5px; /* Adjust the spacing as needed */
}
</style>

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend-breadcrumb-item>

    <x-backend-breadcrumb-item type="active">{{ __($module_action) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
            </x-slot>
            <x-slot name="toolbar">
                <x-backend.buttons.return-back />
            </x-slot>
        </x-backend.section-header>

        <hr>
        <h2>Step 1 - Basic details</h2>
        {{ html()->form('POST', route('backend.stores.store'))->class('form-horizontal')->open() }}
        {{ csrf_field() }}
        <div class="row mt-4">
            <div class="col">
               <div class="form-group row  mb-3">
                    <label class="col-sm-2 form-control-label required">Store Name</label>
                    <div class="col-sm-10">
                        {{ html()->text('store_name')
                                ->class('form-control')
                                ->placeholder(__('Store Name'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                    </div>
                </div>
                <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.first_name'))->class('col-sm-2 form-control-label required')->for('first_name') }}
                    <div class="col-sm-10">
                        {{ html()->text('first_name')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.first_name'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                    </div>
                </div>

                <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.last_name'))->class('col-sm-2 form-control-label required')->for('last_name') }}
                    <div class="col-sm-10">
                        {{ html()->text('last_name')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.last_name'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                    </div>
                </div>

                <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.email'))->class('col-sm-2 form-control-label required')->for('email') }}

                    <div class="col-sm-10">
                        {{ html()->email('email')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.email'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                    </div>
                </div>

                <!-- <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.password'))->class('col-sm-2 form-control-label')->for('password') }}

                    <div class="col-sm-10">
                        {{ html()->password('password')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.password'))
                                ->required() }}
                    </div>
                </div>

                <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.password_confirmation'))->class('col-sm-2 form-control-label')->for('password_confirmation') }}

                    <div class="col-sm-10">
                        {{ html()->password('password_confirmation')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.password_confirmation'))
                                ->required() }}
                    </div>
                </div> -->

                <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.status'))->class('col-6 col-sm-2 form-control-label')->for('status') }}

                    <div class="col-6 col-sm-10">
                        {{ html()->checkbox('status', true, '1') }} @lang('Active')
                    </div>
                </div>

                <!-- <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.confirmed'))->class('col-6 col-sm-2 form-control-label')->for('confirmed') }}

                    <div class="col-6 col-sm-10">
                        {{ html()->checkbox('confirmed', true, '1') }} @lang('Email Confirmed')
                    </div>
                </div> -->

                <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.email_credentials'))->class('col-6 col-sm-2 form-control-label')->for('confirmed') }}

                    <div class="col-6 col-sm-10">
                        {{ html()->checkbox('email_credentials', true, '1') }} @lang('Email Credentials')
                    </div>
                </div>

                <div class="form-group row  mb-3">
          
                </div>
                <!--form-group-->
            </div>
        </div>
        <h2>Step 2 - Profile details</h2>
        <div class="row mt-4">
               <div class="col">
              
                <div class="row mb-3">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label" for="image">Logo</label> <span class="text-danger"></span>
                        <input class="form-control" id="file-multiple-input" name="avatar" multiple="" type="file">
                    </div>
                </div>
                <div class="col-6">
                <div class="form-group">
                            <?php
                            $field_name = 'mobile';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control required')->attributes(["$required"]) }}
                        </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = 'address';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
                            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = 'bio';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
                            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = 'url_website';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                        </div>
                    </div>
                    <div class="col-12 col-sm-3 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = 'url_facebook';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                        </div>
                    </div>
                    <div class="col-12 col-sm-3 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = 'url_instagram';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                        </div>
                    </div>
                    <div class="col-12 col-sm-3 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = 'url_twitter';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                        </div>
                    </div>
                    <div class="col-12 col-sm-3 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = 'url_linkedin';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
               
                    <div class="col-6">
                        <div class="form-group">
                            <x-buttons.create title="{{__('Create')}} {{ ucwords(Str::singular($module_name)) }}">
                                {{__('Create')}}
                            </x-buttons.create>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="float-end">
                            <div class="form-group">
                                <x-buttons.cancel />
                            </div>
                        </div>
                    </div>
             
                </div>
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>

    <div class="card-footer">
        <div class="row  mb-3">
            <div class="col">
                <small class="float-end text-muted">

                </small>
            </div>
        </div>
    </div>
</div>

@endsection
