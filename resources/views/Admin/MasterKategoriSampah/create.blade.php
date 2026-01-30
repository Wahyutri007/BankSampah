@extends('layouts.admin')

@section('title', 'Tambah Master Kategori Sampah')

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

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Form Card - Diperlebar untuk input 100% */
    .form-card {
        background: var(--white);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        padding: 32px;
        margin-bottom: 32px;
        width: 100%;
        max-width: 100%;
    }
    
    @media (max-width: 768px) {
        .form-card {
            padding: 24px;
        }
    }

    /* Form Grid - Full width */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
        margin-bottom: 32px;
        width: 100%;
    }

    /* Form Group - Full width */
    .form-group {
        margin-bottom: 0;
        width: 100%;
    }
    
    .form-group.full-width {
        grid-column: 1 / -1;
        width: 100%;
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
        width: 100%;
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

    /* Form Controls - Lebar 100% */
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
        box-sizing: border-box; /* Pastikan padding tidak menambah lebar */
    }
    
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .form-control::placeholder {
        color: var(--muted);
        font-weight: 400;
    }
    
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
        line-height: 1.6;
        width: 100%;
    }

    /* Form Helper Text */
    .form-helper {
        display: block;
        margin-top: 6px;
        font-size: 13px;
        color: var(--muted);
        line-height: 1.5;
        width: 100%;
    }
    
    .form-helper.error {
        color: #dc2626;
        font-weight: 500;
    }

    /* Info Box - Full width */
    .info-box {
        background: var(--primary-light);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: var(--radius);
        padding: 16px;
        margin-top: 16px;
        display: flex;
        gap: 12px;
        width: 100%;
    }
    
    .info-box i {
        color: var(--primary);
        font-size: 18px;
        margin-top: 2px;
    }
    
    .info-content {
        flex: 1;
        width: 100%;
    }
    
    .info-title {
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 4px;
        font-size: 14px;
    }
    
    .info-text {
        font-size: 13px;
        color: var(--primary-dark);
        line-height: 1.5;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 16px;
        padding-top: 32px;
        border-top: 1px solid var(--line);
        flex-wrap: wrap;
        width: 100%;
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

    /* Character Counter */
    .char-counter {
        text-align: right;
        font-size: 12px;
        color: var(--muted);
        margin-top: 4px;
        width: 100%;
    }
    
    .char-counter.warning {
        color: #f59e0b;
        font-weight: 600;
    }
    
    .char-counter.error {
        color: #dc2626;
        font-weight: 600;
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
        
        .form-card {
            padding: 20px 16px;
        }
    }

    @media (max-width: 576px) {
        .form-card {
            padding: 20px 12px;
            margin-left: 0;
            margin-right: 0;
            border-radius: 0;
            border-left: none;
            border-right: none;
        }
        
        .form-header .page-title {
            font-size: 24px;
        }
        
        .btn-submit,
        .btn-cancel {
            padding: 12px 20px;
            font-size: 15px;
        }
        
        .form-control {
            padding: 10px 14px;
            font-size: 14px;
        }
    }
</style>
@endpush

@section('content')
<div class="form-page">
    <!-- Page Header -->
    <div class="form-header">
        <div>
            <h1 class="page-title">Tambah Master Kategori Sampah</h1>
            <p class="page-subtitle">Tambahkan kategori utama baru untuk mengorganisir data sampah dalam sistem.</p>
        </div>
        
        <a href="{{ route('master_kategori_sampah.index') }}" class="btn-back">
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

    <!-- Form Card - Full Width -->
    <div class="form-card">
        <form method="POST" action="{{ route('master_kategori_sampah.store') }}" id="createForm">
            @csrf

            <div class="form-grid">
                <!-- Nama Kategori - Full Width -->
                <div class="form-group full-width">
                    <label class="form-label">
                        <span>Nama Kategori</span>
                        <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="nama_kategori" 
                           class="form-control" 
                           value="{{ old('nama_kategori') }}" 
                           placeholder="Masukkan nama kategori (contoh: Plastik, Kertas, Logam)" 
                           required
                           autofocus
                           maxlength="100"
                           autocomplete="off"
                           style="width: 100%;">
                    <span class="form-helper">Nama kategori harus unik dan deskriptif.</span>
                    @error('nama_kategori')
                        <span class="form-helper error">{{ $message }}</span>
                    @enderror
                    <div class="char-counter" id="nameCounter">0/100 karakter</div>
                </div>

                <!-- Deskripsi - Full Width -->
                <div class="form-group full-width">
                    <label class="form-label">
                        <span>Deskripsi</span>
                        <span class="optional">(Opsional)</span>
                    </label>
                    <textarea name="deskripsi" 
                              class="form-control" 
                              rows="4" 
                              placeholder="Tambahkan deskripsi untuk menjelaskan kategori ini..."
                              maxlength="500"
                              autocomplete="off"
                              style="width: 100%;">{{ old('deskripsi') }}</textarea>
                    <span class="form-helper">Deskripsi akan membantu pengguna memahami jenis sampah dalam kategori ini.</span>
                    @error('deskripsi')
                        <span class="form-helper error">{{ $message }}</span>
                    @enderror
                    <div class="char-counter" id="descCounter">0/500 karakter</div>
                </div>

            
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Kategori</span>
                </button>
                
                <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('master_kategori_sampah.index') }}'">
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
        const nameInput = document.querySelector('input[name="nama_kategori"]');
        const descTextarea = document.querySelector('textarea[name="deskripsi"]');
        const nameCounter = document.getElementById('nameCounter');
        const descCounter = document.getElementById('descCounter');
        
        // Update character counters
        function updateCounters() {
            // Name counter
            const nameLength = nameInput.value.length;
            nameCounter.textContent = `${nameLength}/100 karakter`;
            nameCounter.className = 'char-counter';
            if (nameLength > 90) nameCounter.classList.add('warning');
            if (nameLength > 100) nameCounter.classList.add('error');
            
            // Description counter
            const descLength = descTextarea.value.length;
            descCounter.textContent = `${descLength}/500 karakter`;
            descCounter.className = 'char-counter';
            if (descLength > 450) descCounter.classList.add('warning');
            if (descLength > 500) descCounter.classList.add('error');
        }
        
        // Initial update
        updateCounters();
        
        // Update on input
        nameInput.addEventListener('input', updateCounters);
        descTextarea.addEventListener('input', updateCounters);
        
        // Form submission handler
        form.addEventListener('submit', function(e) {
            // Prevent multiple submissions
            if (submitBtn.classList.contains('btn-loading')) {
                e.preventDefault();
                return;
            }
            
            // Validate name length
            if (nameInput.value.length > 100) {
                e.preventDefault();
                alert('Nama kategori tidak boleh lebih dari 100 karakter.');
                nameInput.focus();
                return;
            }
            
            // Validate description length
            if (descTextarea.value.length > 500) {
                e.preventDefault();
                alert('Deskripsi tidak boleh lebih dari 500 karakter.');
                descTextarea.focus();
                return;
            }
            
            // Validate required fields
            if (!nameInput.value.trim()) {
                e.preventDefault();
                alert('Nama kategori harus diisi.');
                nameInput.focus();
                return;
            }
            
            // Show loading state
            submitBtn.classList.add('btn-loading');
            submitBtn.disabled = true;
        });
        
        // Auto-focus name field
        setTimeout(() => {
            if (nameInput) {
                nameInput.focus();
                // Place cursor at end if there's existing value
                if (nameInput.value) {
                    nameInput.setSelectionRange(nameInput.value.length, nameInput.value.length);
                }
            }
        }, 100);
        
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
            
            // Ctrl/Cmd + Enter to submit
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                submitBtn.click();
            }
        });
        
        // Confirm before leaving page if form has changes
        let formChanged = false;
        const formInputs = form.querySelectorAll('input, textarea');
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
        
        // Disable autocomplete suggestions
        nameInput.setAttribute('autocomplete', 'off');
        descTextarea.setAttribute('autocomplete', 'off');
        
        // Prevent browser suggestions
        form.setAttribute('autocomplete', 'off');
        
        // Clear any browser autofill
        setTimeout(() => {
            if (nameInput.value && nameInput.value.includes('@')) {
                nameInput.value = '';
            }
        }, 100);
    });
    
    // Function to validate category name
    function validateCategoryName(name) {
        if (name.length < 2) {
            return 'Nama kategori terlalu pendek (minimal 2 karakter)';
        }
        if (name.length > 100) {
            return 'Nama kategori terlalu panjang (maksimal 100 karakter)';
        }
        if (!/^[a-zA-Z0-9\s\-\_\&\+\,\/\(\)]+$/.test(name)) {
            return 'Nama kategori hanya boleh berisi huruf, angka, spasi, dan karakter khusus (-_&+,/())';
        }
        return null;
    }
</script>
@endpush