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
                    ->relationship('siswa', 'name')
                    ->required(),
                Forms\Components\Select::make('surah_id')
                    ->relationship('surah', 'name')
                    ->required(),
                Forms\Components\Select::make('tahfidz_id')
                    ->relationship('tahfidz', 'id')
                    ->required(),
                Forms\Components\TextInput::make('nilai')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('siswa.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('surah.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tahfidz.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nilai')
                    ->numeric()
                    ->sortable(),
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
            //
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
