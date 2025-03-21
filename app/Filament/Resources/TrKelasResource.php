<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrKelasResource\Pages;
use App\Filament\Resources\TrKelasResource\RelationManagers;
use App\Models\TrKelas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrKelasResource extends Resource
{
    protected static ?string $model = TrKelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tm_kelas_id')
                    ->relationship('tmKelas', 'id')
                    ->required(),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ruangan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('siswa_aktif')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('ajaran')
                    ->required()
                    ->maxLength(4),
                Forms\Components\TextInput::make('semester')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tmKelas.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ruangan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('siswa_aktif')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ajaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('semester')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
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
            'index' => Pages\ListTrKelas::route('/'),
            'create' => Pages\CreateTrKelas::route('/create'),
            'edit' => Pages\EditTrKelas::route('/{record}/edit'),
        ];
    }
}
