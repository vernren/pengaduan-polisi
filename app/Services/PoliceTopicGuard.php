<?php

namespace App\Services;

class PoliceTopicGuard
{
    protected static $keywords = [
        // Kepolisian umum
        'polisi','kepolisian','lapor','laporan','pengaduan','pengawasan',

        // Dokumen & lalu lintas
        'sim','stnk','bpkb','ktp','tilang','razia','samsat',

        // Kejadian
        'kehilangan','kecelakaan','tabrakan','penipuan','pencurian',
        'penganiayaan','perampokan','pelecehan','kekerasan',

        // Hukum umum
        'pidana','perdata','hukum','pasal','undang','aturan',

        // Bahasa natural
        'bagaimana','gimana','kenapa','apa','jelaskan','tolong','cara',
    ];

    public static function isAllowed(string $message): bool
    {
        $message = strtolower($message);

        // Izinkan pesan pendek & natural
        if (strlen($message) <= 5) {
            return true;
        }

        foreach (self::$keywords as $word) {
            if (str_contains($message, $word)) {
                return true;
            }
        }

        return false;
    }
}
