<?= $this->extend('admin/admin-partials/index') ?>

<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .progress {
        height: 20px;
        background-color: #f3f3f3;
        border-radius: 5px;
        overflow: hidden ;
    }
    .progress-bar {
        height: 100%;
        background-color: #4caf50;
        text-align: center;
        line-height: 20px;
        color: white;
        transition: width 0.4s ease;
    }
    .drop-zone {
        border: 2px dashed #007bff;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        margin-top: 10px;
    }
    .drop-zone:hover {
        background-color: #e9ecef;
    }
    .video-container {
        margin-top: 10px;
    }
    /* .remove-video {
        position: absolute;
        top: 10px;
        right: 4px;
        background: rgba(255, 255, 255, 0.7);
        border: none;
        cursor: pointer;
    } */
/* ==========================================================
   DATATABLES TO MODERN CARDS (Manajemen Episode)
   ========================================================== */

#dataTable thead {
    display: none !important;
}

/* 1. Pembungkus Atas (Search & Length Menu) */
.dataTables_wrapper .top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    padding: 0 10px 20px 10px;
}

.dataTables_length select, .dataTables_filter input {
    border: 1px solid #e2e8f0 !important;
    border-radius: 8px !important;
    padding: 6px 12px !important;
    outline: none !important;
    transition: all 0.3s ease;
}

.dataTables_length select:focus, .dataTables_filter input:focus {
    border-color: #ac11e9 !important;
    box-shadow: 0 0 0 3px rgba(172, 17, 233, 0.1) !important;
}

/* 2. Ubah Tabel menjadi Grid */
#dataTable {
    display: grid !important;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)) !important; 
    gap: 25px !important; 
    width: 100% !important;
    background: transparent !important;
    border: none !important;
    margin: 0 !important; 
}

.table-responsive {
    padding: 0 10px !important; 
    overflow-x: visible !important; 
}

#dataTable tbody {
    display: contents !important;
}
#dataTable > *:not(tbody) {
    display: none !important;
}

/* 3. Kartu Episode */
#dataTable tbody tr {
    display: flex !important;
    flex-direction: column;
    background: #ffffff;
    border-radius: 16px;
    padding: 0 !important; 
    margin: 0 !important; 
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    min-height: 310px; 
    width: 100% !important; 
}

/* Hover Effect pada Kartu */
#dataTable tbody tr:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 25px rgba(172, 17, 233, 0.15);
    border-color: rgba(172, 17, 233, 0.2);
}

#dataTable tbody td {
    display: block !important;
    padding: 0 !important;
    margin: 0 !important; 
    border: none !important;
    background: transparent !important;
    width: 100% !important; 
}

/* KOLOM 1: Gambar Cover */
#dataTable tbody td:nth-child(1) { 
    height: 170px;
    position: relative;
}
#dataTable tbody td:nth-child(1) img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
/* Efek gradient bawah pada gambar agar text/badge lebih jelas */
#dataTable tbody td:nth-child(1)::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 40%;
    background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
}

/* KOLOM 2: Nomor Episode (Badge) */
#dataTable tbody td:nth-child(2) {
    position: absolute;
    top: 12px; 
    left: 12px; 
    z-index: 10;
    width: auto !important; 
}
#dataTable tbody td:nth-child(2) span.btn-dark {
    background: #ac11e9 !important;
    border: none;
    border-radius: 6px;
    padding: 5px 12px;
    font-size: 0.75rem;
    font-weight: 700;
    color: white;
    box-shadow: 0 4px 10px rgba(172, 17, 233, 0.4);
    letter-spacing: 0.5px;
}

/* KOLOM 3: Deskripsi */
#dataTable tbody td:nth-child(3) {
    padding: 16px !important; 
    flex-grow: 1; 
}
#dataTable tbody td:nth-child(3) span.desc {
    color: #475569;
    font-size: 0.85rem;
    font-weight: 500;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* --- FOOTER KARTU (Views & Aksi) --- */
#dataTable tbody tr {
    padding-bottom: 50px; 
}

#dataTable tbody td:nth-child(4),
#dataTable tbody td:nth-child(5) {
    position: absolute;
    bottom: 0;
    height: 50px; 
    background: #f8fafc;
    border-top: 1px solid #f1f5f9 !important;
    display: flex !important;
    align-items: center;
}

/* KOLOM 4 (Views) */
#dataTable tbody td:nth-child(4) {
    left: 0;
    padding: 0 16px !important; 
    width: 50% !important; 
}

/* KOLOM 5 (Aksi) */
#dataTable tbody td:nth-child(5) {
    right: 0;
    padding: 0 16px !important; 
    width: 50% !important; 
    justify-content: flex-end;
}

.ep-action-buttons {
    display: flex;
    gap: 8px;
}
.ep-action-buttons button {
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 0.8rem;
    transition: all 0.2s;
}
.ep-action-buttons button:hover {
    transform: scale(1.1);
}

/* ==========================================
   TAMPILAN PAGINATION "CAPSULE UI" (KHUSUS BOOTSTRAP)
   ========================================== */

/* 1. KUNCI UNTUK MENURUNKAN JARAK (SUPER STRONG MARGIN) */
/* Karena Bootstrap menggunakan div class="row" untuk membungkus pagination, kita dorong row terakhirnya */
.dataTables_wrapper .row:last-of-type {
    margin-top: 50px !important; 
    display: flex;
    align-items: center;
}

/* Dorong juga div pagination-nya langsung untuk berjaga-jaga */
.dataTables_wrapper .dataTables_paginate {
    margin-top: 20px !important;
    display: flex;
    justify-content: flex-end;
}

/* 2. Kapsul Pembungkus (Targeting tag <ul> Bootstrap) */
.dataTables_wrapper .pagination {
    display: inline-flex !important;
    align-items: center !important;
    background: #ffffff !important; 
    border: 1px solid #e2e8f0 !important; 
    border-radius: 50px !important; 
    padding: 6px 16px !important;
    margin: 0 !important;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03) !important;
    gap: 4px !important;
}

/* 3. Hilangkan border kotak-kotak bawaan Bootstrap pada tag <li> */
.dataTables_wrapper .page-item {
    border: none !important;
    margin: 0 !important;
    padding: 0 !important;
}

/* 4. Desain Dasar Teks & Angka (Targeting tag <a> Bootstrap) */
.dataTables_wrapper .page-link {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    min-width: 36px !important; 
    height: 36px !important;
    padding: 0 10px !important;
    border: none !important; 
    background: transparent !important; 
    color: #64748b !important; 
    font-weight: 800 !important; 
    font-size: 0.8rem !important;
    text-transform: uppercase !important;
    border-radius: 50px !important; 
    transition: all 0.3s ease !important;
    box-shadow: none !important;
}

/* 5. State: ACTIVE (Lingkaran Ungu Menyala) */
.dataTables_wrapper .page-item.active .page-link {
    background: #ac11e9 !important; 
    color: #ffffff !important;
    width: 36px !important; 
    height: 36px !important;
    padding: 0 !important; 
    border-radius: 50% !important; /* Buat jadi lingkaran */
    box-shadow: 0 0 15px rgba(172, 17, 233, 0.4) !important; 
    z-index: 3 !important;
}

/* 6. State: HOVER (Saat disentuh) */
.dataTables_wrapper .page-item:not(.active):not(.disabled) .page-link:hover {
    background: rgba(172, 17, 233, 0.08) !important;
    color: #ac11e9 !important;
}

/* 7. State: DISABLED (Mentok di ujung) */
.dataTables_wrapper .page-item.disabled .page-link {
    background: transparent !important;
    color: #cbd5e1 !important;
    border: none !important;
    opacity: 0.6 !important;
}

/* ==========================================
   ANIMASI SECTION DETAIL ATAS (Poster & Info)
   ========================================== */

/* 1. Target Kolom Kiri (Poster Anime) */
.detail-wrapper > .row > div:nth-child(1) {
    opacity: 0;
    transform: translateY(30px);
    /* Gunakan keyframe fadeSlideUp yang sudah kita buat sebelumnya */
    animation: fadeSlideUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    animation-delay: 0.1s; /* Mulai duluan setelah 0.1 detik */
}

/* 2. Target Kolom Kanan (Card Info Anime) */
.detail-wrapper > .row > div:nth-child(2) {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeSlideUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    animation-delay: 0.3s; /* Muncul sedikit lebih telat agar berurutan (staggered) */
}

/* ==========================================
   ANIMASI KARTU EPISODE (Masuk Berurutan)
   ========================================== */

/* State awal kartu sebelum dianimasikan (Transparan & turun ke bawah) */
#dataTable tbody tr {
    opacity: 0; 
    transform: translateY(30px); /* Posisi awal sedikit di bawah */
}

/* Class yang akan disuntikkan oleh Javascript */
.card-animated {
    animation: fadeSlideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

/* Keyframes Animasinya */
@keyframes fadeSlideUp {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0); /* Kembali ke posisi semula */
    }
}

/* State awal (Sembunyi dan agak ke bawah) */
.btn-group-custom .modern-action-btn {
    opacity: 0;
    transform: translateY(20px);
    /* Gunakan animasi yang sama dengan form & grid (fadeSlideUp) */
    animation: fadeSlideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

/* Jeda berurutan dari kiri ke kanan (Staggered effect) */

/* Tombol 1: Tambah Episode */
.btn-group-custom .modern-action-btn:nth-child(1) {
    animation-delay: 0.4s; /* Muncul setelah Info Anime di atasnya selesai */
}

/* Tombol 2: Edit Anime */
.btn-group-custom .modern-action-btn:nth-child(2) {
    animation-delay: 0.5s; /* Telat 0.1 detik dari tombol pertama */
}

/* Tombol 3: Hapus Semua */
.btn-group-custom .modern-action-btn:nth-child(3) {
    animation-delay: 0.6s; /* Telat 0.1 detik dari tombol kedua */
}

/* --- RESPONSIF MOBILE --- */
@media (max-width: 768px) {
    /* 1. Paksa Grid menjadi 2 Kolom di HP */
    #dataTable {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 12px !important; /* Jarak antar kartu diperkecil agar tidak sempit */
    }

    /* 2. Sesuaikan Kartu dan Gambar agar proporsional */
    #dataTable tbody tr {
        min-height: 250px; /* Tinggi kartu dikurangi */
        padding-bottom: 40px; /* Area footer dikurangi */
    }
    #dataTable tbody td:nth-child(1) {
        height: 110px; /* Gambar dibuat lebih pendek agar tidak seperti persegi panjang berdiri */
    }
    #dataTable tbody td:nth-child(2) {
        top: 8px; left: 8px; /* Margin badge disesuaikan */
    }
    #dataTable tbody td:nth-child(2) span.btn-dark {
        padding: 3px 8px;
        font-size: 0.65rem; /* Font badge diperkecil */
    }

    /* 3. Sesuaikan area Deskripsi */
    #dataTable tbody td:nth-child(3) {
        padding: 10px !important; 
    }
    #dataTable tbody td:nth-child(3) span.desc {
        font-size: 0.75rem; /* Font deskripsi diperkecil */
        -webkit-line-clamp: 2; 
    }

    /* 4. Sesuaikan area Footer (Views dan Tombol Aksi) */
    #dataTable tbody td:nth-child(4),
    #dataTable tbody td:nth-child(5) {
        height: 40px; 
        padding: 0 10px !important; 
    }
    #dataTable tbody td:nth-child(4) span {
        font-size: 0.75rem !important; /* Icon mata & angka views */
    }
    .ep-action-buttons {
        gap: 4px; /* Jarak antar tombol edit & delete */
    }
    .ep-action-buttons button {
        padding: 4px 8px;
        font-size: 0.7rem; /* Ukuran icon tombol diperkecil */
    }

    /* 5. Perbaikan Search Bar & Layout Atas DataTables */
    .dataTables_wrapper .top {
        flex-direction: column;
        justify-content: center;
        align-items: stretch; /* Biar search bar full width */
        gap: 10px;
    }
    .dataTables_filter input {
        width: 100% !important; /* Kotak search full layar HP */
        margin-left: 0 !important;
    }

    /* 6. Perbaikan Pagination Bawah */
    .dataTables_wrapper .bottom {
        flex-direction: column;
        justify-content: center;
        text-align: center;
        gap: 20px;
        margin-top: 45px !important; 
        padding-top: 15px !important;
    }
    .dataTables_paginate ul.pagination {
        flex-wrap: wrap !important;
        justify-content: center !important;
        gap: 5px !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button a {
        min-width: 32px !important;
        height: 32px !important;
        padding: 0 8px !important;
        font-size: 0.75rem !important;
    }
        /* 1. Lebarkan Pop-up hingga menyentuh tepi layar HP */
        .swal-edit-modal {
        width: 95% !important; /* Gunakan hampir seluruh layar HP */
        margin: 0 auto !important;
    }

    /* 2. Perbaiki Header (Cegah tombol X turun ke bawah) */
    .swal-edit-modal .anime-card-header {
        padding: 15px 20px !important; /* Kurangi padding header */
        flex-wrap: nowrap !important; /* Paksa agar judul dan X tetap 1 baris */
        align-items: flex-start !important;
    }
    .swal-edit-modal .anime-card-header h4 {
        font-size: 1rem !important; /* Kecilkan ukuran judul */
    }
    .swal-edit-modal .anime-card-header h4 i {
        font-size: 1.2rem !important;
        margin-right: 12px !important;
        margin-top: 2px;
    }
    .swal-edit-modal .anime-card-header h4 small {
        font-size: 0.75rem !important;
        line-height: 1.4;
    }
    .swal-edit-modal .anime-card-header .close {
        font-size: 1.5rem !important;
        margin-top: -5px !important;
        margin-left: 10px !important; /* Beri jarak agar tidak menempel dengan teks */
    }

    /* Paksa pop-up SweetAlert memotong apapun yang keluar dari kotaknya */
    .swal-edit-modal .swal2-html-container {
        overflow: hidden !important; 
        margin: 0 !important; 
        display: flex;
        flex-direction: column; /* Susun Header dan Konten secara vertikal */
    }

    /* Pastikan Header tetap di atas dan tidak ikut terscroll */
    .swal-edit-modal .anime-card-header {
        position: relative; /* Diam di tempat */
        z-index: 10;
        box-shadow: 0 4px 6px -4px rgba(0,0,0,0.1); /* Efek bayangan halus agar terlihat terpisah dari form */
    }

    /* Area yang bisa di-scroll (Overflow) */
    .swal-edit-wrapper {
        padding: 20px 15px 30px 15px !important; /* Ruang bernapas yang cukup */
        max-height: 70vh !important; /* Maksimal tinggi 70% dari layar HP */
        overflow-y: auto !important; /* AKTIFKAN SCROLL VERTIKAL */
        overflow-x: hidden !important; 
    }

    /* 4. Hilangkan Garis Pembatas Vertikal (Karena di HP kolomnya bertumpuk atas-bawah) */
    .swal-edit-wrapper .border-right {
        border-right: none !important;
        padding-right: 0 !important;
        margin-bottom: 25px; 
    }

    /* 5. Sesuaikan Ukuran Box Upload & Teks */
    .swal-edit-wrapper .upload-box {
        padding: 15px !important;
    }
    .swal-edit-wrapper .form-section-title {
        font-size: 11px !important;
        margin-bottom: 15px !important;
    }
    .swal-edit-wrapper .custom-group label {
        font-size: 12px !important;
    }

    /* 6. DESAIN SCROLLBAR KHUSUS MOBILE (Tipis & Elegan) */
    .swal-edit-wrapper::-webkit-scrollbar {
        display: block !important; /* Tampilkan scrollbar */
        width: 4px !important; /* Buat SANGAT TIPIS (4px) agar tidak makan tempat di HP */
    }
    .swal-edit-wrapper::-webkit-scrollbar-track {
        background: transparent !important; /* Background transparan */
        margin-bottom: 15px; 
        margin-top: 10px;
    }
    .swal-edit-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e1 !important; /* Abu-abu kalem */
        border-radius: 10px;
    }
} 


/* ==========================================
   CLONE STYLE "TAMBAH EPISODE" UNTUK POP-UP EDIT
   ========================================== */

/* Override bawaan SweetAlert agar full layar mirip halaman */
.swal-edit-modal {
    padding: 0 !important;
    border-radius: 20px !important;
    overflow: hidden;
}

/* Wrapper Utama dalam Pop-up */
.swal-edit-wrapper {
    text-align: left;
    color: #32325d;
    font-family: inherit;
    padding: 20px 30px 40px 30px;
}

/* Styling Judul Section */
.swal-edit-wrapper .form-section-title { 
    font-size: 13px; 
    text-transform: uppercase; 
    letter-spacing: 1px; 
    color: #8898aa; 
    font-weight: 700; 
    margin-bottom: 25px; 
    display: block; 
    border-bottom: 2px solid #5e72e4; 
    width: fit-content; 
    padding-bottom: 5px; 
}

/* Input & Form Group */
.swal-edit-wrapper .custom-group label { 
    font-weight: 600; 
    font-size: 14px; 
    color: #32325d; 
    margin-bottom: 8px; 
    display: block;
}
.swal-edit-wrapper .custom-input-style { 
    border-radius: 10px !important; 
    border: 1px solid #dee2e6 !important; 
    padding: 12px 15px !important; 
    height: auto !important; 
    font-size: 14px; 
    background: #ffffff;
    width: 100%;
}
.swal-edit-wrapper .custom-input-style:focus {
    border-color: #5e72e4 !important;
    box-shadow: 0 0 0 3px rgba(94, 114, 228, 0.1) !important;
    outline: none;
}

/* Media Box (Thumbnail & Video) */
.swal-edit-wrapper .upload-box { 
    background: #f8f9fe; 
    border: 2px dashed #dee2e6; 
    border-radius: 15px; 
    padding: 20px; 
    margin-bottom: 20px; 
    text-align: center; 
    transition: all 0.3s; 
}
.swal-edit-wrapper .upload-box:hover { 
    border-color: #5e72e4; 
    background: #f0f2ff; 
}

/* Dropzone Video */
.swal-edit-wrapper .drop-zone { 
    cursor: pointer; 
    padding: 30px 10px; 
    color: #8898aa; 
    font-weight: 600; 
    font-size: 14px; 
}
.swal-edit-wrapper .drop-zone i { 
    font-size: 2.5rem; 
    color: #5e72e4; 
    margin-bottom: 10px; 
    display: block; 
}

/* Tombol Submit & Batal */
.swal-edit-wrapper .btn-save { 
    background: #5e72e4; 
    color: white; 
    font-weight: 700; 
    padding: 14px; 
    border-radius: 12px; 
    border: none; 
    transition: 0.3s; 
    width: 100%;
    margin-top: 15px;
}
.swal-edit-wrapper .btn-save:hover { 
    background: #4559d4; 
    transform: translateY(-2px); 
    box-shadow: 0 7px 14px rgba(50,50,93,.1), 0 3px 6px rgba(0,0,0,.08); 
}
.swal-edit-wrapper .btn-cancel {
    background: #f1f3f9;
    color: #8898aa;
    font-weight: 700;
    padding: 14px;
    border-radius: 12px;
    border: none;
    width: 100%;
    margin-top: 10px;
    transition: 0.3s;
}
.swal-edit-wrapper .btn-cancel:hover {
    background: #e2e8f0;
    color: #32325d;
}

/* ==========================================
   INTERNAL SCROLL & CUSTOM SCROLLBAR POP-UP
   ========================================== */

/* 1. Matikan scroll bawaan SweetAlert agar tidak ada scroll ganda */
.swal-edit-modal .swal2-html-container {
    overflow: hidden !important; 
    margin: 0 !important; /* Hilangkan margin bawaan */
}

/* 2. Berikan batas maksimal tinggi dan aktifkan scroll HANYA pada isi form */
.swal-edit-wrapper {
    max-height: 70vh; /* Tinggi maksimal konten adalah 70% dari tinggi layar monitor */
    overflow-y: auto; /* Aktifkan scroll vertikal di dalam kotak ini saja */
    overflow-x: hidden; /* Sembunyikan scroll horizontal */
    
    /* Sedikit penyesuaian padding agar scrollbar tidak menempel ke teks */
    padding-right: 15px !important; 
    margin-right: 5px; 
}

/* 3. --- DESAIN CUSTOM SCROLLBAR MODERN (WEBKIT) --- */

/* Mengatur lebar scrollbar (Dibuat tipis & elegan) */
.swal-edit-wrapper::-webkit-scrollbar {
    width: 8px;
}

/* Mengatur jalur/track scrollbar (Background) */
.swal-edit-wrapper::-webkit-scrollbar-track {
    background: #f1f5f9; /* Warna abu-abu sangat muda */
    border-radius: 10px;
    margin-bottom: 20px; /* Beri jarak sedikit dari bawah */
}

/* Mengatur batang scrollbar (Thumb) */
.swal-edit-wrapper::-webkit-scrollbar-thumb {
    background: #cbd5e1; /* Warna abu-abu solid */
    border-radius: 10px;
    border: 2px solid #f1f5f9; /* Efek padding di dalam track */
    transition: background 0.3s ease;
}

/* Mengatur batang scrollbar saat disentuh mouse (Hover) */
.swal-edit-wrapper::-webkit-scrollbar-thumb:hover {
    background: #5e72e4; /* Berubah menjadi warna biru-ungu khas website Anda saat disentuh */
}

/* ==========================================
   MODERN ACTION BUTTONS (Header)
   ========================================== */

/* Wadah Tombol (Gunakan gap agar jarak antar tombol rapi) */
.btn-group-custom {
    display: flex;
    flex-wrap: wrap;
    gap: 10px; /* Jarak merata antar tombol */
}

/* Desain Dasar Semua Tombol */
.modern-action-btn {
    font-weight: 700;
    font-size: 0.85rem;
    padding: 10px 20px;
    border-radius: 50px; /* Bentuk Pill/Kapsul */
    border: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 8px; /* Jarak antara ikon dan teks */
    letter-spacing: 0.3px;
    text-decoration: none !important;
    cursor: pointer;
}
.modern-action-btn i {
    font-size: 1rem;
}

/* 1. Tombol PRIMARY (Tambah Episode) - Paling Menonjol */
.btn-add-modern {
    background: linear-gradient(135deg, #ac11e9, #7c3aed); /* Gradien ungu khas web Anda */
    color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(172, 17, 233, 0.25);
}
.btn-add-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(172, 17, 233, 0.4);
}

/* 2. Tombol SECONDARY (Edit Anime) - Soft UI Kuning/Jingga */
.btn-edit-modern {
    background: #fff8eb; /* Latar belakang kuning sangat pucat */
    color: #f59e0b !important; /* Teks kuning/jingga tegas */
    border: 1px solid rgba(245, 158, 11, 0.2);
}
.btn-edit-modern:hover {
    background: #fef3c7;
    color: #d97706 !important;
    transform: translateY(-2px);
}

/* 3. Tombol DANGER (Hapus Semua) - Soft UI Merah */
.btn-delete-modern {
    background: #fef2f2; /* Latar belakang merah sangat pucat */
    color: #ef4444 !important; /* Teks merah tegas */
    border: 1px solid rgba(239, 68, 68, 0.2);
}
.btn-delete-modern:hover {
    background: #fee2e2;
    color: #dc2626 !important;
    transform: translateY(-2px);
}

</style>
<!-- Breadcrumb -->
<div class="container-fluid py-4 px-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="<?= url_to('dashboard') ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Anime</li>
        </ol>
    </nav>

    <!-- Detail Section -->
    <div class="detail-wrapper mb-4">
        <div class="row">
            <!-- Poster Column -->
            <div class="col-lg-4 col-md-5 mb-4">
                <div class="poster-wrapper-detail h-100">
                    <?php
                    $posterPath = 'assets/images/' . $animes['Poster'];
                    $posterUrl = (file_exists($posterPath)) ? base_url($posterPath) : $animes['Poster'];
                    ?>
                    <img src="<?= $posterUrl ?>" alt="<?= $animes['Judul'] ?>" class="img-fluid main-poster shadow">
                    
                    <div class="status-overlay">
                        <span class="badge badge-<?= ($animes['statusTayang'] == 'published') ? 'success' : 'warning' ?> p-2 px-3 shadow">
                            <i class="fas <?= ($animes['statusTayang'] == 'published') ? 'fa-check-circle' : 'fa-pause-circle' ?>"></i> 
                            <?= strtoupper($animes['statusTayang']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Info Column -->
            <div class="col-lg-8 col-md-7 mb-4">
                <div class="info-card p-4 h-100 shadow-sm border-0">
                <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap">
                    <div>
                        <h1 class="h2 font-weight-bold mb-1 text-dark"><?= $animes['Judul'] ?></h1>
                        <h6 class="text-muted font-italic"><?= $animes['JudulLainnya'] ?></h6>
                    </div>
                    
                    <!-- Pindahkan Tombol Edit ke Sini, berdampingan dengan tombol Kembali -->
                    <div class="d-flex" style="gap: 10px;">
                        <!-- Tombol Kembali juga kita upgrade pakai gaya modern -->
                        <a href="<?= url_to('dashboard') ?>" class="modern-action-btn" style="background: #f1f5f9; color: #64748b;">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        
                        <!-- Ini tombol Edit Anime yang dipindah -->
                        <a href="<?= url_to('edit', $animes['slug']); ?>" class="modern-action-btn btn-edit-modern">
                            <i class="fas fa-pen"></i> Edit Info Anime
                        </a>
                    </div>
                </div>

                    <div class="mb-4">
                        <?php 
                        $genres = explode(',', $animes['genre']); 
                        foreach($genres as $g): ?>
                            <span class="badge badge-soft-primary mr-2 mb-2 p-2 px-3"><?= trim($g) ?></span>
                        <?php endforeach; ?>
                        <span class="badge badge-dark mb-2 p-2 px-3"><?= $animes['typeAnime'] ?></span>
                    </div>

                    <div class="mb-4">
                        <h6 class="font-weight-bold text-uppercase ls-1 text-primary">Sinopsis</h6>
                        <div class="text-description">
                            <?= $animes['Desc'] ?>
                        </div>
                    </div>

                    <div class="row detail-grid py-3 border-top border-bottom mb-4">
                        <!-- Kolom 1: Rating -->
                        <div class="col-6 col-md border-right">
                            <small class="text-muted d-block text-uppercase">Rating User</small>
                            <span class="font-weight-bold">
                                <i class="fas fa-star text-warning"></i> 
                                <?= ($avg_rating > 0) ? number_format($avg_rating, 1) : '0.0' ?>
                            </span>
                            <small class="text-muted" style="font-size: 10px;">(<?= $total_voters ?> votes)</small>
                        </div>

                        <!-- Kolom 2: Total Eps -->
                        <div class="col-6 col-md border-right">
                            <small class="text-muted d-block text-uppercase">Total Eps</small>
                            <span class="font-weight-bold"><?= $animes['Eps'] ?> Episode</span>
                        </div>

                        <!-- Kolom 3: Durasi -->
                        <div class="col-6 col-md border-right">
                            <small class="text-muted d-block text-uppercase">Durasi</small>
                            <span class="font-weight-bold"><?= $animes['Durasi'] ?> Menit</span>
                        </div>

                        <!-- Kolom 4: Rilis -->
                        <div class="col-6 col-md border-right">
                            <small class="text-muted d-block text-uppercase">Rilis</small>
                            <span class="font-weight-bold"><?= format_indo_date($animes['Rilis']); ?></span>
                        </div>
                        <div class="col-6 col-md border-right">
                            <small class="text-muted d-block text-uppercase">MAL Score</small>
                            <span class="font-weight-bold">
                                <i class="fas fa-globe text-info"></i> <?= $animes['mal_score'] ?>
                            </span>
                        </div>

                        <div class="col-6 col-md border-right">
                            <small class="text-muted d-block text-uppercase">Studio</small>
                            <span class="font-weight-bold"><?= esc($animes['all_studios'] ?? 'Unknown') ?></span>
                        </div>

                        <div class="col-6 col-md border-right">
                            <small class="text-muted d-block text-uppercase font-weight-bold">Season</small>
                            <span class="text-primary font-weight-bold text-capitalize">
                                <i class="fas fa-cloud-sun"></i> <?= $animes['season'] ?? 'Unknown' ?> <?= $animes['release_year'] ?>
                            </span>
                        </div>

                        <!-- FIELD BARU: SOURCE -->
                        <div class="col-6 col-md border-right">
                            <small class="text-muted d-block text-uppercase font-weight-bold">Source Material</small>
                            <span class="text-dark font-weight-bold">
                                <i class="fas fa-book"></i> <?= $animes['source'] ?? 'Unknown' ?>
                            </span>
                        </div>

                        <!-- Kolom 5: Status -->
                        <div class="col-6 col-md text-center">
                            <small class="text-muted d-block text-uppercase">Status</small>
                            <span class="badge badge-<?= ($animes['status'] == 'Completed') ? 'success' : 'primary' ?> p-1 px-3">
                                <?= $animes['status'] ?>
                            </span>
                        </div>
                    </div>

                    <div>
                        <h6 class="font-weight-bold text-uppercase ls-1 text-primary">Seri Terkait</h6>
                        <p class="text-muted mb-0"><?= $animes['relatedAnime'] ?? 'Belum ada seri terkait lainnya.' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Bar & Table Section -->
    <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="mb-0 font-weight-bold text-dark">
                <i class="fas fa-list text-primary mr-2"></i> Total Episode : <span class="text-primary"><?= esc($totalEpisode) ?></span>
            </h5>
            <div class="btn-group-custom mt-2 mt-md-0">
                <button type="button" id="deleteAllEpisodesBtn" class="modern-action-btn btn-delete-modern">
                    <i class="fas fa-trash-alt"></i> Kosongkan Episode
                </button>
                <a href="<?= url_to('createEpisode', $animes['slug']); ?>" class="modern-action-btn btn-add-modern">
                    <i class="fas fa-plus"></i> Tambah Episode
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-4">
                <table class="table table-hover border-0" id="dataTable" width="100%">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">Nama Anime</th>
                            <th class="border-0 text-center">Eps</th>
                            <th class="border-0">Deskripsi Episode</th>
                            <th class="border-0">Views</th>
                            <th class="border-0 text-center">Action</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    $(document).ready(function() {
        <?php if (session()->getFlashdata('pesan')) : ?>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            Toast.fire({
                icon: 'success',
                title: '<?= session()->getFlashdata('pesan'); ?>'
            });
        <?php endif; ?>
    });

    $(document).ready(function() {
    var basePath = window.location.origin + '/assets/';
    var slug = "<?= $animes['slug'] ?>";  

    var table = $('#dataTable').DataTable({
        destroy: true, // <--- Kunci penghilang alert error
        ajax: {
            url: '/dashboard/detail/' + slug,
            dataSrc: ''
        },
        columns: [
            // Kolom 1: Menampilkan Gambar Cover
            { data: 'GambarPreview' , render: function(data, type, row) {
                let imgSrc = data ? (basePath + 'imgPreview/' + data) : (basePath + 'images/default3.jpg');
                return `<img src="${imgSrc}" alt="Preview">`;
            }},
            
            // Kolom 2: Nomor Episode
            { data: 'episode_number', render: function(data, type, row) {
                return `<span class="btn btn-dark">Eps ${data}</span>`;
            }},
            
            // Kolom 3: Deskripsi
            { data: 'deskripsi', render: function(data, type, row) {
                let descText = data ? data : `<em class="text-muted">Tidak ada deskripsi.</em>`;
                return `<span class="desc">${descText}</span>`;
            }},
            
            // Kolom 4: Views
            { data: 'view_count', render: function(data, type, row) { 
                return `<span class="d-flex align-items-center" style="font-size:0.85rem; color:#64748b; font-weight:700;">
                            <i class="fas fa-eye text-primary mr-2" style="font-size:1rem;"></i> ${data}
                        </span>`; 
            }},
            
            // Kolom 5: Action Buttons
            { data: null, render: function(data, type, row) {
                return `<div class="ep-action-buttons">
                            <button type="button" class="btn btn-warning text-white edit-episode" data-id="${row.id}" data-title="${row.judul}" data-desc="${row.deskripsi}" data-episode="${row.episode_number}" data-gambar="${basePath}imgPreview/${row.GambarPreview}" data-video="${row.video_path ? basePath + 'videos/' + row.video_path : ''}" title="Edit Episode">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger delete-episode" data-id="${row.id}" title="Hapus Episode">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>`; 
            }}
        ],
        dom: '<"top"iBfl>rt<"bottom"p><"clear">',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ entri per halaman",
            info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
            paginate: {
                first: "<i class='fas fa-chevron-left'></i> FIRST",
                previous: "<i class='fas fa-angle-left'></i>",
                next: "NEXT <i class='fas fa-angle-right'></i>",
                last: "LAST <i class='fas fa-chevron-right'></i>"
            },
            emptyTable: "Belum ada Episode pada Anime ini"
        }
    });

    // 2. KODE ANIMASI TAMBAHAN (Menggunakan variabel 'table' dari atas)
    table.on('draw.dt', function () {
        $('#dataTable tbody tr').each(function(index) {
            $(this).removeClass('card-animated');
            $(this).css('animation-delay', (index * 0.08) + 's');
            
            var card = $(this);
            setTimeout(function() {
                card.addClass('card-animated');
            }, 10);
        });
    });

    

    $(document).on('click', '.delete-episode', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak dapat mengembalikan data pada Episode ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/dashboard/HapusEpisode/' + id,
                    type: 'GET',
                    success: function(response) {
                        Swal.fire(
                            'Terhapus!',
                            'Episode telah dihapus.',
                            'success'
                        ).then(() => {
                            $('#dataTable').DataTable().ajax.reload();
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus episode.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    document.getElementById('deleteAllEpisodesBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Semua episode akan dihapus dan tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus semua!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Ajax request untuk hapus semua episode
                $.ajax({
                    url: "<?= url_to('deleteAllEpisodes', $animes['id']) ?>", // URL route alias
                    type: 'DELETE',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Terhapus!',
                                response.message || 'Semua episode telah berhasil dihapus.',
                                'success'
                            ).then(() => {
                                location.reload(); // Reload halaman setelah sukses menghapus
                            });
                        } else if (response.status === 'error') {
                            Swal.fire(
                                'Tidak ada episode!',
                                response.message || 'Tidak ada episode yang dapat dihapus pada judul anime ini.',
                                'warning'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan pada server.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $(document).on('click', '.edit-episode', function() {
        const id = $(this).data('id');
        const title = $(this).data('title');
        const desc = $(this).data('desc');
        const episodeNumber = $(this).data('episode');
        const gambar = $(this).data('gambar');
        const video = $(this).data('video');

        Swal.fire({
            title: null, 
            customClass: {
                popup: 'swal-edit-modal'
            },
            
            // 1. UBAH UKURAN LEBAR DI SINI (Gunakan % agar responsif mengikuti layar monitor)
            width: '75%', 

            // 2. KUNCI POP-UP (Mencegah pop-up tertutup jika klik di luar atau pencet tombol ESC di keyboard)
            allowOutsideClick: false,
            allowEscapeKey: false, 

            showConfirmButton: false,
            showCancelButton: false,
            html: `
                <!-- HEADER MIRIP HALAMAN TAMBAH -->
                <div class="anime-card-header d-flex justify-content-between align-items-center flex-wrap" style="background: #ffffff; padding: 25px 30px; border-bottom: 1px solid #f0f0f0;">
                    <h4 class="m-0 font-weight-bold d-flex align-items-center" style="color: #32325d;">
                        <i class="fas fa-edit mr-3" style="color: #5e72e4;"></i> 
                        <div>
                            <span class="d-block" style="font-size: 1.2rem; text-align: left;">Edit Episode ${episodeNumber}</span>
                            <small class="d-block mt-1" style="font-size: 0.85rem; font-weight: 500; color: #8898aa; text-align: left;">
                                Lakukan perubahan data pada episode ini.
                            </small>
                        </div>
                    </h4>
                    <button type="button" class="close" onclick="Swal.close()" style="font-size: 1.5rem;">&times;</button>
                </div>

                <!-- BODY FORM MIRIP HALAMAN TAMBAH -->
                <div class="swal-edit-wrapper">
                    <form id="editEpisodeForm" action="<?= url_to('updateEpisode'); ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id" value="${id}">
                        <input type="hidden" name="old_video_path" value="${video}">
                        
                        <div class="row">
                            <!-- KOLOM KIRI: DATA TEKS -->
                            <div class="col-lg-6 pr-lg-4 border-right">
                                <span class="form-section-title">Informasi Episode</span>

                                <div class="form-group custom-group">
                                    <label>Judul Episode</label>
                                    <input type="text" name="judul" class="form-control custom-input-style" value="${title}" required>
                                </div>

                                <div class="form-group custom-group">
                                    <label>Episode Ke-Berapa? <span class="text-danger">*</span></label>
                                    <input type="number" name="episodeNumber" class="form-control custom-input-style" value="${episodeNumber}" required>
                                </div>

                                <div class="form-group custom-group">
                                    <label>Deskripsi Ringkas</label>
                                    <textarea name="Deskripsi" class="form-control custom-input-style" rows="5" required>${desc}</textarea>
                                </div>
                            </div>
                            
                            <!-- KOLOM KANAN: MEDIA -->
                            <div class="col-lg-6 pl-lg-4 mt-4 mt-lg-0">
                                <span class="form-section-title">Media Preview</span>

                                <!-- Box Upload Gambar -->
                                <div class="upload-box p-3 mb-4 text-left">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <label class="font-weight-bold m-0 text-dark" style="font-size: 14px;">
                                            <i class="fas fa-image mr-1" style="color: #5e72e4;"></i> Gambar Preview
                                        </label>
                                        <span class="badge badge-light" style="color: #8898aa;"><i class="fas fa-file-image"></i> JPG/PNG</span>
                                    </div>
                                    
                                    <div class="custom-file text-left mb-3">
                                        <input type="file" name="gambarPreview" id="gambarPreview" class="custom-file-input" accept="image/jpeg, image/png, image/webp" onchange="GambarPreview()">
                                        <label class="custom-file-label" for="gambarPreview" id="labelGambarPreview" style="border-radius: 8px;">Pilih gambar manual...</label>
                                    </div>                                    
                                    <img src="${gambar}" class="img-preview-episode mt-3" id="img-preview-episode" style="width: 100%; border-radius: 12px; border: 1px solid rgba(0,0,0,0.1); object-fit: cover; aspect-ratio: 16/9;">
                                </div>

                                <!-- Box Upload Video -->
                                <div class="upload-box p-3 text-left">
                                    <label class="font-weight-bold m-0 text-dark d-block mb-2" style="font-size: 14px;">
                                        <i class="fas fa-video mr-1" style="color: #5e72e4;"></i> Video Episode
                                    </label>
                                    
                                    <div id="drop-zone" class="drop-zone ${video ? 'hide' : ''}" style="background: #ffffff; border-radius: 10px; border: 1px dashed #dee2e6;">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Tarik Video Ke Sini atau Klik</span><br>
                                        <small class="text-muted">(Abaikan jika tidak ingin mengganti video)</small>
                                    </div>
                                    <input type="file" name="video_path" id="video_path" accept="video/*" style="display: none;" onchange="displayFileDetails()">
                                    
                                    <!-- Progress Bar Lokal (Bawaan Anda sebelumnya) -->
                                    <div id="loading-bar" style="display: none; margin-top: 10px;">
                                        <progress id="progress-bar" class="custom-progress" value="0" max="100" style="width: 100%;"></progress>
                                    </div>

                                    <!-- Preview Video Lama/Baru -->
                                    <div id="video-container" class="mt-3 position-relative bg-dark rounded-lg overflow-hidden shadow-sm" style="display: ${video ? 'block' : 'none'}; border: 1px solid rgba(255,255,255,0.1);">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute" onclick="removeVideo()" style="top: 10px; right: 10px; z-index: 10; border-radius: 50%; width: 30px; height: 30px; padding: 0;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <video id="video-preview" width="100%" height="auto" controls style="display: ${video ? 'block' : 'none'}; max-height: 250px;">
                                            <source id="video-source" src="${video}" type="video/mp4">
                                        </video>
                                    </div>
                                </div>

                                <!-- Tombol Aksi di dalam Form Kanan -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-save shadow-sm">
                                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                    </button>
                                    <button type="button" class="btn btn-cancel" onclick="Swal.close()">
                                        Batal & Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            `,
            didOpen: () => {
                const dropZone = document.getElementById('drop-zone');
                const fileInput = document.getElementById('video_path');
                if (!video) {
                    dropZone.classList.remove('hide');
                }
                dropZone.addEventListener('click', () => fileInput.click());
                dropZone.addEventListener('dragover', (event) => {
                    event.preventDefault();
                    dropZone.style.borderColor = '#5e72e4';
                    dropZone.style.background = '#f0f2ff';
                });
                dropZone.addEventListener('dragleave', () => {
                    dropZone.style.borderColor = '#dee2e6';
                    dropZone.style.background = '#ffffff';
                });
                dropZone.addEventListener('drop', (event) => {
                    event.preventDefault();
                    dropZone.style.borderColor = '#dee2e6';
                    dropZone.style.background = '#ffffff';
                    fileInput.files = event.dataTransfer.files;
                    displayFileDetails();
                });
            }
        });

        $(document).on('submit', '#editEpisodeForm', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Mengunggah...',
            text: 'Silakan tunggu beberapa saat video sedang diunggah.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const formData = new FormData(this);

        formData.forEach((value, key) => {
            console.log(key + ": " + value);
        });

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.close();
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Episode berhasil diupdate.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            },
            error: function() {
                Swal.close();
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mengupdate episode.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});

    function GambarPreview() {
        const GambarPreview = document.querySelector('#gambarPreview');
        const GambarPreviewLabel = document.querySelector('#gambarPreview').nextElementSibling;
        const GambarPreviewPreview = document.querySelector('#img-preview-episode');

        GambarPreviewLabel.textContent = GambarPreview.files[0].name;

        const fileGambarPreview = new FileReader();
        fileGambarPreview.readAsDataURL(GambarPreview.files[0]);

        fileGambarPreview.onload = function(e) {
            GambarPreviewPreview.src = e.target.result;
        }
    }

    function displayFileDetails() {
        const fileInput = document.getElementById('video_path');
        const videoContainer = document.getElementById('video-container');
        const videoPreview = document.getElementById('video-preview');
        const videoSource = document.getElementById('video-source');
        const dropZone = document.getElementById('drop-zone');
        const loadingBar = document.getElementById('loading-bar');
        const progressBar = document.getElementById('progress-bar');

        const file = fileInput.files[0];

        if (file) {
            // Hide drop zone
            dropZone.classList.add('hide');
            
            // Show loading bar
            loadingBar.style.display = 'block';
            videoPreview.style.display = 'none';

            const reader = new FileReader();

            reader.onloadstart = () => {
                progressBar.value = 0;
            };

            reader.onprogress = (e) => {
                if (e.lengthComputable) {
                    const percentLoaded = Math.round((e.loaded / e.total) * 100);
                    progressBar.value = percentLoaded;
                }
            };

            reader.onload = () => {
                // Hide loading bar
                loadingBar.style.display = 'none';

                // Update video source and type
                videoSource.src = reader.result;
                videoSource.type = file.type;
                videoPreview.load();
                videoPreview.style.display = 'block';
                videoContainer.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    }

    function removeVideo() {
                const videoPreview = document.getElementById('video-preview');
                const videoSource = document.getElementById('video-source');
                const fileInput = document.getElementById('video_path');
                const loadingBar = document.getElementById('loading-bar');

                videoSource.src = '';  // Remove the video source
                videoPreview.style.display = 'none';  // Hide the video preview
                loadingBar.style.display = 'none';  // Hide the loading bar
            }
    });
</script>

















<?= $this->endSection() ?>