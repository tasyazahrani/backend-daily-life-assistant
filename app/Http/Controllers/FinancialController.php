<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;


class FinancialController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('date', 'desc')->get();
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
        'type' => $request->type,
        'amount' => $request->amount,
        'category' => $request->category,
        'date' => Carbon::createFromFormat('m/d/Y', $request->date)->format('Y-m-d'),
        'description' => $request->description,
    ]);

    return redirect('/financial')->with('success', 'Transaksi berhasil ditambahkan!');
}
}