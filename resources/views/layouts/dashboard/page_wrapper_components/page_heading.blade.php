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
            <div class="btn-group hidden-xs m-r-md" role="group" aria-label="...">
                <button type="button" class="btn btn-default btn-xs">Linked Documents</button>
                <button type="button" class="btn btn-default btn-xs">Contract Info</button>
                <button type="button" class="btn btn-default btn-xs">Medical Scheme</button>
                <button type="button" class="btsn btn-default btn-xs">Dependants</button>
                <button type="button" class="btn btn-default btn-xs">Next of Kin</button>
            </div>

            <div class="dropdown visible-xs m-b-sm">
                <button class="btn-default btn-lg btn-block dropdown-toggle" type="button" id="doc-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Linked Documents
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="doc-dropdown">
                    <li><a href="#">Linked Documents</a></li>
                    <li><a href="#">Contract Info</a></li>
                    <li><a href="#">Medical Scheme</a></li>
                    <li><a href="#">Dependants</a></li>
                    <li><a href="#">Next of Kin</a></li>
                </ul>
            </div>
            <div class="btn-group hidden-xs" role="group" aria-label="...">
                <button type="button"  class="btn btn-success btn-xs"  @click="swapComponent('new-leave')">Apply Leave</button>
                <button type="button"  class="btn btn-green btn-xs"  @click="swapComponent('payslip')">Payslips</button>
            </div>

            <div class="btn-group-vertical visible-xs" role="group" aria-label="...">
                <button type="button"  class="btn btn-success btn-lg"  @click="swapComponent('new-leave')">Apply Leave</button>
                <button type="button"  class="btn btn-green btn-lg"  @click="swapComponent('payslip')">Payslips</button>
            </div>
        </div>
    </div>
</div>