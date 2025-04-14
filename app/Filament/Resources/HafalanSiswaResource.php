<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HafalanSiswaResource\Pages;
use App\Filament\Resources\HafalanSiswaResource\RelationManagers;
use App\Models\HafalanSiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HafalanSiswaResource extends Resource
{
    protected static ?string $model = HafalanSiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('siswa_id')
                    ->relationship('siswa', 'id')
                    ->required(),
                Forms\Components\Select::make('surah_id')
                    ->relationship('surah', 'id')
                    ->required(),
                Forms\Components\Select::make('semester_id')
                    ->relationship('semester', 'id')
                    ->required(),
                Forms\Components\TextInput::make('tingkat_kelas')
                    ->required()
                    ->maxLength(10),
                Forms\Components\TextInput::make('nilai')
                    ->required()
                    ->maxLength(10),
                Forms\Components\TextInput::make('status_hafalan')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('siswa.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('surah.nama')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tingkat_kelas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nilai')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_hafalan'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            RelationManagers\RiwayatHafalansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHafalanSiswas::route('/'),
            'create' => Pages\CreateHafalanSiswa::route('/create'),
            'edit' => Pages\EditHafalanSiswa::route('/{record}/edit'),
        ];
    }
}
