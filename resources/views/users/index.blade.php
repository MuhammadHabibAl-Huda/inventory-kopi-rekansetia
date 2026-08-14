@extends('layouts.app')

@section('page_title', 'Manajemen User')
@section('page_subtitle', 'Kelola akun admin dan barista yang memiliki akses ke sistem')

@section('content')

{{-- TOMBOL TAMBAH USER --}}
<div style="margin-bottom: 20px; display: flex; justify-content: flex-end;">
    <button type="button" onclick="document.getElementById('modalTambahUser').style.display='flex'" style="display: inline-flex; align-items: center; gap: 8px; padding: 9px 16px; background: linear-gradient(135deg, #b45309, #d97706); color: #fff; font-size: 13px; font-weight: 600; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        Tambah Akun Baru
    </button>
</div>

{{-- TABEL USER --}}
<div class="data-card">
    <div class="data-card-header">
        <h3>
            <span class="header-icon amber">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </span>
            Daftar Pengguna Sistem
        </h3>
        <span style="font-size: 13px; color: #94a3b8; font-weight: 500;">{{ $users->count() }} akun terdaftar</span>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th style="text-align:center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $i => $user)
            <tr>
                <td class="cell-bold">{{ $i + 1 }}</td>
                <td class="cell-bold">
                    {{ $user->name }}
                    @if($user->id === Auth::id())
                    <span style="font-size: 11px; font-weight: 600; color: #b45309; margin-left: 6px;">(Anda)</span>
                    @endif
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->role === 'admin')
                        <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:600; padding:3px 10px; border-radius:20px; background:rgba(251,191,36,0.15); color:#b45309; text-transform:uppercase;">Admin</span>
                    @else
                        <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:600; padding:3px 10px; border-radius:20px; background:rgba(96,165,250,0.15); color:#2563eb; text-transform:uppercase;">Barista</span>
                    @endif
                </td>
                <td style="text-align:center">
                    <div style="display:inline-flex; align-items:center; gap:8px;">
                        {{-- Tombol Edit hanya untuk akun barista --}}
                        @if($user->role === 'barista')
                        <button type="button"
                            onclick="bukaModalEdit({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')"
                            style="color:#2563eb; background:none; border:none; cursor:pointer; font-size:12px; font-weight:600; display:inline-flex; align-items:center; gap:4px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit
                        </button>
                        @endif

                        {{-- Tombol Hapus (tidak bisa hapus diri sendiri & tidak bisa hapus admin) --}}
                        @if($user->id !== Auth::id() && $user->role !== 'admin')
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                              onsubmit="return confirm('Hapus akun &quot;{{ $user->name }}&quot;?\n\nAkun ini tidak akan bisa login lagi.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color:#ef4444; background:none; border:none; cursor:pointer; font-size:12px; font-weight:600;">Hapus</button>
                        </form>
                        @else
                        <span style="color:#94a3b8; font-size:12px;">—</span>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- MODAL TAMBAH AKUN --}}
<div id="modalTambahUser" style="display:none; position:fixed; inset:0; z-index:999; align-items:center; justify-content:center; background:rgba(15,23,42,0.5); backdrop-filter:blur(4px);">
    <div style="background:#fff; border-radius:12px; width:100%; max-width:460px; margin:16px; box-shadow:0 20px 40px rgba(0,0,0,0.18); overflow:hidden;">
        <div style="background:#1e293b; color:#fff; padding:18px 24px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
                <span style="width:30px; height:30px; background:rgba(217,119,6,0.25); border-radius:7px; display:flex; align-items:center; justify-content:center;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </span>
                <h5 style="font-size:15px; font-weight:600; margin:0;">Tambah Akun Baru</h5>
            </div>
            <button type="button" onclick="document.getElementById('modalTambahUser').style.display='none'" style="background:rgba(255,255,255,0.1); border:none; color:#fff; width:28px; height:28px; border-radius:6px; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;">&times;</button>
        </div>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div style="padding:24px;">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-input" placeholder="Contoh: Budi Santoso" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email <span class="form-label-sub">— digunakan untuk login</span></label>
                    <input type="email" name="email" class="form-input" placeholder="Contoh: budi@kedaikopi.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="barista">Barista</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Password <span class="form-label-sub">— minimal 6 karakter</span></label>
                    <input type="password" name="password" class="form-input" placeholder="Password" required>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password" required>
                </div>
            </div>
            <div style="padding:14px 24px; background:#f8fafc; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="document.getElementById('modalTambahUser').style.display='none'" style="padding:9px 18px; background:#fff; border:1.5px solid #e2e8f0; border-radius:7px; font-size:13px; font-weight:600; color:#475569; cursor:pointer;">Batal</button>
                <button type="submit" class="btn-primary" style="width:auto; padding:9px 20px; font-size:13px;">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT AKUN --}}
<div id="modalEditUser" style="display:none; position:fixed; inset:0; z-index:999; align-items:center; justify-content:center; background:rgba(15,23,42,0.5); backdrop-filter:blur(4px);">
    <div style="background:#fff; border-radius:12px; width:100%; max-width:460px; margin:16px; box-shadow:0 20px 40px rgba(0,0,0,0.18); overflow:hidden;">
        <div style="background:#1e293b; color:#fff; padding:18px 24px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
                <span style="width:30px; height:30px; background:rgba(37,99,235,0.25); border-radius:7px; display:flex; align-items:center; justify-content:center;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </span>
                <h5 style="font-size:15px; font-weight:600; margin:0;">Edit Akun</h5>
            </div>
            <button type="button" onclick="tutupModalEdit()" style="background:rgba(255,255,255,0.1); border:none; color:#fff; width:28px; height:28px; border-radius:6px; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;">&times;</button>
        </div>
        <form id="formEditUser" method="POST">
            @csrf
            @method('PUT')
            <div style="padding:24px;">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" id="editNama" name="name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email <span class="form-label-sub">— digunakan untuk login</span></label>
                    <input type="email" id="editEmail" name="email" class="form-input" required>
                </div>
                <div style="border-top:1px dashed #e2e8f0; margin:4px 0 16px; padding-top:16px;">
                    <p style="font-size:12px; color:#94a3b8; margin:0 0 12px;">Kosongkan kolom password jika tidak ingin mengubahnya.</p>
                    <div class="form-group">
                        <label class="form-label">Password Baru <span class="form-label-sub">— opsional</span></label>
                        <input type="password" name="password" class="form-input" placeholder="Isi jika ingin ubah password">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>
            <div style="padding:14px 24px; background:#f8fafc; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="tutupModalEdit()" style="padding:9px 18px; background:#fff; border:1.5px solid #e2e8f0; border-radius:7px; font-size:13px; font-weight:600; color:#475569; cursor:pointer;">Batal</button>
                <button type="submit" style="padding:9px 20px; background:linear-gradient(135deg,#1d4ed8,#2563eb); color:#fff; border:none; border-radius:7px; font-size:13px; font-weight:600; cursor:pointer;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Tutup modal jika klik area luar
    document.getElementById('modalTambahUser').addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });

    document.getElementById('modalEditUser').addEventListener('click', function(e) {
        if (e.target === this) tutupModalEdit();
    });

    function bukaModalEdit(id, nama, email) {
        // Set action form sesuai ID user
        document.getElementById('formEditUser').action = '/users/' + id;

        // Isi field dengan data user yang ada
        document.getElementById('editNama').value  = nama;
        document.getElementById('editEmail').value = email;

        // Kosongkan field password
        document.querySelectorAll('#formEditUser input[type="password"]').forEach(function(el) {
            el.value = '';
        });

        document.getElementById('modalEditUser').style.display = 'flex';
    }

    function tutupModalEdit() {
        document.getElementById('modalEditUser').style.display = 'none';
    }
</script>
@endpush
