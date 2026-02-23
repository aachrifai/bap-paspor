<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Berita Acara Pendapat</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; font-size: 11.5pt; line-height: 1.5; margin: 0 1cm; }
        .kop-surat { text-align: center; border-bottom: 3px solid black; margin-bottom: 15px; padding-bottom: 5px; }
        .kop-surat h3, .kop-surat h4, .kop-surat p { margin: 0; }
        .kop-surat h3 { font-size: 14pt; }
        .kop-surat h4 { font-size: 12pt; }
        .kop-surat p { font-size: 10pt; }
        .title { text-align: center; font-weight: bold; margin-bottom: 20px; line-height: 1.5; }
        .content { text-align: justify; }
        table.biodata { width: 100%; margin-left: 15px; margin-bottom: 15px; }
        table.biodata td { vertical-align: top; padding: 2px 0; }
        .ttd-box { width: 100%; margin-top: 30px; text-align: center; }
        .ttd-box td { width: 50%; vertical-align: bottom; }
        ol { margin-top: 5px; padding-left: 20px; }
        ol li { margin-bottom: 5px; text-align: justify; }
    </style>
</head>
<body>

    @php
        // Helper Terbilang Tanggal & Bulan untuk hari ini (Saat Kasi Cetak BAPEN)
        $formatter = new NumberFormatter('id', NumberFormatter::SPELLOUT);
        $hari = \Carbon\Carbon::now()->translatedFormat('l');
        $tgl_angka = \Carbon\Carbon::now()->format('d');
        $tgl_huruf = ucwords($formatter->format($tgl_angka));
        $bulan = \Carbon\Carbon::now()->translatedFormat('F');
        $tahun_angka = \Carbon\Carbon::now()->format('Y');
        $tahun_huruf = ucwords($formatter->format($tahun_angka));

        // Format Tanggal BAP sebelumnya
        $tgl_bap = \Carbon\Carbon::parse($bap->updated_at)->format('d-m-Y');
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
        <span style="border-bottom: 1px solid black;">BERITA ACARA PENDAPAT</span><br>
        <span style="font-weight: normal; font-size: 11pt;">Nomor: WIM.13.IMI.6-GR.03.01-___________________</span>
    </div>

    <div class="content">
        <p>Pada hari ini <strong>{{ $hari }}</strong> tanggal <strong>{{ $tgl_huruf }}</strong> bulan <strong>{{ $bulan }}</strong> tahun <strong>{{ $tahun_huruf }}</strong>, saya:</p>
        
        <p style="text-align: center; font-weight: bold; margin: 5px 0;">SUWANDONO</p>
        <p>Pangkat/Golongan Penata Tk. I (III/d), NIP. 198505262009121009 Kepala Seksi Intelijen dan Penindakan Keimigrasian pada Kantor Imigrasi Kelas II Non TPI Wonosobo, setelah melihat, membaca dan meneliti hasil klarifikasi yang tertuang di dalam Berita Acara Klarifikasi tanggal {{ $tgl_bap }} yang dilakukan terhadap seorang Warga Negara Indonesia atas:</p>

        <table class="biodata">
            <tr>
                <td style="width: 150px;">Nama</td>
                <td>: <strong>{{ strtoupper($bap->nama_pemohon) }}</strong></td>
            </tr>
            <tr>
                <td>Tempat/Tgl Lahir</td>
                <td>: {{ $bap->tempat_lahir }}, {{ \Carbon\Carbon::parse($bap->tgl_lahir)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>: {{ $bap->pekerjaan }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $bap->alamat_lengkap }}</td>
            </tr>
        </table>

        <p style="margin-bottom: 0;">Kami berpendapat:</p>
        <ol>
            <li>Bahwa berdasarkan hasil pemeriksaan, {{ lcfirst($bap->hasil_pemeriksaan) }}</li>
            <li>Bahwa menurut pendapat petugas, {{ lcfirst($bap->pendapat_petugas) }}</li>
            
            <li>Bahwa untuk menguatkan permohonan penggantian Paspor, yang bersangkutan telah melampirkan dokumen pendukung berupa:
                <ol type="a">
                    <li>KTP Elektronik NIK {{ $bap->nik_ktp }} yang dikeluarkan Kantor Disdukcapil tanggal {{ \Carbon\Carbon::parse($bap->tgl_keluar_ktp)->format('d-m-Y') }};</li>
                    <li>Kartu Keluarga Nomor {{ $bap->no_kk }} yang dikeluarkan Kantor Disdukcapil tanggal {{ \Carbon\Carbon::parse($bap->tgl_keluar_kk)->format('d-m-Y') }};</li>
                    <li>Kutipan Akta/Buku Nikah/Ijazah Nomor: {{ $bap->no_akta }} yang dikeluarkan Disdukcapil tanggal {{ \Carbon\Carbon::parse($bap->tgl_keluar_akta)->format('d-m-Y') }}, dimana data yang tertera pada semua dokumen tersebut sama.</li>
                </ol>
            </li>
        </ol>

        <p>Berdasarkan hal tersebut di atas dan mengingat Peraturan Menteri Hukum dan HAM RI Nomor 18 Tahun 2022 tentang Perubahan Atas Peraturan Menteri Hukum dan HAM RI Nomor 8 Tahun 2014 tentang Paspor Biasa dan Surat Perjalanan Laksana Paspor serta Surat Dinas Direktur Jenderal Imigrasi tanggal 21 Juni 2023 tentang Penerbitan Paspor RI ke Negara Tujuan PMI, maka kami berpendapat agar permohonan Paspor yang bersangkutan untuk dapat diberikan Paspor Baru. Namun demikian keputusan selanjutnya kami serahkan kepada Kepala Seksi Dokumen Perjalanan dan Izin Tinggal Keimigrasian.</p>

        <p>Demikian Berita Acara Pendapat ini dibuat dengan sebenarnya atas kekuatan sumpah jabatan. Kemudian ditutup dan ditandatangani di Kantor Imigrasi Kelas II Non TPI Wonosobo pada hari, tanggal, bulan dan tahun tersebut di atas.</p>

        <table class="ttd-box">
            <tr>
                <td></td>
                <td>
                    Kepala Seksi Intelijen dan Penindakan<br>Keimigrasian,<br><br><br><br><br>
                    <strong>SUWANDONO</strong><br>
                    NIP. 198505262009121009
                </td>
            </tr>
        </table>
    </div>

</body>
</html>