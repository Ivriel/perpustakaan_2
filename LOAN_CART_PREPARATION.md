# Persiapan Add to Cart - Peminjaman Buku (Option 1)

## Alur Kerja
1. Visitor/Staff browse buku → klik "Pinjam" → buku masuk session cart
2. Bisa tambah banyak buku (bolak-balik dari daftar buku)
3. Klik "Selesaikan Peminjaman" → redirect ke form checkout
4. Form: review cart, pilih tanggal, submit → create Loan + LoanDetails
5. Clear session cart

## Struktur Session Cart
```
Session key: 'loan_cart'

Struktur data:
[
    ['book_id' => 1, 'title' => '...'],  // optional: title untuk display
    ['book_id' => 2, 'title' => '...'],
]
```

## Yang Perlu Dibuat (Checklist)

### 1. Routes (web.php)
- `GET  /loans/cart` - lihat cart, form checkout
- `POST /loans/cart/add/{book}` - tambah buku ke cart
- `DELETE /loans/cart/remove/{book}` - hapus buku dari cart
- `POST /loans/checkout` - submit peminjaman (create loan + details)
- `GET  /loans` - index (list peminjaman)
- `PATCH /loans/{loan}/status` - ubah status (staff/admin only)

### 2. LoanController Methods
- `cart()` - tampilkan cart + form checkout
- `addToCart(Book $book)` - push ke session
- `removeFromCart(Book $book)` - remove dari session
- `checkout(Request $request)` - validasi, create Loan, foreach LoanDetails, clear cart
- `index()` - list loans (filter by role: visitor lihat sendiri, staff/admin lihat semua)
- `updateStatus(Request $request, Loan $loan)` - ubah status (staff/admin)

### 3. Views
- `loans/cart.blade.php` - list buku di cart + form (tanggal, submit)
- `loans/index.blade.php` - daftar peminjaman
- Tombol "Pinjam" di `bookList/show.blade.php` (dan/atau index) → POST ke addToCart

### 4. Middleware
- Cart routes: auth required
- addToCart, cart, checkout: visitor + staff + admin
- updateStatus: staff + admin only

### 5. Validasi
- Checkout: cart tidak boleh kosong
- Checkout: loan_date, due_date required
- user_id = auth()->id() (visitor pinjam untuk diri sendiri) ATAU staff pilih member

### 6. Catatan
- Loan `user_id` = siapa yang meminjam (anggota). Kalau visitor create = auth()->id(). Kalau staff create untuk anggota = perlu dropdown pilih member (tabel users dengan role visitor).
- Status default saat create: `pending`
