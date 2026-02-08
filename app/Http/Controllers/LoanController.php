<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\LoanDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Tujuan: Tampilkan halaman keranjang peminjaman
// Dipanggil saat user buka URL /loans/cart

class LoanController extends Controller
{
    public function index()
    {
        // Visitor: lihat peminjaman sendiri. Staff/Admin: lihat semua.
        if (Auth::user()->role === 'visitor') {
            $loans = Loan::where('user_id', Auth::id())
                ->with('details.book', 'user')
                ->latest()
                ->get();
        } else {
            $loans = Loan::with('details.book', 'user')
                ->latest()
                ->get();
        }

        return view('loans.index', compact('loans'));
    }

    public function show(string $id)
    {
        $loan = Loan::with('user', 'details.book.categories', 'details.book.rack')->findOrFail($id);

        return view('loans.show', compact('loan'));
    }

    public function cart()
    {

        // Ambil cart dari session. Kalau belum ada, pakai array kosong.
        $cart = session('loan_cart', []);

        // Hitung jumlah per buku. Contoh: 2 Laskar Pelangi + 1 Bumi → [3=>2, 7=>1]
        $quantities = array_count_values(array_column($cart, 'book_id'));

        // Ambil semua book_id dari cart. Contoh: [3, 3, 7]
        $bookIds = array_column($cart, 'book_id');

        // Query buku yang id-nya ada di cart. whereIn tetap jalan meski ada duplikat.
        $books = Book::whereIn('id', $bookIds)->get();

        // ----- CATATAN: Jika ada harga, hitung subtotal per buku dan total keseluruhan -----
        // Persyaratan DB: tabel books punya kolom price; tabel loan_details (unit_price, quantity, subtotal); tabel loans (total_amount).
        // Subtotal = harga per buku × jumlah. Total = jumlah semua subtotal.
        // $subtotals = [];  // key = book_id, value = subtotal (price * qty)
        // $grandTotal = 0;
        // foreach ($books as $book) {
        //     $qty = $quantities[$book->id] ?? 1;
        //     $price = $book->price ?? 0;  // asumsi Book punya atribut price
        //     $subtotal = $price * $qty;
        //     $subtotals[$book->id] = $subtotal;
        //     $grandTotal += $subtotal;
        // }
        // return view('loans.cart', compact('books', 'quantities', 'subtotals', 'grandTotal'));

        // Kirim $books dan $quantities ke view untuk ditampilkan.
        return view('loans.cart', compact('books', 'quantities'));

    }

    public function addToCart(Book $book)
    {
        // --- Ambil cart yang ada (atau array kosong kalau belum pernah di-set) ---
        // session('loan_cart', []) = BACA session dengan key 'loan_cart'.
        //   - Kalau key 'loan_cart' belum ada (user belum pernah add to cart) → kembalikan [] (nilai default).
        //   - Kalau sudah ada (user sudah pernah tambah buku) → kembalikan isi session itu (array of items).
        // Jadi array itu BUKAN "tiba-tiba dari mana": kita yang bikin (kosong dulu) atau ambil yang sudah tersimpan.
        $cart = session('loan_cart', []);

        // --- Tambah 1 item baru ke array ---
        // $cart[] = [...] artinya push 1 elemen ke akhir array
        // Buku sama boleh ditambah berkali-kali = 1 eksemplar per push
        $cart[] = [
            'book_id' => $book->id, // id buku (dari database)
            'title' => $book->title, // judul (untuk display di view, opsional)
            // ----- CATATAN: Jika sistem pakai harga (bukan perpus gratis), simpan juga harga per item -----
            // 'price' => $book->price,  // asumsi tabel books punya kolom price (decimal/integer)
        ];

        // --- Simpan cart baru ke session (ini yang "memasukkan" array ke session) ---
        // session(['loan_cart' => $cart]) = TULIS/UPDATE session: key 'loan_cart' sekarang berisi $cart.
        // Pertama kali add to cart: $cart = [ item1 ]. Setelah ini, session punya loan_cart = [ item1 ].
        // Add to cart lagi: session('loan_cart', []) baca [ item1 ], kita push item2, lalu session di-set lagi = [ item1, item2 ].
        // Session = tempat simpan data sementara per user (hilang kalau logout/clear browser).
        session(['loan_cart' => $cart]);

        // --- Redirect ke halaman sebelumnya ---
        // back() = kembali ke URL sebelumnya (misal: dari detail buku)
        // with('success', '...') = flash message, bisa ditampilkan di view pakai session('success')
        return back()->with('success', 'Buku ditambahkan ke keranjang.');
    }

    // ============================================
    // METHOD: removeFromCart(Book $book)
    // ============================================
    // Tujuan: Hapus 1 eksemplar buku dari cart (bukan semua)
    // Kalau ada 3 kopi Laskar Pelangi, klik hapus = sisa 2
    // ============================================

    public function removeFromCart(Book $book)
    {
        $cart = session('loan_cart', []);
        // --- Cari index item PERTAMA yang book_id-nya sama ---
        // array_column($cart, 'book_id') = [1, 1, 2] (urutan book_id di cart)
        // array_search($book->id, ...) = cari index/posisi pertama yang nilainya = $book->id
        // Hasil: index angka (0, 1, 2...) atau false kalau tidak ketemu

        // array_search: $needle = nilai yang dicari $haystack = array tempat mencari
        $key = array_search($book->id, array_column($cart, 'book_id'));
        // --- Kalau ketemu, hapus 1 elemen itu saja ---
        if ($key !== false) {
            // unset($cart[$key]) = hapus elemen di index $key
            // Contoh: $cart = [A, B, C], unset($cart[1]) → $cart = [A, C] (index 1 hilang)
            unset($cart[$key]);
            // array_values($cart) = ambil nilai array saja, buang key-nya, buat index baru 0,1,2...
            // Penting: kadang unset bikin index "bolong" [0=>A, 2=>C], array_values rapikan jadi [0=>A, 1=>C]
            // setelah unset, index bisa loncat. array_values() membuat index rapi untuk dipakai lagi (misalnya di session / tampilan).
            $cart = array_values($cart);
        }
        session(['loan_cart' => $cart]);

        return back()->with('success', '1 eksemplar dihapus dari keranjang.');
    }

    // ============================================
    // METHOD: checkout(Request $request)
    // ============================================
    // Tujuan: Proses peminjaman = buat 1 Loan + banyak LoanDetail
    // $request = data dari form (tanggal pinjam, due date, dll)
    public function checkout(Request $request)
    {
        // --- VALIDASI: Cek input dari form ---
        // validate() = cek rules, kalau gagal otomatis redirect back + error
        // Kalau lolos, return array data yang sudah divalidasi
        // ----- CATATAN: Jika ada total bayar, bisa validasi atau konfirmasi dari form -----
        // $request->validate(['total_amount' => 'nullable|numeric|min:0', ...]);
        $validated = $request->validate([
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
        ], [
            'loan_date.required' => 'Tanggal pinjam wajib diisi.',
            'due_date.required' => 'Tanggal jatuh tempo wajib diisi.',
        ]);
        // --- Ambil cart ---
        $cart = session('loan_cart', []);
        // --- Cek cart tidak boleh kosong ---
        // empty($cart) = true kalau array kosong []
        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong. Tambah buku dulu.');
        }

        try {
            DB::beginTransaction();
            // --- BUAT 1 RECORD LOAN ---
            // Loan::create([...]) = INSERT INTO loans (...) VALUES (...)
            // ----- CATATAN: Jika pakai total_amount, tambah kolom total_amount di tabel loans (migration) -----
            $loan = Loan::create([
                'user_id' => Auth::id(),
                'loan_date' => $validated['loan_date'],
                'due_date' => $validated['due_date'],
                'return_date' => null,
                'fine_amount' => 0,
                'status' => 'pending',
                // 'total_amount' => 0,  // nanti di-update setelah loop di bawah
            ]);

            // ----- CATATAN: Jika pakai unit_price/quantity/subtotal di LoanDetail, hitung dulu: $quantities = array_count_values(array_column($cart, 'book_id')); -----
            foreach ($cart as $item) {
                LoanDetail::create([
                    'loan_id' => $loan->id,
                    'book_id' => $item['book_id'],
                    'condition' => 'good',
                    // ----- CATATAN: Jika sistem berbayar, simpan harga & subtotal per detail (tambah kolom di tabel loan_details) -----
                    // 'unit_price' => $item['price'] ?? 0,
                    // 'quantity' => 1,  // di design sekarang 1 item cart = 1 eksemplar. Kalau grup per buku: pakai $quantities[$item['book_id']]
                    // 'subtotal' => ($item['price'] ?? 0) * 1,  // atau * ($quantities[$item['book_id']] ?? 1) kalau quantity per baris > 1
                ]);
            }
            // ----- CATATAN: Total bayar bisa disimpan di Loan (misal kolom total_amount) -----
            // $quantities = array_count_values(array_column($cart, 'book_id'));
            // $totalAmount = 0;
            // foreach ($cart as $item) {
            //     $totalAmount += ($item['price'] ?? 0);  // 1 item = 1 eksemplar, price sudah per item
            // }
            // $loan->update(['total_amount' => $totalAmount]);
            session()->forget('loan_cart');

            // --- Redirect ke halaman daftar loan ---
            // route('loans.index') = URL berdasarkan nama route (cek di web.php)
            DB::commit();

            return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil diajukan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Peminjaman gagal: '.$e->getMessage());
        }
    }

    public function updateStatus(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'status' => 'required|in:borrowed,returned,overdue',
        ]);
        $newStatus = $validated['status'];
        // Kalau mau approve jadi borrowed: cek stok dulu
        if ($newStatus === 'borrowed') {
            foreach ($loan->details as $detail) {
                $book = $detail->book;
                $qtyInLoan = $loan->details->where('book_id', $book->id)->count();
                if ($book->stock < $qtyInLoan) {
                    return back()->with('error', "Stok {$book->title} tidak cukup (butuh {$qtyInLoan}).");
                }
            }
        }
        try {
            DB::beginTransaction();

            if ($newStatus === 'borrowed') {
                foreach ($loan->details as $detail) {
                    $detail->book->decrement('stock');
                }
                $loan->update(['status' => 'borrowed']);
            } elseif ($newStatus === 'returned') {
                foreach ($loan->details as $detail) {
                    $detail->book->increment('stock');
                }
                $loan->update([
                    'status' => 'returned',
                    'return_date' => now(),
                ]);
            } else {
                $loan->update(['status' => $newStatus]);
            }

            DB::commit();

            return back()->with('success', 'Status peminjaman diubah.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal: '.$e->getMessage());
        }
    }

    public function printReceipt($id)
    {
        $loan = Loan::with('user', 'details.book.categories', 'details.book.rack')->findOrFail($id);
        $data = [
            'loan' => $loan,
            'tanggal_dicetak' => now()->format('d/m/Y H:i:s'),
            'loan_date_formatted' => \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y'),
            'due_date_formatted' => \Carbon\Carbon::parse($loan->due_date)->format('d/m/Y'),
            'return_date_formatted' => $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') : null,
        ];
        $pdf = Pdf::loadView('loans.receipt', $data);
        $pdf->setPaper([0, 0, 600, 800], 'portrait');

        return $pdf->stream('bukti-peminjaman-perpus-v2-#'.$loan->id.'.pdf');
    }
}
