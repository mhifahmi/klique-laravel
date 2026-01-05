<div class="mb-3">
    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
    <input type="text" name="fullname" class="form-control" required placeholder="Contoh: Budi Santoso">
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">NIK</label>
        <input type="number" name="nik" class="form-control" placeholder="16 digit NIK">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
        <input type="date" id="birthday" name="birthday">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">No. Telepon</label>
        <input type="text" name="phone_number" class="form-control" placeholder="08xxxxx">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
        <select name="gender" class="form-select" required>
            <option value="M">Laki-laki</option>
            <option value="F">Perempuan</option>
        </select>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea name="address" class="form-control" rows="3"></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Catatan</label>
    <textarea name="note" class="form-control" rows="3"></textarea>
</div>
