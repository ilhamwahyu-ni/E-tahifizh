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
use App\Models\RekapSemesterSiswa; // Import RekapSemesterSiswa model

class RekapSemesterSiswasRelationManager extends RelationManager
{
    protected static string $relationship = 'rekapSemesterSiswas'; // Sesuaikan dengan nama relasi
    protected static ?string $recordTitleAttribute = 'semester.nama'; // Tampilkan nama semester sebagai judul

    //make button create & anather action to false


    protected static ?string $title = 'Catatan Globa siswa'; // Judul untuk tampilan ini
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Pilih Semester (Hanya saat Create, Disabled saat Edit)
                Forms\Components\Select::make('semester_id')
                    ->label('Semester')
                    ->options(Semester::with('tahunAjaran')->where('is_active', true)->get()->mapWithKeys(fn($semester) => [
                        $semester->id => "{$semester->nama} - {$semester->tahunAjaran->nama}"
                    ])->all()), // Ambil hanya semester yang aktif sebagai opsi


                // Catatan Global
                Forms\Components\Textarea::make('catatan_global')
                    ->label('Catatan Global Semester')
                    ->required()
                    ->rows(5) // Atur tinggi area teks
                    ->columnSpanFull(), // Ambil lebar penuh

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // Use semester name or a combination for the title
            ->recordTitle(fn($record) => 'Rekap Semester: ' . $record->semester?->nama ?? $record->semester_id)
            ->columns([
                Tables\Columns\TextColumn::make('catatan_global')
                    ->label('Catatan Global')
                    ->limit(50) // Limit display length in table
                    ->tooltip(fn($record) => $record->catatan_global) // Show full text on hover
                    ->wrap(), // Allow text wrapping
                Tables\Columns\TextColumn::make('semester.tahunAjaran.nama')
                    ->label('Tahun Ajaran')
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester.nama') // Assumes 'semester' relationship exists and 'nama' attribute on Semester model
                    ->label('Semester')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                // Add filters if needed
            ])
            ->headerActions([
                // Only allow creating if semesters are not automatically generated elsewhere
                Tables\Actions\CreateAction::make()->label('Tambah Catatan')
                    ->modalHeading('') // Ubah label jika perlu
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
                    })->createAnother(false)->form([ // Form HANYA untuk Create Action

                            Forms\Components\Textarea::make('catatan_global')
                                ->label('Catatan Global Semester')
                                ->required()
                                ->rows(5) // Atur tinggi area teks
                                ->columnSpanFull(), // Ambil lebar penuh
                        ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // DeleteAction might be needed depending on requirements
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


}
