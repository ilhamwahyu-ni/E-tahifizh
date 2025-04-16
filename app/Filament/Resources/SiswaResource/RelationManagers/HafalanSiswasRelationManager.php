<?php

namespace App\Filament\Resources\SiswaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Semester; // Import Semester model
use App\Models\Surah; // Import Surah model
use App\Models\HafalanSiswa; // Import HafalanSiswa model for action type hinting
use App\Models\RiwayatHafalan; // Import RiwayatHafalan for action logic
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\View; // For modal content view

class HafalanSiswasRelationManager extends RelationManager
{
    protected static string $relationship = 'hafalanSiswas'; // Assuming this is the relationship name

    // Filter by active semester
    public function getEloquentQuery(): Builder
    {
        $activeSemesterId = Semester::where('is_active', true)->value('id');

        // Start with the base query from the parent class
        $query = parent::getEloquentQuery();

        // Apply the filter if an active semester exists
        if ($activeSemesterId) {
            $query->where('semester_id', $activeSemesterId);
        } else {
            // Optionally, handle the case where no semester is active,
            // maybe return an empty result or show all?
            // For now, let's return an empty result to avoid showing incorrect data.
            $query->whereRaw('1 = 0'); // Ensures no records are returned
        }
        return $query;
    }


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('surah.nama') // Use surah name as title
            ->columns([

                Tables\Columns\TextColumn::make('surah.nama')
                    ->label('Surah Target')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tingkat_kelas') // Kolom ini opsional, tampilkan jika relevan
                    ->label('Kelas Saat Target Dibuat')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nilai')
                    ->searchable(),
                // --- Pastikan logika match ini sesuai ---
                Tables\Columns\TextColumn::make('status_hafalan')
                    ->label('Status Terakhir')
                    ->badge()
                    ->color(fn(?string $state): ?string => match (strtolower($state)) {
                        'belum' => 'gray',    // Sesuaikan dengan value Select form
                        'proses' => 'warning', // Sesuaikan dengan value Select form
                        'selesai' => 'success', // Sesuaikan dengan value Select form
                        default => null, // Use null for no color
                    })
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('semester.nama')
                    ->label('Semester')
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester.tahunAjaran.nama')
                    ->label('Tahun Ajaran')
                    ->sortable(),
                // --- Kolom Timestamp (Opsional) ---
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                Tables\Filters\SelectFilter::make('semester_id')
                    // Menggunakan options() lebih eksplisit di sini, sudah benar
                    ->options(fn() => \App\Models\Semester::with('tahunAjaran')->get()->mapWithKeys(fn($semester) => [
                        $semester->id => "{$semester->nama} ({$semester->tahunAjaran->nama})",
                    ]))
                    ->label('Filter Semester'),
                // Filter lain bisa ditambahkan di sini jika perlu
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->createAnother(false)
                    ->label('Tambah Hafalan') // Ubah label jika perlu
                    ->modalHeading('') 
                    ->mutateFormDataUsing(function (array $data): array {
                        // Logika mencari dan menetapkan semester aktif
                        $activeSemesterId = Semester::where('is_active', true)->value('id');
                        if (!$activeSemesterId) {
                            // Kirim notifikasi error jika tidak ada semester aktif
                            \Filament\Notifications\Notification::make()
                                ->title('Gagal Menambahkan Data')
                                ->body('Tidak ada semester aktif yang ditemukan. Silakan aktifkan semester terlebih dahulu.')
                                ->danger()
                                ->send();
                            // Batalkan proses create dengan pesan yang lebih jelas
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                'semester_id' => 'Tidak ada semester aktif yang ditemukan. Silakan aktifkan semester terlebih dahulu.',
                            ]);
                        }
                        $data['semester_id'] = $activeSemesterId; // Set semester_id otomatis
                        // Opsional: Set 'tingkat_kelas' otomatis jika perlu
                        // $data['tingkat_kelas'] = $this->getOwnerRecord()->kelas_saat_ini ?? null;
                        return $data;
                    })
                    ->form([ // Form HANYA untuk Create Action
                        Forms\Components\Select::make('surah_id')
                            ->relationship('surah', 'nama') // Pastikan relasi 'surah' ada di model HafalanSiswa
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Pilih Surah'),
                        Forms\Components\TextInput::make('nilai')
                            ->numeric()
                            ->default(0) // Nilai default saat buat baru
                            ->label('Nilai Awal'),
                        Forms\Components\TextInput::make('tingkat_kelas')
                            ->required()
                            ->maxLength(10),
                        Forms\Components\Select::make('status_hafalan')
                            ->options([
                                'Belum' => 'Belum',
                                'Proses' => 'Proses',
                                'Selesai' => 'Selesai',
                            ])
                            ->default('Belum') // Status default saat buat baru
                            ->required()
                            ->label('Status Awal'),
                        // TIDAK ADA input semester_id di sini
                        // Tambahkan input tingkat_kelas di sini jika perlu diisi manual saat create
                    ]),

            ])
            ->actions([
                // Edit might be limited if updates happen via Riwayat
                Tables\Actions\EditAction::make()->form([ // Form HANYA untuk Edit Action
                    // TIDAK BOLEH ADA input semester_id
                    // TIDAK BOLEH ADA input surah_id (atau buat disabled jika perlu)
                    // Forms\Components\Select::make('surah_id')->disabled()->relationship('surah', 'nama')->label('Surah (Tidak dapat diubah)'),
                    Forms\Components\TextInput::make('nilai')
                        ->numeric()
                        ->required()
                        ->label('Nilai'),
                    Forms\Components\Select::make('status_hafalan')
                        ->options([
                            'Belum' => 'Belum',
                            'Proses' => 'Proses',
                            'Selesai' => 'Selesai',
                        ])
                        ->required()
                        ->label('Status Hafalan'),
                    // Tambahkan input tingkat_kelas di sini jika boleh diedit
                ]), // Example: Hide edit action
                Tables\Actions\DeleteAction::make(), // To delete the target surah
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
