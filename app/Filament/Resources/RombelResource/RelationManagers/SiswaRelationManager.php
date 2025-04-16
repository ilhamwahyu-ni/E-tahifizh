<?php

namespace App\Filament\Resources\RombelResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HafalanSiswaResource;
use App\Filament\Resources\SiswaResource; // Import the correct SiswaResource class
use App\Models\Siswa; // Import the Siswa model
use App\Filament\Resources\SiswaResource\RelationManagers\HafalanSiswasRelationManager; // Added import
use App\Filament\Resources\SiswaResource\RelationManagers\RekapSemesterSiswasRelationManager; // Added import

class SiswaRelationManager extends RelationManager
{
    protected static string $relationship = 'Siswa';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nis')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nis')
            ->columns([
                Tables\Columns\TextColumn::make('nis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                //make count hafalan
                Tables\Columns\TextColumn::make('jenis_kelamin'),
                Tables\Columns\TextColumn::make('hafalan_siswas_count') // Ensure lowercase and snake_case
                    ->counts('hafalanSiswas') // Ensure the relationship name matches the model
                    ->label('Jumlah Hafalan')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Opsi 2: Tombol "Kelola" atau "Lihat Detail" (mengarah ke View Page Siswa)
                // Ini berguna jika halaman View SiswaResource Anda juga menampilkan Relation Manager
                Tables\Actions\Action::make('kelola_siswa')
                    ->label('Kelola Siswa')
                    ->icon('heroicon-m-user-circle') // Ganti ikon jika perlu
                    ->url(fn(Siswa $record): string => SiswaResource::getUrl('edit', ['record' => $record])), // Arahkan ke halaman view

                // Tetap ada tombol untuk mengeluarkan siswa dari rombel
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function getRelations(): array
    {
        return [
            HafalanSiswasRelationManager::class,
            RekapSemesterSiswasRelationManager::class,
        ];
    }
}
