document.addEventListener('DOMContentLoaded', function() {
    const moodIcons = document.querySelectorAll('.mood-icon');
    const selectedMoodInput = document.getElementById('selected-mood');
    const diaryText = document.getElementById('diary-text');
    const diaryForm = document.getElementById('diary-form');

    // Pilih mood, beri tanda selected dan isi input hidden
    moodIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            // Hapus class 'selected' dari semua
            moodIcons.forEach(i => i.classList.remove('selected'));

            // Tambah class 'selected' ke yang diklik
            this.classList.add('selected');

            // Ambil mood dari atribut data-mood
            const mood = this.getAttribute('data-mood');

            // Isi nilai ke input hidden agar dikirim ke server
            selectedMoodInput.value = mood;
        });
    });

    // Validasi sebelum submit form
    diaryForm.addEventListener('submit', function(e) {
        if (!selectedMoodInput.value) {
            e.preventDefault();
            alert('Please select a mood before saving your entry');
            return;
        }

        if (diaryText.value.trim() === '') {
            e.preventDefault();
            alert('Please write something in your diary before saving');
            return;
        }
    });
});

// Auto-hide success/error messages after 4 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(function(alert) {
        // Auto hide after 4 seconds
        setTimeout(function() {
            alert.classList.add('fade-out');
            setTimeout(function() {
                alert.remove();
            }, 300);
        }, 4000);
        
        // Allow manual close by clicking
        alert.addEventListener('click', function() {
            alert.classList.add('fade-out');
            setTimeout(function() {
                alert.remove();
            }, 300);
        });
    });
});

// Edit functionality for mood entries
document.addEventListener('DOMContentLoaded', function() {
    // Edit button click handler
    document.querySelectorAll('.entry-edit').forEach(function(button) {
        button.addEventListener('click', function() {
            const entryId = this.getAttribute('data-entry-id');
            const content = document.getElementById('content-' + entryId);
            const editForm = document.getElementById('edit-form-' + entryId);
            
            // Hide content and show edit form
            content.style.display = 'none';
            editForm.style.display = 'block';
            
            // Focus on textarea
            const textarea = editForm.querySelector('.edit-textarea');
            textarea.focus();
            textarea.setSelectionRange(textarea.value.length, textarea.value.length);
        });
    });
    
    // Cancel edit button click handler
    document.querySelectorAll('.mood-icon').forEach(icon => {
    icon.addEventListener('click', function () {
        const selectedMood = this.getAttribute('data-mood');
        const emoji = this.querySelector('.emoji').innerText;

        document.getElementById('selected-mood').value = selectedMood;
        document.getElementById('selected-emoji').value = emoji;

        // Optional: kasih highlight ke mood terpilih
        document.querySelectorAll('.mood-icon').forEach(i => i.classList.remove('selected'));
        this.classList.add('selected');
     });
    });

});

// Existing mood selection code (tambahkan jika belum ada)
document.addEventListener('DOMContentLoaded', function() {
    const moodIcons = document.querySelectorAll('.mood-icon');
    const selectedMoodInput = document.getElementById('selected-mood');
    
    moodIcons.forEach(function(icon) {
        icon.addEventListener('click', function() {
            // Remove active class from all icons
            moodIcons.forEach(function(i) {
                i.classList.remove('active');
            });
            
            // Add active class to clicked icon
            this.classList.add('active');
            
            // Set selected mood value
            const mood = this.getAttribute('data-mood');
            selectedMoodInput.value = mood;
        });
    });
});