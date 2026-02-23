<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Berita Acara Pemeriksaan</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; font-size: 11.5pt; line-height: 1.5; margin: 0 1cm; }
        
        /* Pengaturan Layout Header dengan Logo di kiri */
        .kop-header { position: relative; border-bottom: 3px solid black; margin-bottom: 15px; padding-bottom: 5px; min-height: 100px; }
        .logo-imigrasi { position: absolute; left: 0; top: 0; width: 85px; height: auto; }
        .teks-kop { text-align: center; margin-left: 90px; }
        
        .teks-kop h3, .teks-kop h4, .teks-kop p { margin: 0; }
        .teks-kop h3 { font-size: 14pt; }
        .teks-kop h4 { font-size: 12pt; }
        .teks-kop p { font-size: 10pt; }
        
        .title { text-align: center; font-weight: bold; margin-bottom: 20px; }
        .title span.judul { text-decoration: underline; font-size: 12pt; }
        .title span.nomor { font-weight: normal; font-size: 11pt; display: block; margin-top: 3px; }
        .title span.keterangan { font-weight: normal; font-size: 11pt; display: block; margin-top: 3px; }
        
        .content { text-align: justify; }
        .indent { padding-left: 20px; }
        
        /* Merapikan tabel tanya jawab agar ada jarak antar soal */
        table.qna { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.qna td { vertical-align: top; padding-bottom: 8px; }
        
        /* Tanda Tangan Pemohon */
        table.ttd-pemohon { width: 100%; margin-top: 30px; text-align: center; border-collapse: collapse; }
        table.ttd-pemohon td { width: 50%; padding-top: 20px; }
        
        /* Tanda Tangan Petugas (Atas Bawah di Kanan) */
        table.ttd-petugas { width: 100%; margin-top: 30px; border-collapse: collapse; }
        table.ttd-petugas td.kosong { width: 55%; } /* Sisi kiri dikosongkan agar terdorong ke kanan */
        table.ttd-petugas td.isi { width: 45%; text-align: left; vertical-align: top; }
        
        /* CLASS BARU UNTUK MEMAKSA PINDAH HALAMAN */
        .page-break { page-break-before: always; clear: both; }
    </style>
</head>
<body>

    @php
        // Helper Terbilang Tanggal & Bulan
        $formatter = new NumberFormatter('id', NumberFormatter::SPELLOUT);
        $hari = \Carbon\Carbon::now()->translatedFormat('l');
        $tgl_angka = \Carbon\Carbon::now()->format('d');
        $tgl_huruf = ucwords($formatter->format($tgl_angka));
        $bulan = \Carbon\Carbon::now()->translatedFormat('F');
        $tahun_angka = \Carbon\Carbon::now()->format('Y');
        $tahun_huruf = ucwords($formatter->format($tahun_angka));
    @endphp

    <div class="kop-header">
        <img src="{{ public_path('images/logo-imigrasi.png') }}" class="logo-imigrasi">
        
        <div class="teks-kop">
            <h3>KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN REPUBLIK INDONESIA</h3>
            <h4>DIREKTORAT JENDERAL IMIGRASI</h4>
            <h4>KANTOR WILAYAH JAWA TENGAH</h4>
            <h3 style="font-weight: bold;">KANTOR IMIGRASI KELAS II NON TPI WONOSOBO</h3>
            <p>Jalan Raya Banyumas Km 5,5 Selomerto Wonosobo 56361<br>
            Telepon: (0286) 321628, Faksimili: (0286) 325587<br>
            Laman: wonosobo.imigrasi.go.id Pos-el: kanim.wonosobo@imigrasi.go.id</p>
        </div>
    </div>

    <div class="title">
        <span class="judul">BERITA ACARA PEMERIKSAAN</span>
        <span class="nomor">Nomor: {{ $bap->nomor_surat_bap ?: 'WIM.13.IMI.7.GR.03.01-___________________' }}</span>
        <span class="keterangan">({{ $bap->keterangan_bap }})</span>
    </div>

    <div class="content">
        <p>Pada hari ini <strong>{{ $hari }}</strong> tanggal <strong>{{ $tgl_huruf }}</strong> bulan <strong>{{ $bulan }}</strong> tahun <strong>{{ $tahun_huruf }}</strong>, saya:</p>
        
        <p style="text-align: center; font-weight: bold;">{{ strtoupper($bap->nama_kasubsi) }}</p>
        <p>Pangkat/Golongan Penata Muda (III/a), NIP. {{ $bap->nip_kasubsi }}, Jabatan: Kepala Sub Seksi Penindakan Keimigrasian pada Kantor Imigrasi Kelas II Non TPI Wonosobo bersama-sama dengan:</p>
        
        <p style="text-align: center; font-weight: bold;">{{ strtoupper($bap->nama_petugas) }}</p>
        <p>Pangkat/golongan {{ $bap->pangkat_petugas }}, NIP. {{ $bap->nip_petugas }}, Jabatan: {{ $bap->jabatan_petugas }} pada Seksi Intelijen dan Penindakan Keimigrasian Kantor Imigrasi Kelas II Non TPI Wonosobo telah melakukan pemeriksaan terhadap seorang Warga Negara Indonesia yang tidak saya kenal untuk didengar keterangannya, mengaku bernama:</p>

        <p style="text-align: center; font-weight: bold; text-decoration: underline;">{{ strtoupper($bap->nama_pemohon) }}</p>
        
        <p>Tempat/tanggal lahir: {{ $bap->tempat_lahir }}, {{ \Carbon\Carbon::parse($bap->tgl_lahir)->format('d-m-Y') }}, Pendidikan terakhir: {{ $bap->pendidikan }}, Pekerjaan : {{ $bap->pekerjaan }}, Agama: {{ $bap->agama }}, Alamat: {{ $bap->alamat_lengkap }};</p>

        <p>Sesuai data yang ada bahwa yang bersangkutan adalah pemegang dokumen berupa KTP Elektronik NIK {{ $bap->nik_ktp }} yang dikeluarkan Kantor Disdukcapil tanggal {{ \Carbon\Carbon::parse($bap->tgl_keluar_ktp)->format('d-m-Y') }}, Kartu Keluarga Nomor {{ $bap->no_kk }} yang dikeluarkan Kantor Disdukcapil tanggal {{ \Carbon\Carbon::parse($bap->tgl_keluar_kk)->format('d-m-Y') }}, dan Kutipan Akta/Dokumen Nomor: {{ $bap->no_akta }} yang dikeluarkan Disdukcapil tanggal {{ \Carbon\Carbon::parse($bap->tgl_keluar_akta)->format('d-m-Y') }};</p>

        <p>Yang bersangkutan diperiksa dan didengar keterangannya sehubungan dengan {{ $bap->alasan_pemeriksaan }};</p>
        
        <p>Atas pertanyaan Pemeriksa, yang diperiksa memberikan keterangan dan jawaban sebagai berikut:</p>

        <table class="qna">
            @if($bap->pertanyaan_tambahan)
                @foreach(json_decode($bap->pertanyaan_tambahan, true) as $index => $qna)
                <tr>
                    <td style="width: 25px;">{{ $index + 1 }}.</td>
                    <td>{{ $qna['tanya'] }}<br><strong>Jawab:</strong> {{ $qna['jawab'] }}</td>
                </tr>
                @endforeach
            @endif
        </table>

        <p style="margin-top: 20px;">Setelah berita acara pemeriksaan ini selesai dibuat kemudian dibacakan kepada yang diperiksa dengan bahasa yang mudah dimengerti, yang diperiksa menyatakan setuju dan membenarkan semua keterangan dan jawaban yang telah diberikan tersebut diatas maka untuk menguatkan yang bersangkutan membubuhkan tanda tangan di bawah ini.</p>

        <table class="ttd-pemohon">
            <tr>
                <td></td>
                <td>
                    Yang Diperiksa,<br><br><br><br><br>
                    <strong style="text-decoration: underline;">{{ strtoupper($bap->nama_pemohon) }}</strong>
                </td>
            </tr>
        </table>

        <div class="page-break"></div>
        
        <p style="margin-top: 0px;">Demikian Berita Acara Pemeriksaan ini selesai dibuat dengan sebenarnya atas kekuatan sumpah jabatan kemudian ditutup dan ditandatangani di Kantor Imigrasi Kelas II Non TPI Wonosobo pada hari, tanggal, bulan, dan tahun tersebut di atas.</p>

        <table class="ttd-petugas">
            <tr>
                <td class="kosong"></td> <td class="isi">
                    <p style="margin: 0; margin-bottom: 70px;">Pemeriksa,</p>
                    <p style="margin: 0; line-height: 1.2;">
                        <strong style="text-decoration: underline;">{{ strtoupper($bap->nama_petugas) }}</strong><br>
                        NIP. {{ $bap->nip_petugas }}
                    </p>

                    <br><br><br>

                    <p style="margin: 0; line-height: 1.2; margin-bottom: 70px;">
                        Kepala Sub Seksi<br>
                        Penindakan<br>
                        Keimigrasian,
                    </p>
                    <p style="margin: 0; line-height: 1.2;">
                        <strong style="text-decoration: underline;">{{ strtoupper($bap->nama_kasubsi) }}</strong><br>
                        NIP. {{ $bap->nip_kasubsi }}
                    </p>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>