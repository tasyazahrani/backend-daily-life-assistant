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
            <div class="upload-overlay" title="Klik untuk ubah foto">
                <i class="fas fa-camera"></i>
            </div>
            <form id="photo-upload-form" enctype="multipart/form-data" style="display:none;">
                @csrf
                <input type="file" name="photo" id="profile-upload" accept="image/*" />
            </form>
        </div>
        <div class="profile-info">
            <h2>{{ Auth::user()->name }}</h2>
            <p>{{ Auth::user()->email }}</p>
            <button class="edit-profile-btn">Edit Profil</button>
        </div>
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
                {{ Auth::user()->birthdate ? \Carbon\Carbon::parse(Auth::user()->birthdate)->format('Y-m-d') : '-' }}
                <button class="edit-btn"><i class="fas fa-pencil"></i></button>
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
            <input type="text" id="edit-input" class="edit-input" />
        </div>
        <div class="modal-footer">
            <button class="cancel-btn">Batal</button>
            <button class="save-btn">Simpan</button>
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
                <input type="password" id="current-password" class="edit-input" />
            </div>
            <div class="form-group">
                <label for="new-password">Kata Sandi Baru:</label>
                <input type="password" id="new-password" class="edit-input" />
            </div>
            <div class="form-group">
                <label for="confirm-password">Konfirmasi Kata Sandi:</label>
                <input type="password" id="confirm-password" class="edit-input" />
            </div>
        </div>
        <div class="modal-footer">
            <button class="cancel-btn">Batal</button>
            <button class="save-password-btn">Simpan</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Modal elements
    const editModal = document.getElementById('edit-modal');
    const editFieldName = document.getElementById('edit-field-name');
    const editInput = document.getElementById('edit-input');
    const passwordModal = document.getElementById('password-modal');

    let currentField = '';
    let currentValue = '';

    // Fungsi buka modal edit profil
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const settingItem = this.closest('.setting-item');
            const label = settingItem.querySelector('.setting-label').innerText.trim();
            const value = settingItem.querySelector('.setting-value').childNodes[0].textContent.trim();

            currentField = '';
            if (label.toLowerCase().includes('nama')) currentField = 'name';
            else if (label.toLowerCase().includes('email')) currentField = 'email';
            else if (label.toLowerCase().includes('telepon')) currentField = 'phone';
            else if (label.toLowerCase().includes('lahir')) currentField = 'birthdate';

            if (!currentField) return;

            editFieldName.textContent = label;
            currentValue = value === '-' ? '' : value;

            // Jika field tanggal lahir, ubah input ke type date
            if (currentField === 'birthdate') {
                editInput.type = 'date';
                editInput.value = currentValue || '';
            } else if (currentField === 'phone') {
                editInput.type = 'tel';
                editInput.value = currentValue || '';
            } else if (currentField === 'email') {
                editInput.type = 'email';
                editInput.value = currentValue || '';
            } else {
                editInput.type = 'text';
                editInput.value = currentValue || '';
            }

            editModal.style.display = 'block';
            editInput.focus();
        });
    });

    // Simpan perubahan profil via AJAX
    document.querySelector('.save-btn').addEventListener('click', function () {
        const newValue = editInput.value.trim();

        if (!newValue) {
            alert('Nilai tidak boleh kosong.');
            return;
        }

        // Validasi khusus email
        if (currentField === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(newValue)) {
                alert('Format email tidak valid.');
                return;
            }
        }

        // Kirim data ke server via fetch API
        fetch("{{ route('profile.update') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                field: currentField,
                value: newValue
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update tampilan nilai di halaman
                const settingItems = document.querySelectorAll('.setting-item');
                settingItems.forEach(item => {
                    const label = item.querySelector('.setting-label').innerText.trim().toLowerCase();
                    if ((label.includes('nama') && currentField === 'name') ||
                        (label.includes('email') && currentField === 'email') ||
                        (label.includes('telepon') && currentField === 'phone') ||
                        (label.includes('lahir') && currentField === 'birthdate')) {
                            const valEl = item.querySelector('.setting-value');
                            if (currentField === 'birthdate') {
                                // Format tanggal ke d F Y (Indonesia)
                                const dateObj = new Date(newValue);
                                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                                valEl.childNodes[0].textContent = dateObj.toLocaleDateString('id-ID', options);
                            } else {
                                valEl.childNodes[0].textContent = newValue;
                            }
                    }
                });

                // Jika update nama atau email di header profil
                if (currentField === 'name') {
                    document.querySelector('.profile-info h2').textContent = newValue;
                }
                if (currentField === 'email') {
                    document.querySelector('.profile-info p').textContent = newValue;
                }

                alert('Data berhasil diperbarui.');
                editModal.style.display = 'none';
            } else {
                alert(data.message || 'Terjadi kesalahan saat menyimpan data.');
            }
        })
        .catch(() => alert('Terjadi kesalahan jaringan.'));
    });

    // Upload foto profil via AJAX
    const photoUploadInput = document.getElementById('profile-upload');
    const photoUploadForm = document.getElementById('photo-upload-form');

    document.querySelector('.upload-overlay').addEventListener('click', () => {
        photoUploadInput.click();
    });

    photoUploadInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('photo', file);

        fetch("{{ route('profile.photo') }}", {
            method: 'POST',
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.photo_url) {
                document.getElementById('profile-image').src = data.photo_url + '?t=' + new Date().getTime();
                alert('Foto profil berhasil diubah.');
            } else {
                alert(data.message || 'Gagal mengubah foto profil.');
            }
        })
        .catch(() => alert('Terjadi kesalahan jaringan saat upload foto.'));
    });

    // Buka modal ubah kata sandi
    document.getElementById('change-password-btn').addEventListener('click', () => {
        passwordModal.style.display = 'block';
    });

    // Tutup modal (edit profil dan ubah password)
    document.querySelectorAll('.close-btn, .cancel-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            editModal.style.display = 'none';
            passwordModal.style.display = 'none';
        });
    });

    // Simpan password baru
    document.querySelector('.save-password-btn').addEventListener('click', () => {
        const currentPassword = document.getElementById('current-password').value.trim();
        const newPassword = document.getElementById('new-password').value.trim();
        const confirmPassword = document.getElementById('confirm-password').value.trim();

        if (!currentPassword || !newPassword || !confirmPassword) {
            alert('Semua field harus diisi.');
            return;
        }

        if (newPassword !== confirmPassword) {
            alert('Konfirmasi kata sandi tidak cocok.');
            return;
        }

        fetch("{{ route('profile.password') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                current_password: currentPassword,
                new_password: newPassword,
                confirm_password: confirmPassword
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Kata sandi berhasil diubah.');
                passwordModal.style.display = 'none';
                // Kosongkan input password
                document.getElementById('current-password').value = '';
                document.getElementById('new-password').value = '';
                document.getElementById('confirm-password').value = '';
            } else {
                alert(data.message || 'Gagal mengubah kata sandi.');
            }
        })
        .catch(() => alert('Terjadi kesalahan jaringan saat mengubah kata sandi.'));
    });
});
</script>
@endpush

<form action="{{ route('profile.delete') }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus akun ini?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Hapus Akun</button>
</form>


@endsection
