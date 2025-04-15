<?php

namespace App\Filament\Resources\RombelResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Siswa; // Import Siswa model
use App\Filament\Resources\SiswaResource; // Import SiswaResource for linking

class SiswasRelationManager extends RelationManager
{
    protected static string $relationship = 'siswas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nis')
                    ->required()
                    ->unique(Siswa::class, 'nis', ignoreRecord: true) // Ensure NIS is unique, ignoring the current record on edit
                    ->maxLength(255),
                Forms\Components\Select::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),
                // Assuming 'status' is an enum or has predefined values
                Forms\Components\Select::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'nonaktif' => 'Nonaktif',
                        'lulus' => 'Lulus',
                        'pindah' => 'Pindah',
                    ])
                    ->required(),
                // sekolah_id and rombel_id are typically handled automatically by the relation manager
                // If sekolah_id needs to be set explicitly based on the Rombel's sekolah,
                // you might need a mutateFormDataBeforeCreate hook:
                // ->mutateFormDataBeforeCreate(function (array $data): array {
                //     $rombel = $this->getOwnerRecord();
                //     $data['sekolah_id'] = $rombel->sekolah_id;
                //     // rombel_id is usually set automatically
                //     return $data;
                // })
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kelamin'),
                Tables\Columns\TextColumn::make('status')
                    ->badge() // Optional: display status as a badge
                    ->color(fn (string $state): string => match ($state) {
                        'aktif' => 'success',
                        'nonaktif' => 'warning',
                        'lulus' => 'info',
                        'pindah' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                // If the relationship was ManyToMany, you would add AttachAction here:
                // Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                 Tables\Actions\ViewAction::make()
                    ->url(fn (Siswa $record): string => SiswaResource::getUrl('view', ['record' => $record])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
