@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endsection

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}

@include('files::admin._files-selector')

@include('core::form._title-and-slug')
{!! TranslatableBootForm::hidden('status')->value(0) !!}
{!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
{!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
{!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor') !!}
