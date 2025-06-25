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
    <h2>Approval Permintaan Pembayaran Gaji</h2>
    <div class="mb-3">
        <label class="form-label">Gaji Pokok</label>
        <input type="text" class="form-control" value="{{ number_format($salaryRequest->salary,0,',','.') }}" readonly>
    </div>
    <div class="mb-3">
        <label class="form-label">Bonus</label>
        <input type="text" class="form-control" value="{{ number_format($salaryRequest->bonus,0,',','.') }}" readonly>
    </div>
    <div class="mb-3">
        <label class="form-label">PPh21</label>
        <input type="text" class="form-control" value="{{ number_format($salaryRequest->pph,0,',','.') }}" readonly>
    </div>
    <div class="mb-3">
        <label class="form-label">Total Diterima</label>
        <input type="text" class="form-control" value="{{ number_format($salaryRequest->total,0,',','.') }}" readonly>
    </div>
    <form action="{{ route('salary_requests.approve', $salaryRequest->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="note" class="form-label">Catatan</label>
            <textarea name="note" id="note" class="form-control">{{ old('note', $salaryRequest->note) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="approved">Setujui</option>
                <option value="rejected">Tolak</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Proses</button>
    </form>
</div>
</body>
</html>