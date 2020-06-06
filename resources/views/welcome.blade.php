@extends('layouts.app')

@section('content')
<div class="container">
    <form-wrapper group="Update" v-cloak>
        <template v-slot="props">
            <fieldset>
                <div class="row">
                    <div class="col col-sm-12 col-md-6">
                        <text-input :group="props.group" label="first_name" name="first_name"
                            v-model="props.fields.first_name" current-value="" maxlength="31" autocomplete="given-name"
                            :validation="{
                               'required': 'Please add somtheing',
                            'min:2': 'Minimum length 2 chars',
                             'max:30': 'Maximum length 30 chars',
                         }" :error="props.error">
                        </text-input>
                    </div>
                    <div class="col col-sm-12 col-md-6">
                        <validation label="last_name" id="last_name" name="last_name"
                            :show="props.error.has('last_name')" :validation="{
                               'required': 'Please add last name',
                               'min:2': 'Minimum length 2 chars',
                              'max:30': 'Maximum length 30 chars', }" :error="props.error"></validation>
                        <text-input :group="props.group" name="last_name" v-model="props.fields.last_name"
                            current-value="" maxlength="31" autocomplete="given-name" :validation="['min:3', 'max:20']"
                            :error="props.error">
                        </text-input>
                    </div>
                </div>
            </fieldset>
            <button type="mt-2 submit" class="btn btn-info">Submit</button>
        </template>
    </form-wrapper>
</div>
@endsection