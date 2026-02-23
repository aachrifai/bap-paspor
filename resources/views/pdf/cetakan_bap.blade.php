<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Berita Acara Klarifikasi</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; font-size: 11.5pt; line-height: 1.5; margin: 0 1cm; }
        .kop-surat { text-align: center; border-bottom: 3px solid black; margin-bottom: 15px; padding-bottom: 5px; }
        .kop-surat h3, .kop-surat h4, .kop-surat p { margin: 0; }
        .kop-surat h3 { font-size: 14pt; }
        .kop-surat h4 { font-size: 12pt; }
        .kop-surat p { font-size: 10pt; }
        .title { text-align: center; font-weight: bold; margin-bottom: 20px; }
        .title span.judul { text-decoration: underline; }
        .title span.nomor { font-weight: normal; font-size: 11pt; display: block; margin-top: 5px; }
        .content { text-align: justify; }
        .indent { padding-left: 20px; }
        
        /* Merapikan tabel tanya jawab agar ada jarak antar soal */
        table.qna { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.qna td { vertical-align: top; padding-bottom: 8px; }
        
        table.ttd-box { width: 100%; margin-top: 30px; text-align: center; border-collapse: collapse; }
        table.ttd-box td { width: 50%; padding-top: 20px; }
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

    <div class="kop-surat">
        <h3>KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN REPUBLIK INDONESIA</h3>
        <h4>DIREKTORAT JENDERAL IMIGRASI</h4>
        <h4>KANTOR WILAYAH JAWA TENGAH</h4>
        <h3 style="font-weight: bold;">KANTOR IMIGRASI KELAS II NON TPI WONOSOBO</h3>
        <p>Jalan Raya Banyumas Km 5,5 Selomerto Wonosobo 56361<br>
        Telepon: (0286) 321628, Faksimili: (0286) 325587<br>
        Laman: https://kanimwonosobo.kemenkumham.go.id Pos-el: kanim.wonosobo@kemenkumham.go.id</p>
    </div>

    <div class="title">
        <span class="judul">BERITA ACARA KLARIFIKASI</span>
        <span class="nomor">Nomor: WIM.13.IMI.6-GR.03.01-___________________</span>
    </div>

    <div class="content">
        <p>Pada hari <strong>{{ $hari }}</strong> tanggal <strong>{{ $tgl_huruf }}</strong> bulan <strong>{{ $bulan }}</strong> tahun <strong>{{ $tahun_huruf }}</strong>, saya:</p>
        
        <p style="text-align: center; font-weight: bold;">{{ strtoupper($bap->nama_kasubsi) }}</p>
        <p>Pangkat/Golongan Penata Muda (III/a), NIP. {{ $bap->nip_kasubsi }}, Jabatan: Kepala Sub Seksi Penindakan Keimigrasian pada Kantor Imigrasi Kelas II Non TPI Wonosobo bersama-sama dengan:</p>
        
        <p style="text-align: center; font-weight: bold;">{{ strtoupper($bap->nama_petugas) }}</p>
        <p>Pangkat/golongan Penata Muda Tk. I (III/b), NIP. {{ $bap->nip_petugas }}, Jabatan: Analis Keimigrasian Pertama pada Seksi Intelijen dan Penindakan Keimigrasian Kantor Imigrasi Kelas II Non TPI Wonosobo telah melakukan klarifikasi terhadap seorang Warga Negara Indonesia yang tidak saya kenal untuk didengar keterangannya, mengaku bernama:</p>

        <p style="text-align: center; font-weight: bold; text-decoration: underline;">{{ strtoupper($bap->nama_pemohon) }}</p>
        
        <p>Tempat/tanggal lahir: {{ $bap->tempat_lahir }}, {{ \Carbon\Carbon::parse($bap->tgl_lahir)->format('d-m-Y') }}, Pendidikan terakhir: {{ $bap->pendidikan }}, Pekerjaan : {{ $bap->pekerjaan }}, Agama {{ $bap->agama }}, Alamat: {{ $bap->alamat_lengkap }};</p>

        <p>Sesuai data yang ada bahwa yang bersangkutan adalah pemegang dokumen berupa KTP Elektronik NIK {{ $bap->nik_ktp }} yang dikeluarkan Kantor Disdukcapil tanggal {{ \Carbon\Carbon::parse($bap->tgl_keluar_ktp)->format('d-m-Y') }}, Kartu Keluarga Nomor {{ $bap->no_kk }} yang dikeluarkan Kantor Disdukcapil tanggal {{ \Carbon\Carbon::parse($bap->tgl_keluar_kk)->format('d-m-Y') }}, dan Kutipan Akta/Dokumen Nomor: {{ $bap->no_akta }} yang dikeluarkan Disdukcapil tanggal {{ \Carbon\Carbon::parse($bap->tgl_keluar_akta)->format('d-m-Y') }};</p>

        <p>Yang bersangkutan didengar keterangannya menindaklanjuti Nota Dinas Kepala Seksi Dokumen Perjalanan dan Izin Tinggal Keimigrasian perihal Pemeriksaan Permohonan Paspor RI An. <strong>{{ strtoupper($bap->nama_pemohon) }}</strong>;</p>
        
        <p>Atas pertanyaan Pemeriksa, yang bersangkutan memberikan keterangan dan jawaban sebagai berikut:</p>

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

        <p style="margin-top: 20px;">Setelah berita acara klarifikasi ini selesai dibuat kemudian dibacakan kepada yang bersangkutan dengan bahasa yang mudah dimengerti, yang bersangkutan menyatakan setuju dan membenarkan semua keterangan dan jawaban yang telah diberikan tersebut diatas maka untuk menguatkan yang bersangkutan membubuhkan tanda tangan di bawah ini.</p>

        <table class="ttd-box">
            <tr>
                <td></td>
                <td>
                    Yang Diambil keterangan,<br><br><br><br><br>
                    <strong style="text-decoration: underline;">{{ strtoupper($bap->nama_pemohon) }}</strong>
                </td>
            </tr>
        </table>

        <div style="page-break-before: always; clear: both;"></div>
        <p style="margin-top: 0px;">Demikian Berita Acara Klarifikasi ini selesai dibuat dengan sebenarnya atas kekuatan sumpah jabatan kemudian ditutup dan ditandatangani di Kantor Imigrasi Kelas II Non TPI Wonosobo pada hari, tanggal, bulan, dan tahun tersebut di atas.</p>

        <table class="ttd-box">
            <tr>
                <td>
                    Pemeriksa,<br><br><br><br><br>
                    <strong style="text-decoration: underline;">{{ strtoupper($bap->nama_petugas) }}</strong><br>
                    NIP. {{ $bap->nip_petugas }}
                </td>
                <td>
                    Mengetahui,<br>
                    Kepala Sub Seksi Penindakan<br>Keimigrasian,<br><br><br><br>
                    <strong style="text-decoration: underline;">{{ strtoupper($bap->nama_kasubsi) }}</strong><br>
                    NIP. {{ $bap->nip_kasubsi }}
                </td>
            </tr>
        </table>
    </div>

</body>
</html>