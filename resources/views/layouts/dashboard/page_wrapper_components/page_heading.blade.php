<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4">

        {{--Page Title--}}
        <h2 style="text-transform: capitalize">@{{ sanitizeHeaders(currentComponent) }}</h2>

        {{--Breadcrumb--}}
        <ol class="breadcrumb">
            <li>
                <a href="/">Home</a>
            </li>
            <li class="active">
                <strong>@{{ currentComponent }}</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-default btn-sm">Linked Documents</button>
                <button type="button" class="btn btn-default btn-sm">Contract Info</button>
                <button type="button" class="btn btn-default btn-sm">Medical Scheme</button>
                <button type="button" class="btn btn-default btn-sm">Dependants</button>
                <button type="button" class="btn btn-default btn-sm">Next of Kin</button>
            </div>

            <button type="button"  class="btn btn-primary btn-sm"  @click="swapComponent('new-leave')">Leave Application</button>
            <button type="button"  class="btn btn-primary btn-sm"  @click="swapComponent('payslip')">Payslips</button>
        </div>
    </div>
</div>