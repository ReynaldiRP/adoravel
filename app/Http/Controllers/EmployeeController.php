<?php

namespace App\Http\Controllers;

use App\Models\Genders;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $employee = Employee::latest()->paginate(5);
        $gender = Genders::all();
        $position = Position::all();
        return view('employee.index', compact('employee', 'gender', 'position'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|regex:/^[a-zA-Z\s]+$/u|max:255',
                'last_name' => 'required|regex:/^[a-zA-Z\s]+$/u|max:255',
                'gender_id' => ['required'],
                'position_id' => ['required'],
                'address' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/',
                'phone_number' => 'nullable|numeric|digits_between:9,12',
                'email' => 'required|email',
                'salary' => 'required|numeric|min:0',
                'join_date' => 'required|date',
            ]);

            $employee = Employee::create($validatedData);
            // Retrieve the gender and position models
            $gender = Genders::find($employee->gender_id);
            $position = Position::find($employee->position_id);

            $transformedEmployee = [
                'id' => $employee->id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'gender' => [
                    'gender_name' => $gender->gender_name,
                ],
                'position' => [
                    'job_name' => $position->job_name,
                ],
                'salary' => $employee->salary,
                'email' => $employee->email,
                'address' => $employee->address,
                'phone_number' => $employee->phone_number,
                'join_date' => $employee->join_date,
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully added',
                'data' => $transformedEmployee
            ]);
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->all();
            return response()->json([
                'status' => 500,
                'message' => 'Failed to Add Data',
                'errors' => $error
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee): View
    {
        $gender = Genders::all();
        $position = Position::all();
        return view('employee.edit', compact('employee', 'gender', 'position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee): Response
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|regex:/^[a-zA-Z\s]+$/u|max:255',
                'last_name' => 'required|regex:/^[a-zA-Z\s]+$/u|max:255',
                'gender_id' => ['required'],
                'position_id' => ['required'],
                'address' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/',
                'phone_number' => 'nullable|numeric|digits_between:9,12',
                'email' => 'required|email',
                'salary' => 'required|numeric|min:0',
                'join_date' => 'required|date',
            ]);
            $employee->update($validatedData);

            $gender = Genders::find($employee->gender_id);
            $position = Position::find($employee->position_id);

            $transformedEmployee = [
                'id' => $employee->id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'gender' => [
                    'gender_name' => $gender->gender_name,
                ],
                'position' => [
                    'job_name' => $position->job_name,
                ],
                'salary' => $employee->salary,
                'email' => $employee->email,
                'address' => $employee->address,
                'phone_number' => $employee->phone_number,
                'join_date' => $employee->join_date,
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully added',
                'data' => $transformedEmployee
            ]);
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->all();
            return response()->json([
                'status' => 500,
                'message' => 'Failed to Add Data',
                'errors' => $error
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json([
                    'status' => 500,
                    'message' => 'Data gagal dihapus karena sedang digunakan.'
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to delete data'
                ]);
            }
        }
    }
}
