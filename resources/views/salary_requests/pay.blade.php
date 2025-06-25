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
    <h2>Proses Pembayaran Gaji</h2>
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
    <form action="{{ route('salary_requests.pay', $salaryRequest->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="payment_proof" class="form-label">Upload Bukti Pembayaran</label>
            <input type="file" name="payment_proof" id="payment_proof" class="form-control" required accept=".jpg,.jpeg,.png,.pdf">
        </div>
        <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
    </form>
</div>
</body>
</html>