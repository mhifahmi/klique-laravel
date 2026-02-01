<div class="mb-3">
    <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
    <input type="text" name="fullname" class="form-control" required placeholder="Contoh: Dr. Budi Santoso, Sp.PD">
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">NIK</label>
        <input type="number" name="nik" class="form-control" placeholder="16 digit NIK">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Nomor SIP <span class="text-danger">*</span></label>
        <input type="text" name="sip_number" class="form-control" required placeholder="Nomor Surat Izin Praktik">
    </div>
</div>

<div class="row">
    {{-- Perbaikan: Label sebelumnya salah 'Jenis Kelamin', diganti 'Tanggal Lahir' --}}
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Tanggal Lahir</label>
        {{-- Perbaikan: name diganti 'birthdate' sesuai DB --}}
        <input type="date" name="birthdate" class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
        <select name="gender" class="form-select" required>
            <option value="" selected disabled>Pilih Gender</option>
            <option value="M">Laki-laki</option>
            <option value="F">Perempuan</option>
        </select>
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">No. Telepon</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
        <input type="text" name="phone_number" class="form-control" placeholder="08xxxxx">
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Alamat</label>
    <textarea name="address" class="form-control" rows="3" placeholder="Alamat lengkap..."></textarea>
</div>
