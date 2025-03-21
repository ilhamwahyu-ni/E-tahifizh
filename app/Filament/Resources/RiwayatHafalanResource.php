<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiwayatHafalanResource\Pages;
use App\Filament\Resources\RiwayatHafalanResource\RelationManagers;
use App\Models\RiwayatHafalan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RiwayatHafalanResource extends Resource
{
    protected static ?string $model = RiwayatHafalan::class;

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
                Forms\Components\DatePicker::make('tanggal_hafalan')
                    ->required(),
                Forms\Components\TextInput::make('nilai')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('ajaran')
                    ->required()
                    ->maxLength(4),
                Forms\Components\TextInput::make('semester')
                    ->required()
                    ->numeric(),
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
                Tables\Columns\TextColumn::make('tanggal_hafalan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('ajaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('semester')
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
            'index' => Pages\ListRiwayatHafalans::route('/'),
            'create' => Pages\CreateRiwayatHafalan::route('/create'),
            'edit' => Pages\EditRiwayatHafalan::route('/{record}/edit'),
        ];
    }
}
