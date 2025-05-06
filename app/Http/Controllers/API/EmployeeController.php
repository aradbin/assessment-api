<?php

namespace App\Http\Controllers\API;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @group Employee Management
 *
 * APIs for managing employees
 */
class EmployeeController extends Controller
{
    /**
     * Display a list of employees
     *
     * @queryParam page int Page number. Example: 1
     * @authenticated
     */
    public function index() {
        return EmployeeResource::collection(Employee::with(['department', 'detail'])->paginate(15));
    }

    /**
     * Store a new employee
     *
     * @bodyParam name string required Example: John Doe
     * @bodyParam email string required Example: john@example.com
     * @bodyParam department_id integer required Example: 2
     * @bodyParam designation string required Example: Developer
     * @bodyParam salary float required Example: 75000
     * @bodyParam address string required Example: 123 Main St
     * @bodyParam joined_date date required Format: YYYY-MM-DD Example: 2023-01-01
     * @authenticated
     */
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'department_id' => 'required|exists:departments,id',
            'designation' => 'required|string',
            'salary' => 'required|numeric',
            'address' => 'required|string',
            'joined_date' => 'required|date',
        ]);

        $employee = Employee::create([
            'id' => Str::uuid(),
            'name' => $data['name'],
            'email' => $data['email'],
            'department_id' => $data['department_id'],
        ]);

        $employee->detail()->create([
            'designation' => $data['designation'],
            'salary' => $data['salary'],
            'address' => $data['address'],
            'joined_date' => $data['joined_date'],
        ]);

        return new EmployeeResource($employee->load(['department', 'detail']));
    }

    /**
     * Show a single employee
     *
     * @urlParam id string required Employee UUID
     * @authenticated
     */
    public function show(Employee $employee) {
        return new EmployeeResource($employee->load(['department', 'detail']));
    }

    /**
     * Update an existing employee
     *
     * @urlParam id string required Employee UUID
     * @authenticated
     */
    public function update(Request $request, Employee $employee) {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:employees,email,' . $employee->id,
            'department_id' => 'sometimes|exists:departments,id',
            'designation' => 'sometimes|string',
            'salary' => 'sometimes|numeric',
            'address' => 'sometimes|string',
            'joined_date' => 'sometimes|date',
        ]);

        $employee->update($request->only(['name', 'email', 'department_id']));
        $employee->detail()->update($request->only(['designation', 'salary', 'address', 'joined_date']));

        return new EmployeeResource($employee->load(['department', 'detail']));
    }

    /**
     * Delete an employee
     *
     * @urlParam id string required Employee UUID
     * @authenticated
     */
    public function destroy(Employee $employee) {
        $employee->delete();
        return response()->json(['message' => 'Employee deleted']);
    }
}
