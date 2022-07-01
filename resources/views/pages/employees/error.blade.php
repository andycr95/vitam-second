@if (count($errors))
    @foreach ($errors->all as $error)
    <script>toastr.danger("{{ $error }}")</script>
    @endforeach
@endif