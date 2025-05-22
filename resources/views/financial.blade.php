@extends('layouts.app')

@section('title', 'Financial Tracker')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/financial.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
    <header>
        <h2>Financial Tracker</h2>
    </header>

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
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" id="amount" name="amount" placeholder="Enter amount" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="category" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Salary">Salary</option>
                                <option value="Food">Food</option>
                                <option value="Transportation">Transportation</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="Shopping">Shopping</option>
                                <option value="Bills">Bills</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" id="date" name="date" placeholder="mm/dd/yyyy" class="datepicker" required>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label for="description">Description</label>
                        <input type="text" id="description" name="description" placeholder="Enter description" required>
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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->category }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ $transaction->type === 'expense' ? '-' : '+' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center;">No transactions recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#date", {
                dateFormat: "m/d/Y"
            });
        });
    </script>
@endpush
