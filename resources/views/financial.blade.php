@extends('layouts.app')

@section('title', 'Financial Tracker')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/financial.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
      /* Modal styles */
      .modal {
        display: none;
        position: fixed; 
        z-index: 1000; 
        left: 0; top: 0; 
        width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.5);
        overflow: auto;
      }
      .modal.show {
        display: block;
      }
      .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 5px;
        width: 400px;
        max-width: 90%;
      }
      .form-actions {
        margin-top: 15px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
      }
      .btn-cancel {
        background-color: #ccc;
        border: none;
        padding: 6px 12px;
        cursor: pointer;
        border-radius: 3px;
      }
      .btn-danger {
        background-color: #e74c3c;
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 3px;
        cursor: pointer;
      }
    </style>
@endpush

@section('content')
    <header>
        <h2>Financial Tracker</h2>
    </header>

    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    <div class="dashboard-grid">
        <!-- Transaction Form Card -->
        <div class="card">
            <section class="transaction-form">
                <form method="POST" action="{{ route('financial.store') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="transaction-type">Jenis Transaksi</label>
                            <select id="transaction-type" name="type" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                            @error('type')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" id="amount" name="amount" placeholder="Enter amount" value="{{ old('amount') }}" required>
                            @error('amount')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="category" required>
                                <option value="">-- Pilih Kategori --</option>
                                @php
                                    $categories = ['Salary', 'Food', 'Transportation', 'Entertainment', 'Shopping', 'Bills', 'Others'];
                                @endphp
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" id="date" name="date" placeholder="mm/dd/yyyy" class="datepicker" value="{{ old('date') }}" required>
                            @error('date')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label for="description">Description</label>
                        <input type="text" id="description" name="description" placeholder="Enter description" value="{{ old('description') }}" required>
                        @error('description')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn">Add Transaction</button>
                    </div>
                </form>
            </section>
        </div>

        <!-- Transaction History Card -->
        <div class="card">
            <section class="transaction-history">
                <h3>Transaction History</h3>
                <div class="transaction-table">
                    <table id="transactions-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $transaction)
                                <tr data-id="{{ $transaction->id }}" 
                                    data-type="{{ $transaction->type }}" 
                                    data-category="{{ $transaction->category }}" 
                                    data-description="{{ $transaction->description }}" 
                                    data-amount="{{ $transaction->amount }}" 
                                    data-date="{{ \Carbon\Carbon::parse($transaction->date)->format('m/d/Y') }}">
                                    <td>{{ \Carbon\Carbon::parse($transaction->date)->format('m/d/Y') }}</td>
                                    <td>{{ $transaction->category }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td class="{{ $transaction->type === 'expense' ? 'text-expense' : 'text-income' }}">
                                        {{ $transaction->type === 'expense' ? '-' : '+' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <button class="btn btn-edit" type="button">Edit</button>
                                        <button class="btn btn-delete" type="button">Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center;">No transactions recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="modal">
      <div class="modal-content">
        <h3>Edit Transaction</h3>
        <form id="edit-form" method="POST" action="{{ route('financial.update') }}">
          @csrf
          @method('PUT')
          <input type="hidden" name="id" id="edit-id">
          <div class="form-row">
            <div class="form-group">
              <label for="edit-type">Jenis Transaksi</label>
              <select id="edit-type" name="type" required>
                <option value="income">Income</option>
                <option value="expense">Expense</option>
              </select>
            </div>
            <div class="form-group">
              <label for="edit-amount">Amount</label>
              <input type="number" id="edit-amount" name="amount" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="edit-category">Category</label>
              <select id="edit-category" name="category" required>
                @php
                    $categories = ['Salary', 'Food', 'Transportation', 'Entertainment', 'Shopping', 'Bills', 'Others'];
                @endphp
                @foreach($categories as $category)
                  <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="edit-date">Date</label>
              <input type="text" id="edit-date" name="date" class="datepicker" required>
            </div>
          </div>
          <div class="form-group full-width">
            <label for="edit-description">Description</label>
            <input type="text" id="edit-description" name="description" required>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn">Simpan</button>
            <button type="button" class="btn btn-cancel">Batal</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete Modal -->
    <div id="delete-modal" class="modal">
      <div class="modal-content">
        <h3>Konfirmasi Hapus</h3>
        <p>Apakah Anda yakin ingin menghapus transaksi ini?</p>
        <form id="delete-form" method="POST" action="{{ route('financial.destroy') }}">
          @csrf
          @method('DELETE')
          <input type="hidden" name="id" id="delete-id">
          <div class="form-actions">
            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            <button type="button" class="btn btn-cancel">Batal</button>
          </div>
        </form>
      </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Init flatpickr form tambah transaksi
  flatpickr("#date", {
    dateFormat: "m/d/Y",
    defaultDate: "{{ old('date') ?? now()->format('m/d/Y') }}"
  });

  let editDatePicker;

  const editModal = document.getElementById('edit-modal');
  const deleteModal = document.getElementById('delete-modal');

  const editForm = document.getElementById('edit-form');
  const deleteForm = document.getElementById('delete-form');

  // Event tombol Edit
  document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function() {
      const tr = this.closest('tr');
      const id = tr.dataset.id;
      const type = tr.dataset.type;
      const category = tr.dataset.category;
      const description = tr.dataset.description;
      const amount = tr.dataset.amount;
      const date = tr.dataset.date;

      document.getElementById('edit-id').value = id;
      document.getElementById('edit-type').value = type;
      document.getElementById('edit-category').value = category;
      document.getElementById('edit-description').value = description;
      document.getElementById('edit-amount').value = amount;

      // Init flatpickr untuk input date di modal edit
      if (editDatePicker) editDatePicker.destroy();
      editDatePicker = flatpickr("#edit-date", {
        dateFormat: "m/d/Y",
        defaultDate: date
      });

      editModal.classList.add('show');
    });
  });

  // Event tombol Hapus
  document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
      const tr = this.closest('tr');
      const id = tr.dataset.id;

      document.getElementById('delete-id').value = id;
      deleteModal.classList.add('show');
    });
  });

  // Tombol batal modal
  document.querySelectorAll('.btn-cancel').forEach(btn => {
    btn.addEventListener('click', () => {
      editModal.classList.remove('show');
      deleteModal.classList.remove('show');
    });
  });

  // Klik di luar modal-content untuk tutup modal
  [editModal, deleteModal].forEach(modal => {
    modal.addEventListener('click', e => {
      if (e.target === modal) {
        modal.classList.remove('show');
      }
    });
  });
});
</script>
@endpush