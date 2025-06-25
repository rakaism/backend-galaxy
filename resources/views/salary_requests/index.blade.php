<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <a href="{{ route('salary_requests.create') }}" class="btn btn-primary mt-5 mb-5">Create</a>
    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
    <h2>Daftar Permintaan Pembayaran Gaji</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pengaju</th>
                <th>Gaji</th>
                <th>Bonus</th>
                <th>PPh21</th>
                <th>Total</th>
                <th>Status</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salaryRequests as $req)
            <tr>
                <td>{{ $req->id }}</td>
                <td>{{ $req->user->name ?? '-' }}</td>
                <td>{{ number_format($req->salary,0,',','.') }}</td>
                <td>{{ number_format($req->bonus,0,',','.') }}</td>
                <td>{{ number_format($req->pph,0,',','.') }}</td>
                <td>{{ number_format($req->total,0,',','.') }}</td>
                <td>{{ ucfirst($req->status) }}</td>
                <td>{{ $req->note }}</td>
                <td>
                    @if($req->status == 'pending' && auth()->user()->roles->contains('name','Manager'))
                        <a href="{{ route('salary_requests.approveForm', $req->id) }}" class="btn btn-warning btn-sm">Approval</a>
                    @elseif($req->status == 'approved' && auth()->user()->roles->contains('name','Finance'))
                        <a href="{{ route('salary_requests.payForm', $req->id) }}" class="btn btn-primary btn-sm">Proses Bayar</a>
                    @elseif($req->status == 'paid' && $req->payment_proof)
                        <a href="{{ asset('storage/'.$req->payment_proof) }}" target="_blank" class="btn btn-success btn-sm">Lihat Bukti</a>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if(auth()->check())
        <div class="alert alert-info mb-3">
            Login sebagai: <strong>{{ auth()->user()->email }}</strong>
            @if(auth()->user()->roles->count())
                (Role: {{ auth()->user()->roles->pluck('name')->join(', ') }})
            @else
                (Role: Tidak ada)
            @endif
        </div>
    @endif
</div>
</body>
</html>