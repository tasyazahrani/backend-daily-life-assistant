@extends('layouts.app')

@section('title', 'Profil')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
@endpush

@section('content')
<header>
    <h2>Profil</h2>
</header>

<div class="profile-container">
    <div class="profile-header">
        <div class="profile-picture">
            <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('image/User avatar.png') }}" alt="Foto Profil" id="profile-image">
            <div class="upload-overlay">
                <i class="fas fa-camera"></i>
            </div>
            <input type="file" id="profile-upload" accept="image/*" hidden>
        </div>
        <div class="profile-info">
            <h2>{{ Auth::user()->name }}</h2>
            <p>{{ Auth::user()->email }}</p>
            <button class="edit-profile-btn">Edit Profil</button>
        </div>
    </div>

    <div class="setting-value">
        {{ Auth::user()->name }}
        <button class="edit-btn"><i class="fas fa-pencil"></i></button>
    </div>

<div class="profile-section">
    <h3>Informasi Pribadi</h3>

    <div class="setting-item">
        <div class="setting-label">Nama Lengkap</div>
        <div class="setting-value">
            {{ Auth::user()->name }}
            <button class="edit-btn"><i class="fas fa-pencil"></i></button>
        </div>
    </div>

    <div class="setting-item">
        <div class="setting-label">Email</div>
        <div class="setting-value">
            {{ Auth::user()->email }}
            <button class="edit-btn"><i class="fas fa-pencil"></i></button>
        </div>
    </div>

    <div class="setting-item">
        <div class="setting-label">Nomor Telepon</div>
        <div class="setting-value">
            {{ Auth::user()->phone ?? '-' }}
            <button class="edit-btn"><i class="fas fa-pencil"></i></button>
        </div>
    </div>

    <div class="setting-item">
        <div class="setting-label">Tanggal Lahir</div>
        <div class="setting-value">
            {{ Auth::user()->birthdate ? \Carbon\Carbon::parse(Auth::user()->birthdate)->translatedFormat('d F Y') : '-' }}
            <button class="edit-btn"><i class="fas fa-pencil"></i></button>
        </div>
    </div>
</div>


    <div class="profile-section">
        <h3>Pengaturan Aplikasi</h3>
        <div class="setting-item">
            <div class="setting-label">Mode Gelap</div>
            <div class="setting-value">
                <label class="toggle-switch">
                    <input type="checkbox" id="dark-mode-toggle">
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>
        <div class="setting-item">
            <div class="setting-label">Notifikasi</div>
            <div class="setting-value">
                <label class="toggle-switch">
                    <input type="checkbox" id="notification-toggle" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>
        <div class="setting-item">
            <div class="setting-label">Pengingat Harian</div>
            <div class="setting-value">
                <label class="toggle-switch">
                    <input type="checkbox" id="reminder-toggle" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="profile-section">
        <h3>Keamanan</h3>
        <div class="setting-item">
            <div class="setting-label">Ubah Kata Sandi</div>
            <div class="setting-value">
                <button class="action-btn" id="change-password-btn">Ubah</button>
            </div>
        </div>
    </div>

    <div class="profile-section">
        <h3>Dukungan</h3>
        <div class="setting-item">
            <div class="setting-label">Pusat Bantuan</div>
            <div class="setting-value">
                <button class="action-btn" id="help-center-btn">Buka</button>
            </div>
        </div>
    </div>

    <div class="profile-section">
        <h3>Manajemen Data</h3>
        <div class="setting-item">
            <div class="setting-label">Hapus Akun</div>
            <div class="setting-value">
                <button class="delete-btn" id="delete-account-btn">Hapus</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal edit profil --}}
<div class="modal" id="edit-modal" style="display:none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit <span id="edit-field-name">Field</span></h3>
            <button class="close-btn">&times;</button>
        </div>
        <div class="modal-body">
            <label for="edit-input">Nilai Baru:</label>
            <input type="text" id="edit-input" class="edit-input">
        </div>
        <div class="modal-footer">
            <button class="cancel-btn">Batal</button>
            <button class="save-btn">Simpan</button>
        </div>
    </div>
</div>

{{-- Modal konfirmasi hapus akun --}}
<div class="modal" id="delete-modal" style="display:none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Konfirmasi Hapus Akun</h3>
            <button class="close-btn">&times;</button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="modal-footer">
            <button class="cancel-btn">Batal</button>
            <button class="confirm-delete-btn">Hapus Akun</button>
        </div>
    </div>
</div>

{{-- Modal ubah kata sandi --}}
<div class="modal" id="password-modal" style="display:none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Ubah Kata Sandi</h3>
            <button class="close-btn">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="current-password">Kata Sandi Saat Ini:</label>
                <input type="password" id="current-password" class="edit-input">
            </div>
            <div class="form-group">
                <label for="new-password">Kata Sandi Baru:</label>
                <input type="password" id="new-password" class="edit-input">
            </div>
            <div class="form-group">
                <label for="confirm-password">Konfirmasi Kata Sandi:</label>
                <input type="password" id="confirm-password" class="edit-input">
            </div>
        </div>
        <div class="modal-footer">
            <button class="cancel-btn">Batal</button>
            <button class="save-password-btn">Simpan</button>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/profile.js') }}"></script>
@endpush

@endsection