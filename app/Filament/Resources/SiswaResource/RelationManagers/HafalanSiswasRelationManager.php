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


    public function form(Form $form): Form
    {
        // Simple form for creating new hafalan targets
        return $form
            ->schema([
                Forms\Components\Select::make('surah_id')
                    ->label('Surah Target')
                    ->relationship('surah', 'nama') // Assuming 'nama' is the display column in Surah
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([ // Allow creating new Surah if needed
                        Forms\Components\TextInput::make('nama')->required(),
                        Forms\Components\TextInput::make('jumlah_ayat')->numeric()->required(),
                    ]),
                 // semester_id will be set automatically based on the active semester
                 // siswa_id is set automatically by the relation manager
            ])->mutateFormDataUsing(function (array $data): array {
                // Automatically set the active semester ID when creating
                $activeSemesterId = Semester::where('is_active', true)->value('id');
                if ($activeSemesterId) {
                    $data['semester_id'] = $activeSemesterId;
                }
                // You might want to add validation here to ensure an active semester exists before creation
                return $data;
            });
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('surah.nama') // Use surah name as title
            ->columns([
                Tables\Columns\TextColumn::make('surah.nama')
                    ->label('Surah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai')
                    ->label('Nilai Terakhir')
                    ->placeholder('-'), // Placeholder if no riwayat exists yet
                Tables\Columns\TextColumn::make('status_hafalan')
                    ->label('Status Terakhir')
                    ->badge()
                     ->color(fn (?string $state): string => match ($state) {
                        'belum_hafal' => 'gray',
                        'sedang_hafal' => 'warning',
                        'selesai' => 'success',
                        default => 'gray',
                    })
                    ->placeholder('-'), // Placeholder if no riwayat exists yet
            ])
            ->filters([
                // Add filters if needed
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make('Tambah Riwayat')
                    ->icon('heroicon-o-plus-circle')
                    ->form([
                        DatePicker::make('tanggal')
                            ->label('Tanggal Setoran')
                            ->default(now())
                            ->required(),
                        Textarea::make('catatan')
                            ->label('Catatan Guru'),
                        // Assuming nilai is numeric 0-100 or similar
                        TextInput::make('nilai_baru')
                             ->label('Nilai')
                             ->numeric()
                             ->minValue(0)
                             ->maxValue(100), // Adjust max value as needed
                        Select::make('status_hafalan_baru')
                            ->label('Status Hafalan')
                            ->options([
                                'belum_hafal' => 'Belum Hafal',
                                'sedang_hafal' => 'Sedang Hafal',
                                'selesai' => 'Selesai',
                            ])
                            ->required(),
                    ])
                    ->action(function (HafalanSiswa $record, array $data) {
                        // Create RiwayatHafalan
                        $record->riwayatHafalans()->create([
                            'tanggal' => $data['tanggal'],
                            'catatan' => $data['catatan'],
                            'nilai' => $data['nilai_baru'],
                            'status_hafalan' => $data['status_hafalan_baru'],
                            // user_id might be needed if you track who input the record
                            // 'user_id' => auth()->id(),
                        ]);
                        // The RiwayatHafalanObserver should handle updating
                        // HafalanSiswa's 'nilai' and 'status_hafalan' fields.
                    })
                    ->modalHeading('Tambah Riwayat Hafalan'),

                Action::make('Lihat Riwayat')
                    ->icon('heroicon-o-eye')
                    ->modalContent(fn (HafalanSiswa $record) =>
                        View::make('filament.riwayat-hafalan-modal', [
                            'riwayats' => $record->riwayatHafalans()->orderBy('tanggal', 'desc')->get()
                         ])
                     ) // <- This parenthesis closes modalContent
                      // ->infolist([ ... ]) // Alternative using Infolist
                     ->modalHeading(fn (HafalanSiswa $record): string => 'Riwayat Hafalan Surah: ' . $record->surah->nama)
                     ->modalSubmitAction(false) // No submit button needed
                     ->modalCancelActionLabel('Tutup'),


                // Edit might be limited if updates happen via Riwayat
                Tables\Actions\EditAction::make()->hidden(), // Example: Hide edit action
                Tables\Actions\DeleteAction::make(), // To delete the target surah
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
