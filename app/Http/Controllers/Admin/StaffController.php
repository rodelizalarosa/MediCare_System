<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Doctor;
use App\Models\Midwife;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    /**
     * Display a listing of staff.
     */
    public function index()
    {
        $staff = Staff::with('user')->get();
        return view('admin.staff', compact('staff'));
    }

    /**
     * Show the form for creating a new staff.
     */
    public function create()
    {
        return view('admin.add-staff');
    }

    /**
     * Store a newly created staff in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'sex' => 'nullable|in:Male,Female,Other',
            'birth_date' => 'nullable|date',
            'position' => 'required|in:Health Worker,Barangay Nurse',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'staff',
                'email_verified' => 1, // Auto-verify for admin-created accounts
                'status' => 'Active',
            ]);

            Staff::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'sex' => $request->sex,
                'birth_date' => $request->birth_date,
                'position' => $request->position,
                'contact_number' => $request->contact_number,
                'address' => $request->address,
            ]);
        });

        return redirect()->route('admin.staff')->with('success', 'Staff member added successfully.');
    }

    /**
     * Display a listing of doctors.
     */
    public function doctors()
    {
        $doctors = Doctor::with('user')->get();
        return view('admin.doctors', compact('doctors'));
    }

    /**
     * Show the form for creating a new doctor.
     */
    public function createDoctor()
    {
        return view('admin.add-doctor');
    }

    /**
     * Store a newly created doctor in storage.
     */
    public function storeDoctor(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'specialization' => 'nullable|string|max:100',
            'license_number' => 'nullable|string|max:50',
            'PRC_expiry' => 'nullable|date',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'doctor',
                'email_verified' => 1,
                'status' => 'Active',
            ]);

            Doctor::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'specialization' => $request->specialization,
                'license_number' => $request->license_number,
                'PRC_expiry' => $request->PRC_expiry,
                'contact_number' => $request->contact_number,
                'address' => $request->address,
            ]);
        });

        return redirect()->route('admin.doctors')->with('success', 'Doctor added successfully.');
    }

    /**
     * Display a listing of midwives.
     */
    public function midwives()
    {
        $midwives = Midwife::with('user')->get();
        return view('admin.midwives', compact('midwives'));
    }

    /**
     * Show the form for creating a new midwife.
     */
    public function createMidwife()
    {
        return view('admin.add-midwife');
    }

    /**
     * Store a newly created midwife in storage.
     */
    public function storeMidwife(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'license_number' => 'nullable|string|max:50',
            'PRC_expiry' => 'nullable|date',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'midwife',
                'email_verified' => 1,
                'status' => 'Active',
            ]);

            Midwife::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'license_number' => $request->license_number,
                'PRC_expiry' => $request->PRC_expiry,
                'contact_number' => $request->contact_number,
                'address' => $request->address,
            ]);
        });

        return redirect()->route('admin.midwives')->with('success', 'Midwife added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Get staff details for AJAX view.
     */
    public function showStaff(Request $request, $id)
    {
        if ($request->ajax() && $request->has('action') && $request->action === 'view') {
            $staff = Staff::with('user')->findOrFail($id);
            return response()->json([
                'staff' => $staff,
                'user' => $staff->user
            ]);
        }
        abort(404);
    }

    /**
     * Update staff information.
     */
    public function updateStaff(Request $request, $id)
    {
        try {
            $staff = Staff::findOrFail($id);

            // Update staff data
            $staff->update($request->only([
                'first_name', 'middle_name', 'last_name', 'sex', 'birth_date',
                'position', 'contact_number', 'address'
            ]));

            // Update user email if provided
            if ($request->has('email')) {
                $staff->user->update(['email' => $request->email]);
            }

            return response()->json(['success' => true, 'message' => 'Staff updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get doctor details for AJAX view.
     */
    public function showDoctor(Request $request, $id)
    {
        if ($request->ajax() && $request->has('action') && $request->action === 'view') {
            $doctor = Doctor::with('user')->findOrFail($id);
            return response()->json([
                'doctor' => $doctor,
                'user' => $doctor->user
            ]);
        }
        abort(404);
    }

    /**
     * Update doctor information.
     */
    public function updateDoctor(Request $request, $id)
    {
        try {
            $doctor = Doctor::findOrFail($id);

            // Update doctor data
            $doctor->update($request->only([
                'first_name', 'middle_name', 'last_name', 'specialization',
                'license_number', 'PRC_expiry', 'contact_number', 'address'
            ]));

            // Update user email if provided
            if ($request->has('email')) {
                $doctor->user->update(['email' => $request->email]);
            }

            return response()->json(['success' => true, 'message' => 'Doctor updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get midwife details for AJAX view.
     */
    public function showMidwife(Request $request, $id)
    {
        if ($request->ajax() && $request->has('action') && $request->action === 'view') {
            $midwife = Midwife::with('user')->findOrFail($id);
            return response()->json([
                'midwife' => $midwife,
                'user' => $midwife->user
            ]);
        }
        abort(404);
    }

    /**
     * Update midwife information.
     */
    public function updateMidwife(Request $request, $id)
    {
        try {
            $midwife = Midwife::findOrFail($id);

            // Update midwife data
            $midwife->update($request->only([
                'first_name', 'middle_name', 'last_name', 'license_number',
                'PRC_expiry', 'contact_number', 'address'
            ]));

            // Update user email if provided
            if ($request->has('email')) {
                $midwife->user->update(['email' => $request->email]);
            }

            return response()->json(['success' => true, 'message' => 'Midwife updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
