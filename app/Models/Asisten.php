<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Asisten
 * 
 * @property int $id
 * @property string $nama
 * @property string $kode
 * @property string $password
 * @property string|null $api_token
 * @property int $role_id
 * @property string $deskripsi
 * @property string $nomor_telepon
 * @property string $id_line
 * @property string $instagram
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Role $role
 * @property Collection|Feedback[] $feedback
 * @property Collection|FotoAsisten[] $foto_asistens
 * @property Collection|HistoryJaga[] $history_jagas
 * @property Collection|JadwalJaga[] $jadwal_jagas
 * @property Collection|JadwalPiket[] $jadwal_pikets
 * @property Collection|KeluhanAslab[] $keluhan_aslabs
 * @property Collection|LaporanPraktikan[] $laporan_praktikans
 * @property Collection|Nilai[] $nilais
 * @property Collection|Pelanggaran[] $pelanggarans
 * @property Collection|Polling[] $pollings
 * @property Collection|Praktikum[] $praktikums
 *
 * @package App\Models
 */
class Asisten extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;
	protected $table = 'asistens';

	protected $casts = [
		'role_id' => 'int'
	];

	protected $hidden = [
		'password',
		'api_token',
		'remember_token'
	];

	protected $fillable = [
		'nama',
		'kode',
		'password',
		'api_token',
		'role_id',
		'deskripsi',
		'nomor_telepon',
		'id_line',
		'instagram',
		'remember_token'
	];

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function feedback()
	{
		return $this->hasMany(Feedback::class);
	}

	public function foto_asistens()
	{
		return $this->hasMany(FotoAsisten::class, 'kode', 'kode');
	}

	public function history_jagas()
	{
		return $this->hasMany(HistoryJaga::class);
	}

	public function jadwal_jagas()
	{
		return $this->hasMany(JadwalJaga::class);
	}

	public function jadwal_pikets()
	{
		return $this->hasMany(JadwalPiket::class);
	}

	public function keluhan_aslabs()
	{
		return $this->hasMany(KeluhanAslab::class);
	}

	public function laporan_praktikans()
	{
		return $this->hasMany(LaporanPraktikan::class);
	}

	public function nilais()
	{
		return $this->hasMany(Nilai::class);
	}

	public function pelanggarans()
	{
		return $this->hasMany(Pelanggaran::class);
	}

	public function pollings()
	{
		return $this->hasMany(Polling::class);
	}

	public function praktikums()
	{
		return $this->hasMany(Praktikum::class, 'pj_id');
	}
}
