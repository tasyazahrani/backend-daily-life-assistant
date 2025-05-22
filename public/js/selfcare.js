document.addEventListener('DOMContentLoaded', function() {
    // Helper untuk format tanggal ke ISO (yyyy-mm-dd)
    function formatDateToISO(dateStr) {
        const d = new Date(dateStr);
        if (isNaN(d.getTime())) return null;
        const year = d.getFullYear();
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Alert
    function showAlert(message, type = 'success') {
        const alertEl = document.createElement('div');
        alertEl.className = `alert ${type}`;
        alertEl.textContent = message;
        document.body.appendChild(alertEl);
        Object.assign(alertEl.style, {
            position: 'fixed', bottom: '20px', right: '20px', padding: '15px 20px',
            borderRadius: '5px', color: 'white', fontWeight: 'bold', zIndex: '1100',
            boxShadow: '0 3px 10px rgba(0,0,0,0.2)', transition: 'opacity 0.5s ease',
            backgroundColor: type === 'success' ? '#28a745' : '#dc3545'
        });
        setTimeout(() => {
            alertEl.style.opacity = '0';
            setTimeout(() => alertEl.remove(), 500);
        }, 3000);
    }

    // Close modals common
    function closeAllModals() {
        document.querySelectorAll('.modal.show').forEach(modal => modal.classList.remove('show'));
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Dark mode toggle
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode'); darkModeToggle.checked = true;
    }
    darkModeToggle.addEventListener('change', function() {
        document.body.classList.toggle('dark-mode', this.checked);
        localStorage.setItem('darkMode', this.checked);
    });

    // Notification & reminder toggles
    ['notifications','reminders'].forEach(key => {
        const toggle = document.getElementById(key+'-toggle');
        if (localStorage.getItem(key) === 'false') toggle.checked = false;
        toggle.addEventListener('change', () => localStorage.setItem(key, toggle.checked));
    });

    // Profile picture upload
    const profilePicture = document.querySelector('.profile-picture');
    const profileUpload = document.getElementById('profile-upload');
    profilePicture.addEventListener('click', () => profileUpload.click());
    profileUpload.addEventListener('change', function() {
        const file = this.files[0]; if (!file) return;
        const formData = new FormData(); formData.append('photo', file);
        fetch('/profile/photo', {
            method: 'POST', headers: {'X-CSRF-TOKEN': csrfToken}, body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.photo_url) {
                document.getElementById('profile-image').src = data.photo_url;
                showAlert('Foto profil berhasil diperbarui!');
            } else showAlert(data.message || 'Gagal memperbarui foto.', 'error');
        })
        .catch(() => showAlert('Terjadi kesalahan saat upload foto.', 'error'));
    });

    // Open modals
    function openEditModal(fieldType, currentValue) {
        const modal = document.getElementById('edit-modal');
        document.getElementById('edit-field-name').textContent = fieldType;
        const input = document.getElementById('edit-input');
        input.value = currentValue;
        if (fieldType === 'Tanggal Lahir') input.type = 'date'; else input.type = 'text';
        modal.classList.add('show'); input.focus();
    }
    function openPasswordModal() { document.getElementById('password-modal').classList.add('show'); }
    function openDeleteModal() { document.getElementById('delete-modal').classList.add('show'); }

    // Close buttons
    document.querySelectorAll('.close-btn, .cancel-btn').forEach(btn => btn.addEventListener('click', closeAllModals));
    document.addEventListener('keydown', e => { if (e.key==='Escape') closeAllModals(); });
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', e => { if (e.target === modal) closeAllModals(); });
    });

    // Edit profile field
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.setting-item');
            const fieldType = item.querySelector('.setting-label').textContent;
            const current = item.querySelector('.setting-value').textContent.trim();
            openEditModal(fieldType, current);
        });
    });

    // Save edited profile field
    document.querySelector('.save-btn').addEventListener('click', function() {
        const fieldType = document.getElementById('edit-field-name').textContent;
        const newValueRaw = document.getElementById('edit-input').value.trim();
        if (!newValueRaw) return showAlert('Nilai tidak boleh kosong!', 'error');
        let valueToSend = newValueRaw;
        if (fieldType === 'Nomor Telepon') {
            if (!/^\+?\d{1,15}$/.test(newValueRaw)) return showAlert('Nomor telepon tidak valid.', 'error');
        }
        if (fieldType === 'Tanggal Lahir') {
            const iso = formatDateToISO(newValueRaw);
            if (!iso) return showAlert('Format tanggal tidak valid!', 'error');
            valueToSend = iso;
        }
        fetch('/profile/update', {
            method: 'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},
            body: JSON.stringify({ field: fieldType, value: valueToSend })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // update UI
                document.querySelectorAll('.setting-item').forEach(item => {
                    if (item.querySelector('.setting-label').textContent === fieldType) {
                        const valSpan = item.querySelector('.setting-value');
                        const txtNode = valSpan.childNodes[0];
                        if (txtNode.nodeType === Node.TEXT_NODE) txtNode.nodeValue = newValueRaw + ' ';
                    }
                });
                if (fieldType === 'Nama Lengkap') document.querySelector('.profile-info h2').textContent = newValueRaw;
                if (fieldType === 'Email') document.querySelector('.profile-info p').textContent = newValueRaw;
                showAlert('Data berhasil diperbarui!'); closeAllModals();
            } else showAlert(data.message || 'Gagal menyimpan.', 'error');
        })
        .catch(() => showAlert('Terjadi kesalahan saat menyimpan.', 'error'));
    });

    // Change password
    document.querySelector('.save-password-btn').addEventListener('click', function() {
        const cur = document.getElementById('current-password').value.trim();
        const nw = document.getElementById('new-password').value.trim();
        const cf = document.getElementById('confirm-password').value.trim();
        if (!cur||!nw||!cf) return showAlert('Semua kolom harus diisi!', 'error');
        if (nw !== cf) return showAlert('Konfirmasi kata sandi tidak cocok!', 'error');
        fetch('/profile/change-password', {
            method: 'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},
            body: JSON.stringify({ current_password: cur, new_password: nw, confirm_password: cf })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showAlert('Kata sandi berhasil diperbarui!'); closeAllModals();
                document.getElementById('current-password').value = '';
                document.getElementById('new-password').value = '';
                document.getElementById('confirm-password').value = '';
            } else showAlert(data.message || 'Gagal memperbarui sandi.', 'error');
        })
        .catch(() => showAlert('Terjadi kesalahan saat update sandi.', 'error'));
    });

    // Delete account
    document.querySelector('.confirm-delete-btn').addEventListener('click', function() {
        fetch('/profile/delete', { method: 'POST', headers:{'X-CSRF-TOKEN':csrfToken} })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showAlert('Akun berhasil dihapus!');
                setTimeout(() => window.location.href = '/login', 2000);
            } else showAlert(data.message || 'Gagal menghapus akun.', 'error');
        })
        .catch(() => showAlert('Terjadi kesalahan saat menghapus akun.', 'error'));
    });
});