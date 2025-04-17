<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Rombel;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model; // Add this import
use Illuminate\Support\Facades\Blade; // Add this import
use Barryvdh\DomPDF\Facade\Pdf; // Add this import
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RombelResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RombelResource\RelationManagers;
use App\Filament\Resources\RombelResource\RelationManagers\SiswaRelationManager;

class RombelResource extends Resource
{
    protected static ?string $model = Rombel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sekolah.nama')->disabled()
                    ->relationship('sekolah', 'nama')
                    ->required(),
                Forms\Components\Select::make('tahun_ajaran_id')->disabled()
                    ->relationship('tahunAjaran', 'nama')
                    ->required(),
                Forms\Components\Select::make('tm_kelas_id')
                    ->label('Kelas')
                    ->relationship('tmKelas', 'level')
                    ->required(),
                Forms\Components\TextInput::make('nama_rombongan')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('tmKelas.level')
                    ->label('Kelas')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_rombongan')
                    ->searchable(),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->color('success')

                    ->url(fn(Rombel $record) => route('pdf', $record))
                    ->openUrlInNewTab(),
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
            SiswaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRombels::route('/'),
            'create' => Pages\CreateRombel::route('/create'),
            'edit' => Pages\EditRombel::route('/{record}/edit'),
        ];
    }
}
