<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
// use App\Filament\Resources\SiswaResource\RelationManagers; // Keep if other RMs exist, remove if only these two
use App\Filament\Resources\SiswaResource\RelationManagers\HafalanSiswasRelationManager; // Added import
use App\Filament\Resources\SiswaResource\RelationManagers\RekapSemesterSiswasRelationManager; // Added import
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists; // Import namespace Infolists
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\BadgeEntry;
use Filament\Infolists\Components\Section; // Opsional: untuk pengelompokan
use Filament\Infolists\Components\Grid; // Opsional: untuk layout

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nis')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(100),
                Forms\Components\Select::make('rombel_id')
                    ->relationship('rombel', 'id')
                    ->required(),
                Forms\Components\Select::make('sekolah_id')
                    ->relationship('sekolah', 'id')
                    ->required()->hidden(),
                Forms\Components\TextInput::make('jenis_kelamin')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                //make count hafalan
                Tables\Columns\TextColumn::make('hafalan_siswas_count') // Ensure lowercase and snake_case
                    ->counts('hafalanSiswas') // Ensure the relationship name matches the model
                    ->label('Hafalan Count')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rombel.id')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenis_kelamin'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
