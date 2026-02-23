<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SK Kakanim</title>

    <style>
        @page {
            size: A4;
            margin: 1.2cm 1.5cm 1.2cm 1.5cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 10pt;
            line-height: 1.2;
            margin: 0;
        }

        .kop-header {
            text-align: center;
            margin-bottom: 6px;
        }

        .logo-garuda {
            width: 60px;
            margin-bottom: 3px;
        }

        .teks-kop h3 {
            margin: 0;
            font-size: 11pt;
            font-weight: normal;
        }

        .teks-kop h4 {
            margin: 0;
            font-size: 12pt;
            font-weight: bold;
        }

        .title-section {
            text-align: center;
            font-weight: bold;
            margin: 8px 0 10px 0;
        }

        .title-section p {
            margin: 2px 0;
        }

        table.tabel-isi {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        table.tabel-isi td {
            vertical-align: top;
            padding: 2px 4px;
            text-align: justify;
        }

        .w-100 {
            width: 90px;
            font-weight: bold;
        }

        .w-20 {
            width: 15px;
        }

        ol {
            margin: 0;
            padding-left: 18px;
        }

        ol li {
            margin-bottom: 3px;
        }

        table.biodata {
            width: 100%;
            margin-top: 4px;
            border-collapse: collapse;
        }

        table.biodata td {
            padding: 1px 4px;
        }

        .memutuskan {
            text-align: center;
            font-weight: bold;
            margin: 8px 0;
        }

        table.ttd {
            width: 100%;
            margin-top: 20px;
            page-break-inside: avoid;
        }

        table.ttd td.kosong {
            width: 55%;
        }

        table.ttd td.isi {
            width: 45%;
            text-align: left;
        }

        .tembusan {
            margin-top: 10px;
            font-size: 9pt;
        }

        .tembusan ol {
            margin-top: 3px;
            padding-left: 18px;
        }

        * {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

<div class="kop-header">
    <img src="{{ public_path('images/logo-imigrasi.png') }}" class="logo-garuda">
    <div class="teks-kop">
        <h3>
            KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN<br>
            REPUBLIK INDONESIA<br>
            KANTOR WILAYAH JAWA TENGAH
        </h3>
        <h4>KANTOR IMIGRASI KELAS II NON TPI WONOSOBO</h4>
    </div>
</div>

<div class="title-section">
    <p>KEPUTUSAN KEPALA KANTOR IMIGRASI KELAS II NON TPI WONOSOBO</p>
    <p>NOMOR: {{ trim(preg_replace('/^NOMOR:\s*/i', '', $bap->nomor_sk)) }}</p>
    <p style="margin-top:6px;">TENTANG</p>
    <p>
        PENGGANTIAN DOKUMEN PERJALANAN REPUBLIK INDONESIA<br>
        ATAS NAMA {{ strtoupper($bap->nama_pemohon) }}
    </p>
    <p style="margin-top:8px;">
        KEPALA KANTOR IMIGRASI KELAS II NON TPI WONOSOBO
    </p>
</div>

<table class="tabel-isi">
    <tr>
        <td class="w-100">Menimbang</td>
        <td class="w-20">:</td>
        <td>
            <ol type="a">
                <li>
                    bahwa adanya permohonan penggantian Paspor RI Nomor 
                    {{ $bap->nomor_paspor_lama }} yang dikeluarkan 
                    {{ $bap->kanim_penerbit_lama }} tanggal 
                    {{ \Carbon\Carbon::parse($bap->tgl_keluar_paspor_lama)->format('d-m-Y') }} 
                    berlaku sampai tanggal 
                    {{ \Carbon\Carbon::parse($bap->tgl_habis_paspor_lama)->format('d-m-Y') }} 
                    atas nama {{ strtoupper($bap->nama_pemohon) }} 
                    {{ $bap->alasan_sk }};
                </li>
                <li>
                    bahwa terhadap yang bersangkutan telah dimintakan keterangan 
                    dalam bentuk Berita Acara Pemeriksaan serta Berita Acara Pendapat;
                </li>
                <li>
                    bahwa untuk melanjutkan permohonan dimaksud diperlukan adanya 
                    surat keputusan kepala kantor;
                </li>
            </ol>
        </td>
    </tr>

    <tr>
        <td class="w-100">Mengingat</td>
        <td class="w-20">:</td>
        <td>
            <ol>
                <li>Undang-undang Nomor 6 Tahun 2011 tentang Keimigrasian;</li>
                <li>Peraturan Pemerintah Nomor 31 Tahun 2013 tentang Pelaksanaan Undang-undang Nomor 6 Tahun 2011 tentang Keimigrasian;</li>
                <li>Peraturan Menteri Hukum dan HAM RI Nomor 18 Tahun 2022 tentang Perubahan Atas Peraturan Menteri Hukum dan HAM RI Nomor 8 Tahun 2014 tentang Paspor Biasa dan Surat Perjalanan Laksana Paspor.</li>
            </ol>
        </td>
    </tr>
</table>

<div class="memutuskan">MEMUTUSKAN</div>

<table class="tabel-isi">
    <tr>
        <td class="w-100">Menetapkan</td>
        <td class="w-20">:</td>
        <td>
            KEPUTUSAN KEPALA KANTOR IMIGRASI KELAS II NON TPI WONOSOBO 
            TENTANG PENGGANTIAN DOKUMEN PERJALANAN REPUBLIK INDONESIA 
            ATAS NAMA {{ strtoupper($bap->nama_pemohon) }}
        </td>
    </tr>

    <tr>
        <td class="w-100">KESATU</td>
        <td class="w-20">:</td>
        <td>
            Memerintahkan Kepala Seksi Dokintalkim Kantor Imigrasi Kelas II Non TPI Wonosobo 
            untuk melanjutkan proses penggantian Paspor RI atas:

            <table class="biodata">
                <tr>
                    <td style="width:160px;">Nama</td>
                    <td>: {{ strtoupper($bap->nama_pemohon) }}</td>
                </tr>
                <tr>
                    <td>Tempat/Tanggal Lahir</td>
                    <td>: {{ $bap->tempat_lahir }}, {{ \Carbon\Carbon::parse($bap->tgl_lahir)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $bap->alamat_lengkap }}</td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td class="w-100">KEDUA</td>
        <td class="w-20">:</td>
        <td>
            Penggantian Paspor RI pada diktum pertama keputusan ini dilaksanakan 
            sesuai dengan Standar Operasional Prosedur yang berlaku;
        </td>
    </tr>

    <tr>
        <td class="w-100">KETIGA</td>
        <td class="w-20">:</td>
        <td>
            Keputusan ini mulai berlaku sejak tanggal ditetapkan dengan catatan 
            apabila dikemudian hari terdapat kekeliruan akan diadakan pembetulan seperlunya.
        </td>
    </tr>
</table>

<table class="ttd">
    <tr>
        <td class="kosong"></td>
        <td class="isi">
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td style="width:80px;">Ditetapkan di</td>
                    <td>: Wonosobo</td>
                </tr>
                <tr>
                    <td>pada tanggal</td>
                    <td>: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
                </tr>
            </table>

            <p style="margin-top:10px;">
                {{ $bap->jabatan_ttd_sk }}
            </p>

            <div style="height:50px;"></div>

            <p style="font-weight:bold; text-decoration:underline; margin:0;">
                {{ strtoupper($bap->nama_ttd_sk) }}
            </p>
        </td>
    </tr>
</table>

<div class="tembusan">
    <strong>Tembusan:</strong>
    <ol>
        <li>Direktur Pengawasan dan Penindakan Keimigrasian Direktorat Jenderal Imigrasi;</li>
        <li>Kepala Kantor Wilayah Kementerian Hukum dan HAM Jawa Tengah.</li>
    </ol>
</div>

</body>
</html>