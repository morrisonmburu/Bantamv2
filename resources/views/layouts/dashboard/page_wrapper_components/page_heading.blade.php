<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">

        {{--Page Title--}}
        <h2 style="text-transform: capitalize">@{{ sanitizeHeaders(currentComponent) }}</h2>

        {{--Breadcrumb--}}
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li class="active">
                <strong>@{{ currentComponent }}</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>