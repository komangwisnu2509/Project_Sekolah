<?php

namespace App\Mail;

use App\Models\PpdbPendaftaran;
use App\Models\ProfilSekolah;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PpdbStatusNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;
    public $profil;

    /**
     * Create a new message instance.
     */
    public function __construct(PpdbPendaftaran $pendaftaran, ?ProfilSekolah $profil = null)
    {
        $this->pendaftaran = $pendaftaran;
        $this->profil = $profil;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $namaSekolah = $this->profil?->nama_sekolah ?? 'Sekolah Astika Dharma';

        if ($this->pendaftaran->status === 'Diterima') {
            $subject = '🎉 SELAMAT! Anda Diterima di PPDB ' . $namaSekolah . ' - Petunjuk Daftar Ulang';
        } else if ($this->pendaftaran->status === 'Ditolak') {
            $subject = 'Pemberitahuan Hasil Seleksi PPDB ' . $namaSekolah;
        } else {
            $subject = 'Update Status Pendaftaran PPDB ' . $namaSekolah;
        }

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ppdb_status',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
