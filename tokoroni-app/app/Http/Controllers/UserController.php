<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Hitung statistik dengan persentase
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();

        $stats = [
            'total' => $totalUsers,
            'active' => $activeUsers,
            'inactive' => User::where('is_active', false)->count(),
            'owners' => User::where('role', 'owner')->count(),
            'gudang' => User::where('role', 'gudang')->count(),
            'kasir' => User::where('role', 'kasir')->count(),
            'active_percentage' => $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0,
        ];

        // Query dengan filter
        $query = User::query();

        // Filter role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $users = $query->paginate($perPage);

        return view('users.index', compact('users', 'stats'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:owner,kasir,gudang',
            'is_active' => 'sometimes|boolean',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'is_active' => $request->boolean('is_active', true),
            'phone'     => $request->phone,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
            $data['image'] = $imagePath;
        }

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone' => 'nullable|string|max:20',
            'role'  => 'required|in:owner,kasir,gudang',
            'password' => 'nullable|min:6|confirmed',
            'is_active' => 'sometimes|boolean',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only('name', 'email', 'role', 'phone');

        // Update status aktif
        $data['is_active'] = $request->boolean('is_active', $user->is_active);

        // Update password jika ada
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->image && \Storage::disk('public')->exists($user->image)) {
                \Storage::disk('public')->delete($user->image);
            }

            $imagePath = $request->file('image')->store('users', 'public');
            $data['image'] = $imagePath;
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        // Prevent deleting owner
        if ($user->role === 'owner') {
            return back()->with('error', 'Owner tidak bisa dihapus');
        }

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri');
        }

        // Delete user image if exists
        if ($user->image && \Storage::disk('public')->exists($user->image)) {
            \Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }

    public function toggleStatus(User $user)
    {
        // Prevent toggling own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun sendiri');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "User berhasil $status");
    }

    public function export(Request $request)
    {
        $query = User::query();

        // Apply filters if any
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->get();

        // Determine format
        $format = $request->get('format', 'excel');

        if ($format === 'csv') {
            return $this->exportToCsv($users);
        } elseif ($format === 'pdf') {
            return $this->exportToPdf($users);
        } else {
            return $this->exportToExcel($users);
        }
    }

    private function exportToExcel($users)
    {
        // Implement Excel export logic
        return response()->json(['message' => 'Excel export would be implemented here']);
    }

    private function exportToCsv($users)
    {
        // Implement CSV export logic
        return response()->json(['message' => 'CSV export would be implemented here']);
    }

    private function exportToPdf($users)
    {
        // Implement PDF export logic
        return response()->json(['message' => 'PDF export would be implemented here']);
    }

    public function bulkActivate(Request $request)
{
    $ids = $request->ids;
    User::whereIn('id', $ids)->update(['is_active' => true]);

    return response()->json(['success' => true]);
}

public function bulkDeactivate(Request $request)
{
    $ids = $request->ids;
    User::whereIn('id', $ids)->update(['is_active' => false]);

    return response()->json(['success' => true]);
}
}
