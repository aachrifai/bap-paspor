<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Berita Acara Pendapat</title>
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

        .content { text-align: justify; }
        table.biodata { width: 100%; margin-left: 15px; margin-bottom: 15px; border-collapse: collapse; }
        table.biodata td { vertical-align: top; padding: 2px 0; }

        /* Pengaturan List agar rapi untuk poin 1,2,3 dan a,b,c */
        ol { margin-top: 5px; padding-left: 20px; }
        ol li { margin-bottom: 5px; text-align: justify; }
        ol[type="a"] { margin-top: 5px; margin-bottom: 10px; }
        ol[type="a"] li { margin-bottom: 3px; }

        /* Tanda Tangan Kasi (Kanan Atas-Bawah) */
        table.ttd-kasi { width: 100%; margin-top: 30px; border-collapse: collapse; }
        table.ttd-kasi td.kosong { width: 55%; }
        table.ttd-kasi td.isi { width: 45%; text-align: left; vertical-align: top; }
    </style>
</head>
<body>

    @php
        $formatter = new NumberFormatter('id', NumberFormatter::SPELLOUT);
        $hari = \Carbon\Carbon::now()->translatedFormat('l');
        $tgl_angka = \Carbon\Carbon::now()->format('d');
        $tgl_huruf = ucwords($formatter->format($tgl_angka));
        $bulan = \Carbon\Carbon::now()->translatedFormat('F');
        $tahun_angka = \Carbon\Carbon::now()->format('Y');
        $tahun_huruf = ucwords($formatter->format($tahun_angka));

        // Mengambil tanggal BAP sebelumnya untuk direferensikan
        $tgl_bap = \Carbon\Carbon::parse($bap->updated_at)->format('d-m-Y');
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
        <span class="judul">BERITA ACARA PENDAPAT</span>
    </div>

    <div class="content">
        <p>Pada hari ini <strong>{{ $hari }}</strong> tanggal <strong>{{ $tgl_huruf }}</strong> bulan <strong>{{ $bulan }}</strong> tahun <strong>{{ $tahun_huruf }}</strong>, saya:</p>

        <p style="text-align: center; font-weight: bold; margin: 5px 0;">SUWANDONO</p>
        <p>Pangkat/Golongan Penata Tk. I (III/d), NIP. 198505262009121009 Kepala Seksi Intelijen dan Penindakan Keimigrasian pada Kantor Imigrasi Kelas II Non TPI Wonosobo, setelah melihat, membaca dan meneliti hasil pemeriksaan yang tertuang di dalam Berita Acara Pemeriksaan tanggal {{ $tgl_bap }} yang dilakukan terhadap seorang Warga Negara Indonesia atas:</p>

        <table class="biodata">
            <tr>
                <td style="width: 150px;">Nama</td>
                <td>: <strong>{{ strtoupper($bap->nama_pemohon) }}</strong></td>
            </tr>
            <tr>
                <td>Tempat/tgl Lahir</td>
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
            @php
                // Logika membaca JSON hasil inputan form Kasi
                $pendapat = json_decode($bap->pendapat_kasi ?? '[]', true);
            @endphp

            @if(!empty($pendapat))
                @foreach($pendapat as $item)
                    <li>
                        {{ $item['utama'] }}
                        
                        @if(isset($item['sub']) && is_array($item['sub']) && count($item['sub']) > 0)
                            <ol type="a">
                                @foreach($item['sub'] as $sub)
                                    @if(!empty($sub))
                                        <li>{{ $sub }}</li>
                                    @endif
                                @endforeach
                            </ol>
                        @endif
                    </li>
                @endforeach
            @else
                <li>Bahwa yang bersangkutan telah dilakukan pemeriksaan sesuai Berita Acara Pemeriksaan.</li>
            @endif
        </ol>

        <p>Berdasarkan hal tersebut di atas dan merujuk peraturan yang berlaku (Peraturan Menteri Hukum dan HAM RI Nomor 18 Tahun 2022 tentang Perubahan Atas Peraturan Menteri Hukum dan HAM RI Nomor 8 Tahun 2014 tentang Paspor Biasa dan Surat Perjalanan Laksana Paspor) bahwa yang bersangkutan dapat diberikan penggantian Paspor yang telah hilang. Namun demikian keputusan selanjutnya kami serahkan kepada Kepala Kantor Imigrasi Kelas II Non TPI Wonosobo;</p>

        <p style="margin-top: 20px;">Demikian Berita Acara Pendapat ini dibuat dengan sebenarnya atas kekuatan sumpah jabatan.</p>
        <p style="margin-top: 0;">Kemudian ditutup dan ditandatangani di Kantor Imigrasi Kelas II Non TPI Wonosobo pada hari, tanggal, bulan dan tahun tersebut di atas.</p>

        <table class="ttd-kasi">
            <tr>
                <td class="kosong"></td> <td class="isi">
                    <p style="margin: 0;">Kepala Seksi Intelijen dan Penindakan<br>Keimigrasian,</p>
                    <div style="height: 70px;"></div>
                    <p style="margin: 0; line-height: 1.2;">
                        <strong style="text-decoration: underline;">SUWANDONO</strong><br>
                        NIP. 198505262009121009
                    </p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>