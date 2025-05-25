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

    // Custom popup sukses/error
    function showAlert(message, type = 'success') {
        // Hapus popup yang ada dulu
        let existing = document.querySelector('.popup-success');
        if (existing) existing.remove();

        const popup = document.createElement('div');
        popup.className = 'popup-success';
        popup.textContent = message;

        if (type !== 'success') {
            popup.style.backgroundColor = '#dc3545';
            popup.style.boxShadow = '0 6px 14px rgba(220, 53, 69, 0.7)';
        }

        document.body.appendChild(popup);

        // Trigger animasi fade-in
        requestAnimationFrame(() => {
            popup.classList.add('show');
        });

        setTimeout(() => {
            popup.classList.remove('show');
            setTimeout(() => popup.remove(), 500);
        }, 3000);
    }

    // Tutup semua modal
    function closeAllModals() {
        document.querySelectorAll('.modal.show').forEach(modal => modal.classList.remove('show'));
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Dark mode toggle (dengan simpan localStorage)
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
        if (darkModeToggle) darkModeToggle.checked = true;
    }
    if (darkModeToggle) {
        darkModeToggle.addEventListener('change', function() {
            document.body.classList.toggle('dark-mode', this.checked);
            localStorage.setItem('darkMode', this.checked);
        });
    }

    // Notification & reminder toggles (pakai checkbox custom)
    ['notifications', 'reminders'].forEach(key => {
        const toggleInput = document.getElementById(key + '-toggle');
        if (!toggleInput) return;

        if (localStorage.getItem(key) === 'false') toggleInput.checked = false;

        toggleInput.addEventListener('change', () => {
            localStorage.setItem(key, toggleInput.checked);
        });
    });

    // Profile picture upload
    const profilePicture = document.querySelector('.profile-picture');
    const profileUpload = document.getElementById('profile-upload');
    if (profilePicture && profileUpload) {
        profilePicture.addEventListener('click', () => profileUpload.click());
        profileUpload.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;
            const formData = new FormData();
            formData.append('photo', file);
            fetch('/profile/photo', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.photo_url) {
                    document.getElementById('profile-image').src = data.photo_url;
                    showAlert('Foto profil berhasil diperbarui!');
                } else {
                    showAlert(data.message || 'Gagal memperbarui foto.', 'error');
                }
            })
            .catch(() => showAlert('Terjadi kesalahan saat upload foto.', 'error'));
        });
    }

    // Open modals
    function openEditModal(fieldType, currentValue) {
        const modal = document.getElementById('edit-modal');
        if (!modal) return;
        document.getElementById('edit-field-name').textContent = fieldType;
        const input = document.getElementById('edit-input');
        input.value = currentValue;
        if (fieldType === 'Tanggal Lahir') input.type = 'date';
        else input.type = 'text';
        modal.classList.add('show');
        input.focus();
    }
    function openPasswordModal() {
        const modal = document.getElementById('password-modal');
        if (modal) modal.classList.add('show');
    }
    function openDeleteModal() {
        const modal = document.getElementById('delete-modal');
        if (modal) modal.classList.add('show');
    }

    // Close buttons & modal click outside
    document.querySelectorAll('.close-btn, .cancel-btn').forEach(btn =>
        btn.addEventListener('click', closeAllModals)
    );
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeAllModals(); });
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', e => { if (e.target === modal) closeAllModals(); });
    });

    // Edit profile field buttons
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.setting-item');
            const fieldType = item.querySelector('.setting-label').textContent;
            const current = item.querySelector('.setting-value').textContent.trim();
            openEditModal(fieldType, current);
        });
    });

    // Save edited profile field
    const saveBtn = document.querySelector('.save-btn');
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            const fieldType = document.getElementById('edit-field-name').textContent;
            const newValueRaw = document.getElementById('edit-input').value.trim();
            if (!newValueRaw) return showAlert('Nilai tidak boleh kosong!', 'error');

            let valueToSend = newValueRaw;

            if (fieldType === 'Nomor Telepon') {
                if (!/^\+?\d{1,15}$/.test(newValueRaw))
                    return showAlert('Nomor telepon tidak valid.', 'error');
            }

            if (fieldType === 'Tanggal Lahir') {
                const iso = formatDateToISO(newValueRaw);
                if (!iso) return showAlert('Format tanggal tidak valid!', 'error');
                valueToSend = iso;
            }

            fetch('/profile/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
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
                    showAlert('Data berhasil diperbarui!');
                    closeAllModals();
                } else {
                    showAlert(data.message || 'Gagal menyimpan.', 'error');
                }
            })
            .catch(() => showAlert('Terjadi kesalahan saat menyimpan.', 'error'));
        });
    }

    // Change password
    const savePasswordBtn = document.querySelector('.save-password-btn');
    if (savePasswordBtn) {
        savePasswordBtn.addEventListener('click', function() {
            const cur = document.getElementById('current-password').value.trim();
            const nw = document.getElementById('new-password').value.trim();
            const cf = document.getElementById('confirm-password').value.trim();
            if (!cur || !nw || !cf) return showAlert('Semua kolom harus diisi!', 'error');
            if (nw !== cf) return showAlert('Konfirmasi kata sandi tidak cocok!', 'error');

            fetch('/profile/change-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ current_password: cur, new_password: nw, confirm_password: cf })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showAlert('Kata sandi berhasil diperbarui!');
                    closeAllModals();
                    document.getElementById('current-password').value = '';
                    document.getElementById('new-password').value = '';
                    document.getElementById('confirm-password').value = '';
                } else {
                    showAlert(data.message || 'Gagal memperbarui sandi.', 'error');
                }
            })
            .catch(() => showAlert('Terjadi kesalahan saat update sandi.', 'error'));
        });
    }

    // Delete account
    const confirmDeleteBtn = document.querySelector('.confirm-delete-btn');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function() {
            fetch('/profile/delete', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showAlert('Akun berhasil dihapus!');
                    setTimeout(() => window.location.href = '/login', 2000);
                } else {
                    showAlert(data.message || 'Gagal menghapus akun.', 'error');
                }
            })
            .catch(() => showAlert('Terjadi kesalahan saat menghapus akun.', 'error'));
        });
    }

     const form = document.getElementById('add-entry-form');
  const entryList = document.getElementById('entry-list');

  // Data sementara
  let entries = [];

  // Fungsi render daftar ke UI
  function renderEntries() {
    entryList.innerHTML = '';
    entries.forEach((entry, index) => {
      const li = document.createElement('li');
      li.textContent = `${entry.type.toUpperCase()} - ${entry.name}: Rp${entry.amount.toLocaleString()}`;
      // Tombol hapus
      const btnDelete = document.createElement('button');
      btnDelete.textContent = 'Hapus';
      btnDelete.style.marginLeft = '10px';
      btnDelete.addEventListener('click', () => {
        entries.splice(index, 1);
        renderEntries();
      });
      li.appendChild(btnDelete);
      entryList.appendChild(li);
    });
  }

  // Event tambah entry
  form.addEventListener('submit', function(e) {
    e.preventDefault();

    const name = document.getElementById('entry-name').value.trim();
    const amount = parseFloat(document.getElementById('entry-amount').value);
    const type = document.getElementById('entry-type').value;

    if (!name || isNaN(amount) || amount <= 0) {
      alert('Masukkan nama dan nominal dengan benar!');
      return;
    }

    entries.push({ name, amount, type });
    renderEntries();

    // Reset form
    form.reset();
  });

  renderEntries();
});

