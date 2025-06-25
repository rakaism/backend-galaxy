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
    <h2>Pengajuan Pembayaran Gaji</h2>
    <form action="{{ route('salary_requests.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="salary" class="form-label">Gaji Pokok</label>
            <input type="number" name="salary" id="salary" class="form-control" required min="0" step="0.01" value="{{ old('salary') }}">
        </div>
        <div class="mb-3">
            <label for="bonus" class="form-label">Bonus</label>
            <input type="number" name="bonus" id="bonus" class="form-control" min="0" step="0.01" value="{{ old('bonus', 0) }}">
        </div>
        <div class="mb-3">
            <label for="pph" class="form-label">PPh21 (otomatis)</label>
            <input type="text" id="pph" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label for="total" class="form-label">Total Diterima (otomatis)</label>
            <input type="text" id="total" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">Catatan</label>
            <textarea name="note" id="note" class="form-control">{{ old('note') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Ajukan</button>
    </form>
</div>
<script>
function hitungPph(salary, bonus) {
    let total = parseFloat(salary) + parseFloat(bonus);
    let pph = 0;
    if (total <= 5000000) {
        pph = total * 0.05;
    } else if (total <= 20000000) {
        pph = total * 0.10;
    } else {
        pph = total * 0.15;
    }
    return pph;
}
function updateFields() {
    let salary = parseFloat(document.getElementById('salary').value) || 0;
    let bonus = parseFloat(document.getElementById('bonus').value) || 0;
    let pph = hitungPph(salary, bonus);
    let total = salary + bonus - pph;
    document.getElementById('pph').value = pph.toLocaleString('id-ID', {style:'currency', currency:'IDR'});
    document.getElementById('total').value = total.toLocaleString('id-ID', {style:'currency', currency:'IDR'});
}
document.getElementById('salary').addEventListener('input', updateFields);
document.getElementById('bonus').addEventListener('input', updateFields);
document.addEventListener('DOMContentLoaded', updateFields);
</script>
</body>
</html>