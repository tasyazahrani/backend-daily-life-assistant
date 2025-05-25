<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class FinancialController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->id())
                                  ->orderBy('date', 'desc')
                                  ->get();
        return view('financial', compact('transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric',
            'category' => 'required|string',
            'date' => 'required|date',
            'description' => 'required|string',
        ]);

        Transaction::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'amount' => $request->amount,
            'category' => $request->category,
            'date' => Carbon::createFromFormat('m/d/Y', $request->date)->format('Y-m-d'),
            'description' => $request->description,
        ]);

        return redirect('/financial')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:transactions,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric',
            'category' => 'required|string',
            'date' => 'required|date',
            'description' => 'required|string',
        ]);

        $transaction = Transaction::where('id', $request->id)
                                 ->where('user_id', auth()->id())
                                 ->firstOrFail();
        
        $transaction->update([
            'type' => $request->type,
            'amount' => $request->amount,
            'category' => $request->category,
            'date' => Carbon::createFromFormat('m/d/Y', $request->date)->format('Y-m-d'),
            'description' => $request->description,
        ]);

        return redirect()->route('financial.index')->with('success', 'Transaksi berhasil diupdate!');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:transactions,id'
        ]);

        $transaction = Transaction::where('id', $request->id)
                                 ->where('user_id', auth()->id())
                                 ->firstOrFail();
        
        $transaction->delete();

        return redirect()->route('financial.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}