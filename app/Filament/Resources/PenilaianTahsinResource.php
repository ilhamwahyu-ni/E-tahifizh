<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenilaianTahsinResource\Pages;
use App\Filament\Resources\PenilaianTahsinResource\RelationManagers;
use App\Models\PenilaianTahsin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenilaianTahsinResource extends Resource
{
    protected static ?string $model = PenilaianTahsin::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('siswa_id')
                    ->relationship('siswa', 'id')
                    ->required(),
                Forms\Components\Select::make('materi_tahsin_id')
                    ->relationship('materiTahsin', 'id')
                    ->required(),
                Forms\Components\Select::make('semester_id')
                    ->relationship('semester', 'id')
                    ->required(),
                Forms\Components\Select::make('tahun_ajaran_id')
                    ->relationship('tahunAjaran', 'id')
                    ->required(),
                Forms\Components\TextInput::make('nilai_angka')
                    ->numeric()
                    ->default(null),
                Forms\Components\DatePicker::make('tanggal_penilaian'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('siswa.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('materiTahsin.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tahunAjaran.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_angka')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_penilaian')
                    ->date()
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
            'index' => Pages\ListPenilaianTahsins::route('/'),
            'create' => Pages\CreatePenilaianTahsin::route('/create'),
            'edit' => Pages\EditPenilaianTahsin::route('/{record}/edit'),
        ];
    }
}
