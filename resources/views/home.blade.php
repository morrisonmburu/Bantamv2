@extends('layouts.app')
@section('content')
<div id="wrapper">
    {{--Side pane--}}
    @include('layouts.dashboard.side_nav_static')

    {{--page wrapper / mainSection--}}
    @include('layouts.dashboard.page_wrapper')
</div>
@endsection
