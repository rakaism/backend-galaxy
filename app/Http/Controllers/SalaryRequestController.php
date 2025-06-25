<?php

namespace App\Http\Controllers;

use App\Models\SalaryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalaryRequestController extends Controller
{
    //index daftar request gaji
    public function index()
    {
        $user = Auth::user();
        if ($user->roles->contains('name', 'Director')) {
            $salaryRequests = SalaryRequest::where('status', 'paid')->get();
        } elseif ($user->roles->contains('name', 'Manager')) {
            $salaryRequests = SalaryRequest::where('status', 'pending')->get();
        } else {
            $salaryRequests = SalaryRequest::where('user_id', $user->id)->get();
        }
        return view('salary_requests.index', compact('salaryRequests'));
    }

    //form request gaji
    public function create()
    {
        return view('salary_requests.create');
    }

    //store request gaji
    public function store(Request $request)
    {
        $request->validate([
            'salary' => 'required|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
        ]);
        $salary = $request->salary;
        $bonus = $request->bonus ?? 0;
        $pph = $this->calculatePph($salary + $bonus);
        $total = $salary + $bonus - $pph;
        SalaryRequest::create([
            'user_id' => Auth::id(),
            'salary' => $salary,
            'bonus' => $bonus,
            'pph' => $pph,
            'total' => $total,
            'status' => 'pending',
            'note' => $request->note,
        ]);
        return redirect()->route('salary_requests.index')->with('success', 'Pengajuan gaji berhasil dibuat.');
    }

    //index approval manager
    public function approveForm($id)
    {
        $salaryRequest = SalaryRequest::findOrFail($id);
        return view('salary_requests.approve', compact('salaryRequest'));
    }

    //approval oleh manager
    public function approve(Request $request, $id)
    {
        $salaryRequest = SalaryRequest::findOrFail($id);
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'note' => 'nullable|string',
        ]);
        $salaryRequest->status = $request->status;
        $salaryRequest->approved_by = Auth::id();
        $salaryRequest->approved_at = now();
        $salaryRequest->note = $request->note;
        $salaryRequest->save();
        return redirect()->route('salary_requests.index')->with('success', 'Permintaan gaji diperbarui.');
    }

    //form proses pembayaran finance
    public function payForm($id)
    {
        $salaryRequest = SalaryRequest::findOrFail($id);
        return view('salary_requests.pay', compact('salaryRequest'));
    }

    //proses pembayaran finance
    public function pay(Request $request, $id)
    {
        $salaryRequest = SalaryRequest::findOrFail($id);
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        $salaryRequest->status = 'paid';
        $salaryRequest->paid_by = Auth::id();
        $salaryRequest->paid_at = now();
        $salaryRequest->payment_proof = $path;
        $salaryRequest->save();
        return redirect()->route('salary_requests.index')->with('success', 'Pembayaran berhasil diproses.');
    }

    //hitung pph
    private function calculatePph($amount)
    {
        if ($amount <= 5000000) {
            return $amount * 0.05;
        } elseif ($amount <= 20000000) {
            return $amount * 0.10;
        } else {
            return $amount * 0.15;
        }
    }
}