<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EmployeeLeaveApplication;
use App\Http\NavSoap\NavSyncManager;
use App\Http\Resources\ChangelogResource;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\UserResource;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{

    use CalculateDates;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', Employee::class);
//        dd($request->all());
        $data = $this->filter($request->all())->paginate();
        if($request->is('api*')){
            return new EmployeeCollection($data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Employee $employee)
    {
        $this->authorize('view', $employee);
        if($request->is('api*')){
            return new EmployeeResource($employee);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);
    }

    public function user(Request $request, Employee $employee){
        $this->authorize('view', $employee);
        if($request->is('api*')){
            return new UserResource($employee->user);
        }
    }

    public function picture(Request $request, Employee $employee){
        $this->authorize('view', $employee);
        if($request->is('api*')){
            $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
            try{

                return response()->file($storagePath."employees/$employee->No/profile_picture/$employee->Profile_Picture");
            }
            catch (\Exception $e){
                return response()->file($storagePath."public/default-avatar.jpg");
            }
        }
    }

    public function payslip(Request $request){
        $this->authorize('view', $request->user()->Employee_Record);
        $employee = $request->user()->Employee_Record;
        return $this->getEmployeePayslip($employee, $request);
    }

    public function employee_payslip(Request $request, Employee $employee){
        return $this->getEmployeePayslip($employee, $request);
    }

    public function calculate_dates(Request $request, Employee $employee){
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'leave_code' => 'required',
            'Document_No' => 'sometimes'
        ]);

        $application = null;

        $application = isset($validatedData['Document_No']) ? EmployeeLeaveApplication::where('Application_Code',
            $validatedData['Document_No'])->first() : null;
        return json_encode((array)$this->calculateEmployeeLeaveDates($validatedData, $employee, $application));
    }

    private function getEmployeePayslip(Employee $employee, $request){

        $validatedData = (object)$request->validate([
            'period' => "required"
        ]);

        $manager = new NavSyncManager();

        $base64 = $manager->getPayslip($request->user()->Employee_Record, $validatedData->period );
        $pdf_string = base64_decode($base64);

        $headers = [
            'Content-type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'."$employee->No-$validatedData->period.pdf".'"',
        ];

        return \Response::make($pdf_string, 200, $headers);
    }

    private function filter($filters){
        $model = Employee::class;
        $query = $model::query();
        $count = 0;

        $columns = Schema::getColumnListing((new $model())->getTable());
        foreach ($filters as $key => $val){
            if(!in_array($key, $columns)){
                unset($filters[$key]);
            }
        }

        foreach ((new $model())->getHidden() as $hidden){
            if(key_exists($hidden, $filters)){
                unset($filters[$hidden]);
            }
        }
//        dd($filters);
        foreach ($filters as $key => $value){
            if(is_array($value)){
                $query->where(function($arr_query) use ($value, $key){
                    $arr_count = 0;
                    foreach ($value as $item){
                        if($arr_count == 0){
                            $arr_query->where($key, $item);
                        }
                        else{
                            $arr_query->orWhere($key, $item);
                        }
                        $arr_count++;
                    }
                });

            }
            else{
                if($count == 0){
                    $query = $query->where($key, $value);
                }
                else{
                    $query = $query->where($key, $value);
                }
            }
            $count++;
        }
        return $query;
    }

    public function changelog(Employee $employee, Request $request){
        return ChangelogResource::collection($employee->audits()->paginate());
    }
}
