<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MateriTahsinResource\Pages;
use App\Filament\Resources\MateriTahsinResource\RelationManagers;
use App\Models\MateriTahsin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MateriTahsinResource extends Resource
{
    protected static ?string $model = MateriTahsin::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Tahsin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kelas')
                    ->options([
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5',
                        6 => '6',
                    ])
                    ->required(),
                Forms\Components\Select::make('semester')
                    ->options([
                        1 => 'Ganjil',
                        2 => 'Genap',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('topik_materi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('urutan')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kelas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester')
                    ->formatStateUsing(fn(int $state): string => $state === 1 ? 'Ganjil' : 'Genap')
                    ->sortable(),
                Tables\Columns\TextColumn::make('topik_materi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('urutan')
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
            'index' => Pages\ListMateriTahsins::route('/'),
            'create' => Pages\CreateMateriTahsin::route('/create'),
            'edit' => Pages\EditMateriTahsin::route('/{record}/edit'),
        ];
    }
}
