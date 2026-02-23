<!DOCTYPE html>
<html>
<head>
    <title>SK - {{ $bap->nama_pemohon }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; line-height: 1.6; font-size: 12pt; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .judul { text-align: center; font-weight: bold; text-transform: uppercase; margin: 30px 0; }
        .isi { text-align: justify; margin-bottom: 20px; }
        .ttd { float: right; width: 40%; text-align: center; margin-top: 50px; }
        table { width: 100%; margin-top: 10px; margin-bottom: 10px; }
        td { vertical-align: top; }
    </style>
</head>
<body>
    <div class="kop">
        <h3 style="margin:0">KEMENTERIAN HUKUM DAN HAM RI</h3>
        <h2 style="margin:0">KANTOR IMIGRASI KELAS I TPI CONTOH</h2>
        <small>Jl. Jend. Sudirman No. 123, Jakarta Selatan</small>
    </div>

    <div class="judul">
        SURAT KEPUTUSAN KEPALA KANTOR IMIGRASI<br>
        NOMOR: W.10-IMI.SK.{{ $bap->kode_booking }}.{{ date('Y') }}
    </div>

    <div class="isi">
        <p style="text-align: center; font-weight: bold;">TENTANG<br>PENGGANTIAN DOKUMEN PERJALANAN REPUBLIK INDONESIA</p>
        
        <p>Kepala Kantor Imigrasi Kelas I TPI Contoh,</p>

        <p><strong>MENIMBANG:</strong><br>
        Bahwa berdasarkan hasil pemeriksaan (BAP) dan pendapat (BAPEN) terhadap permohonan yang diajukan, dipandang perlu untuk menerbitkan keputusan ini.</p>
        
        <p><strong>MENGINGAT:</strong><br>
        1. Undang-Undang Nomor 6 Tahun 2011 tentang Keimigrasian;<br>
        2. Peraturan Pemerintah Nomor 31 Tahun 2013 tentang Peraturan Pelaksanaan UU Keimigrasian.</p>

        <p style="text-align: center; font-weight: bold; margin-top: 20px;">MEMUTUSKAN</p>

        <p><strong>MENETAPKAN:</strong><br>
        Memberikan persetujuan penggantian paspor kepada:</p>
        
        <table style="margin-left: 20px;">
            <tr><td width="150">Nama Lengkap</td><td>: <strong>{{ $bap->nama_pemohon }}</strong></td></tr>
            <tr><td>Kode Booking</td><td>: {{ $bap->kode_booking }}</td></tr>
            <tr><td>Kategori</td><td>: {{ ucwords(str_replace('_', ' ', $bap->kategori)) }}</td></tr>
        </table>

        <p>Keputusan ini mulai berlaku sejak tanggal ditetapkan dengan ketentuan apabila dikemudian hari terdapat kekeliruan akan diadakan perbaikan sebagaimana mestinya.</p>
    </div>

    <div class="ttd">
        <p>Ditetapkan di: Jakarta</p>
        <p>Pada Tanggal: {{ date('d F Y') }}</p>
        <br>
        <p>Kepala Kantor,</p>
        
        <div style="margin: 10px auto;">
            <img src="{{ public_path('img/ttd_kakan.png') }}" style="height: 80px; width: auto;" alt="Tanda Tangan">
        </div>
        
        <p style="text-decoration: underline; font-weight: bold;">(NAMA KAKAN)</p>
        <p>NIP. 19750505 199903 1 005</p>
    </div>
</body>
</html>