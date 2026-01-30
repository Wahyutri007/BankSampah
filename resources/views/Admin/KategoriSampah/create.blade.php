@extends('layouts.admin')

@section('title', 'Tambah Kategori Sampah')

@push('styles')
<style>
    /* ===== FORM PAGE STYLES ===== */
    .form-page {
        min-height: calc(100vh - 100px);
    }

    /* Page Header */
    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 32px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--line);
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .form-header .page-title {
        font-size: 28px;
        margin-bottom: 4px;
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .form-header .page-subtitle {
        font-size: 15px;
        color: var(--muted);
        max-width: 600px;
        line-height: 1.6;
    }

    /* Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: var(--radius);
        background: var(--white);
        color: var(--ink);
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        border: 1px solid var(--line);
        transition: var(--transition);
    }
    
    .btn-back:hover {
        background: var(--hover-bg);
        border-color: var(--primary);
        color: var(--primary);
    }

    /* Error Alert */
    .alert-error {
        background: #fef2f2;
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: var(--radius);
        padding: 20px;
        margin-bottom: 32px;
        color: #991b1b;
        font-weight: 500;
        animation: slideIn 0.3s ease-out;
    }
    
    .alert-error .alert-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        font-weight: 600;
        font-size: 16px;
    }
    
    .alert-error .alert-title i {
        color: #dc2626;
    }
    
    .alert-error ul {
        margin: 0;
        padding-left: 24px;
    }
    
    .alert-error li {
        margin-bottom: 6px;
        font-size: 14px;
    }
    
    .alert-error li:last-child {
        margin-bottom: 0;
    }

    /* Form Card */
    .form-card {
        background: var(--white);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        padding: 32px;
        margin-bottom: 32px;
    }
    
    @media (max-width: 768px) {
        .form-card {
            padding: 24px;
        }
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }
    
    @media (max-width: 992px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    /* Form Group */
    .form-group {
        margin-bottom: 0;
    }
    
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .form-label .required {
        color: #dc2626;
        font-weight: 700;
        margin-left: 2px;
    }
    
    .form-label .optional {
        font-size: 12px;
        color: var(--muted);
        font-weight: 400;
        margin-left: 8px;
    }

    /* Form Controls */
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid var(--line);
        border-radius: var(--radius-sm);
        background: var(--white);
        color: var(--ink);
        font-size: 15px;
        font-weight: 500;
        transition: var(--transition);
        outline: none;
    }
    
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .form-control::placeholder {
        color: var(--muted);
        font-weight: 400;
    }
    
    .form-control[readonly] {
        background: var(--bg);
        cursor: not-allowed;
    }
    
    .form-control[disabled] {
        background: var(--bg);
        color: var(--muted);
        cursor: not-allowed;
    }
    
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
        line-height: 1.6;
    }
    
    select.form-control {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236b7280' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        padding-right: 40px;
    }

    /* Form Helper Text */
    .form-helper {
        display: block;
        margin-top: 6px;
        font-size: 13px;
        color: var(--muted);
        line-height: 1.5;
    }
    
    .form-helper.error {
        color: #dc2626;
        font-weight: 500;
    }

    /* File Upload */
    .file-upload {
        position: relative;
        margin-top: 8px;
    }
    
    .file-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px dashed var(--line);
        border-radius: var(--radius-sm);
        background: var(--bg);
        color: var(--ink);
        font-size: 15px;
        cursor: pointer;
        transition: var(--transition);
        outline: none;
    }
    
    .file-input:hover {
        border-color: var(--primary);
        background: var(--primary-light);
    }
    
    .file-input:focus {
        border-color: var(--primary);
        border-style: solid;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .file-input::file-selector-button {
        padding: 8px 16px;
        margin-right: 16px;
        border: 1px solid var(--primary);
        border-radius: var(--radius-sm);
        background: var(--primary);
        color: var(--white);
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .file-input::file-selector-button:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    /* Image Preview */
    .image-preview {
        margin-top: 20px;
    }
    
    .preview-container {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .preview-image {
        width: 160px;
        height: 160px;
        border-radius: var(--radius);
        border: 1px solid var(--line);
        background: var(--bg);
        overflow: hidden;
        position: relative;
    }
    
    .preview-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }
    
    .preview-image .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        background: var(--primary-light);
    }
    
    .preview-image .no-image i {
        font-size: 32px;
        margin-bottom: 8px;
        color: var(--primary);
    }
    
    .preview-image .no-image span {
        font-size: 14px;
        font-weight: 500;
    }
    
    .preview-info {
        flex: 1;
        min-width: 300px;
    }
    
    .preview-info .info-item {
        margin-bottom: 12px;
        font-size: 14px;
    }
    
    .preview-info .info-label {
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 4px;
    }
    
    .preview-info .info-value {
        color: var(--muted);
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 16px;
        padding-top: 32px;
        border-top: 1px solid var(--line);
        flex-wrap: wrap;
    }
    
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        border-radius: var(--radius);
        background: var(--primary);
        color: var(--white);
        font-weight: 600;
        font-size: 16px;
        text-decoration: none;
        border: 1px solid var(--primary);
        transition: var(--transition);
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }
    
    .btn-submit:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }
    
    .btn-submit:active {
        transform: translateY(0);
    }
    
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        border-radius: var(--radius);
        background: var(--white);
        color: var(--ink);
        font-weight: 600;
        font-size: 16px;
        text-decoration: none;
        border: 1px solid var(--line);
        transition: var(--transition);
        cursor: pointer;
    }
    
    .btn-cancel:hover {
        background: var(--hover-bg);
        border-color: var(--primary);
        color: var(--primary);
    }

    /* Loading State */
    .btn-loading {
        position: relative;
        color: transparent !important;
    }
    
    .btn-loading::after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        border: 2px solid var(--white);
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 0.8s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .form-header {
            flex-direction: column;
            align-items: stretch;
        }
        
        .btn-back {
            width: 100%;
            justify-content: center;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-submit,
        .btn-cancel {
            width: 100%;
            justify-content: center;
        }
        
        .preview-container {
            flex-direction: column;
        }
        
        .preview-image {
            width: 100%;
            height: 200px;
        }
        
        .preview-info {
            min-width: 100%;
        }
    }

    @media (max-width: 576px) {
        .form-card {
            padding: 20px;
            margin-left: -16px;
            margin-right: -16px;
            border-radius: 0;
            border-left: none;
            border-right: none;
        }
        
        .form-header .page-title {
            font-size: 24px;
        }
        
        .btn-submit,
        .btn-cancel {
            padding: 12px 24px;
            font-size: 15px;
        }
    }
</style>
@endpush

@section('content')
<div class="form-page">
    <!-- Page Header -->
    <div class="form-header">
        <div>
            <h1 class="page-title">Tambah Kategori Sampah</h1>
            <p class="page-subtitle">Tambahkan jenis sampah baru ke dalam sistem dengan mengisi form berikut.</p>
        </div>
        
        <a href="{{ route('kategori_sampah.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="alert-error">
            <div class="alert-title">
                <i class="fa-solid fa-exclamation-triangle"></i>
                <span>Terjadi Kesalahan</span>
            </div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="form-card">
        <form method="POST" action="{{ route('kategori_sampah.store') }}" enctype="multipart/form-data" id="createForm">
            @csrf

            <div class="form-grid">
                <!-- Nama Sampah -->
                <div class="form-group">
                    <label class="form-label">
                        <span>Nama Sampah</span>
                        <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="nama_sampah" 
                           class="form-control" 
                           value="{{ old('nama_sampah') }}" 
                           placeholder="Contoh: Botol Plastik PET" 
                           required
                           autofocus>
                    @error('nama_sampah')
                        <span class="form-helper error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Kategori Master -->
                <div class="form-group">
                    <label class="form-label">
                        <span>Kategori Master</span>
                        <span class="required">*</span>
                    </label>
                    <select name="master_kategori_id" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        @foreach($kategoriMaster as $kategori)
                            <option value="{{ $kategori->id }}" 
                                {{ old('master_kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('master_kategori_id')
                        <span class="form-helper error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Harga Satuan -->
                <div class="form-group">
                    <label class="form-label">
                        <span>Harga Satuan</span>
                        <span class="optional">(Opsional)</span>
                    </label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--muted); font-weight: 600;">Rp</span>
                        <input type="number" 
                               name="harga_satuan" 
                               class="form-control" 
                               value="{{ old('harga_satuan') }}" 
                               placeholder="0"
                               min="0"
                               step="100"
                               style="padding-left: 40px;">
                    </div>
                    <span class="form-helper">Harga per satuan dalam Rupiah. Kosongkan jika belum ditentukan.</span>
                    @error('harga_satuan')
                        <span class="form-helper error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Jenis Satuan -->
                <div class="form-group">
                    <label class="form-label">
                        <span>Jenis Satuan</span>
                        <span class="optional">(Opsional)</span>
                    </label>
                    <input type="text" 
                           name="jenis_satuan" 
                           class="form-control" 
                           value="{{ old('jenis_satuan') }}" 
                           placeholder="Contoh: kg, liter, pcs">
                    <span class="form-helper">Satuan pengukuran untuk sampah ini.</span>
                    @error('jenis_satuan')
                        <span class="form-helper error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="form-group full-width">
                    <label class="form-label">
                        <span>Deskripsi</span>
                        <span class="optional">(Opsional)</span>
                    </label>
                    <textarea name="deskripsi" 
                              class="form-control" 
                              rows="4" 
                              placeholder="Tambahkan deskripsi atau keterangan tentang sampah ini...">{{ old('deskripsi') }}</textarea>
                    <span class="form-helper">Deskripsi akan membantu pengguna memahami jenis sampah ini.</span>
                    @error('deskripsi')
                        <span class="form-helper error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Gambar Sampah -->
                <div class="form-group full-width">
                    <label class="form-label">
                        <span>Gambar Sampah</span>
                        <span class="optional">(Opsional)</span>
                    </label>
                    
                    <input type="file" 
                           name="gambar_sampah" 
                           id="gambar_sampah" 
                           class="file-input" 
                           accept="image/*"
                           onchange="previewImage(event)">
                    
                    <span class="form-helper">Format: JPG, PNG, WEBP. Maksimal ukuran: 2MB. Gambar akan disimpan di storage.</span>
                    @error('gambar_sampah')
                        <span class="form-helper error">{{ $message }}</span>
                    @enderror
                    
                    <!-- Image Preview -->
                    <div class="image-preview">
                        <div class="preview-container">
                            <div class="preview-image" id="imagePreview">
                                <div class="no-image">
                                    <i class="fa-solid fa-image"></i>
                                    <span>Preview Gambar</span>
                                </div>
                                <img id="previewImg" alt="Preview gambar">
                            </div>
                            
                            <div class="preview-info">
                                <div class="info-item">
                                    <div class="info-label">Informasi Gambar</div>
                                    <div class="info-value">
                                        <div id="imageInfo">Pilih file untuk melihat informasi</div>
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">Tips</div>
                                    <div class="info-value">
                                        <ul style="margin: 0; padding-left: 20px; color: var(--muted);">
                                            <li>Gunakan gambar dengan resolusi minimal 400x400 piksel</li>
                                            <li>Format JPG/PNG/WEBP direkomendasikan</li>
                                            <li>Pastikan gambar jelas dan representatif</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Data</span>
                </button>
                
                <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('kategori_sampah.index') }}'">
                    <i class="fa-solid fa-times"></i>
                    <span>Batalkan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('createForm');
        const submitBtn = document.getElementById('submitBtn');
        const fileInput = document.getElementById('gambar_sampah');
        const previewImg = document.getElementById('previewImg');
        const imagePreview = document.getElementById('imagePreview');
        const noImage = imagePreview.querySelector('.no-image');
        const imageInfo = document.getElementById('imageInfo');
        
        // Form submission handler
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('#submitBtn');
            submitBtn.classList.add('btn-loading');
            submitBtn.disabled = true;
        });
        
        // Image preview function
        window.previewImage = function(event) {
            const file = event.target.files[0];
            if (!file) {
                resetPreview();
                return;
            }
            
            // Check file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                resetPreview();
                fileInput.value = '';
                return;
            }
            
            // Check file type
            if (!file.type.match('image.*')) {
                alert('Hanya file gambar yang diperbolehkan.');
                resetPreview();
                fileInput.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                noImage.style.display = 'none';
                
                // Update image info
                const sizeInKB = (file.size / 1024).toFixed(2);
                imageInfo.innerHTML = `
                    <div><strong>Nama:</strong> ${file.name}</div>
                    <div><strong>Ukuran:</strong> ${sizeInKB} KB</div>
                    <div><strong>Tipe:</strong> ${file.type}</div>
                `;
            };
            reader.readAsDataURL(file);
        };
        
        function resetPreview() {
            previewImg.src = '';
            previewImg.style.display = 'none';
            noImage.style.display = 'flex';
            imageInfo.textContent = 'Pilih file untuk melihat informasi';
        }
        
        // Auto-focus first field
        const firstField = form.querySelector('input, select, textarea');
        if (firstField) {
            setTimeout(() => firstField.focus(), 100);
        }
        
        // Real-time validation for numeric fields
        const hargaInput = document.querySelector('input[name="harga_satuan"]');
        if (hargaInput) {
            hargaInput.addEventListener('input', function() {
                let value = this.value;
                // Remove any non-numeric characters except decimal point
                value = value.replace(/[^\d.]/g, '');
                // Ensure only one decimal point
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }
                this.value = value;
            });
        }
        
        // Auto-format harga on blur
        if (hargaInput) {
            hargaInput.addEventListener('blur', function() {
                if (this.value && !isNaN(this.value)) {
                    const formatted = new Intl.NumberFormat('id-ID').format(this.value);
                    const currencySpan = this.previousElementSibling;
                    if (currencySpan && currencySpan.textContent === 'Rp') {
                        // Visual feedback - temporarily show formatted value
                        const original = this.value;
                        this.value = formatted;
                        setTimeout(() => {
                            this.value = original;
                        }, 1500);
                    }
                }
            });
        }
        
        // Character counter for textarea
        const textarea = document.querySelector('textarea[name="deskripsi"]');
        if (textarea) {
            const counter = document.createElement('div');
            counter.className = 'form-helper';
            counter.style.textAlign = 'right';
            counter.textContent = '0/500 karakter';
            textarea.parentNode.insertBefore(counter, textarea.nextSibling);
            
            textarea.addEventListener('input', function() {
                const length = this.value.length;
                counter.textContent = `${length}/500 karakter`;
                counter.style.color = length > 500 ? '#dc2626' : 'var(--muted)';
            });
        }
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                submitBtn.click();
            }
            
            // Escape to cancel
            if (e.key === 'Escape') {
                const cancelBtn = document.querySelector('.btn-cancel');
                if (cancelBtn) {
                    cancelBtn.click();
                }
            }
        });
        
        // Confirm before leaving page if form has changes
        let formChanged = false;
        const formInputs = form.querySelectorAll('input, select, textarea');
        formInputs.forEach(input => {
            const originalValue = input.value;
            input.addEventListener('input', () => {
                formChanged = true;
            });
            input.addEventListener('change', () => {
                formChanged = true;
            });
        });
        
        window.addEventListener('beforeunload', function(e) {
            if (formChanged && !submitBtn.classList.contains('btn-loading')) {
                e.preventDefault();
                e.returnValue = 'Perubahan yang belum disimpan akan hilang. Yakin ingin meninggalkan halaman?';
                return e.returnValue;
            }
        });
        
        // Reset formChanged on submit
        form.addEventListener('submit', () => {
            formChanged = false;
        });
    });
</script>
@endpush