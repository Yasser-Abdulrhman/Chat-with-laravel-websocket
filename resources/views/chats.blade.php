@extends('layouts.app')

@section('content')
<div class="container">
  <chats :user="{{auth()->user() }}"></chats>
</div>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="{{asset('js/scripts.js')}}"></script>
<script  src="js/app.js"></script> --}}
@endsection
